<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\members;
use App\Models\Payment;
use App\Models\Tempmpesa;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentsController extends Controller
{

    function __construct()
    {
        $this->middleware('auth')->except('callback');
        $this->payment = new Payment();
    }

    // function index()
    // {
    //     // $collection = Http::get('http://185.209.228.155:3000/api/payments/getAllPayments');
    //     // return json_encode($collection);
    //     return view('payments');
    // }

    function payments()
    {
        $transactions = Payment::with(['member:id,idNo,mobilePhoneNumber,firstName,secondName,surNameName', 'invoice:id,invoice_no'])->latest()->get();
        return $transactions;
    }

    function getlocalpayments()
    {
        $transactions = Payment::with(['member:id,idNo,mobilePhoneNumber,firstName,secondName,surNameName', 'invoice:id,invoice_no'])->latest()->get();
        return json_encode($transactions);
    }

    function store(Request $request)
    {
        $receiptno = DB::select(DB::raw('SELECT fn_generateReceiptNumber() AS result'));
        $validated = $request->validate([
            'members_id' => ['required', 'exists:members,id'],
            'invoice_id' => ['required', 'exists:invoices,id'],
            'amount' => ['required'],
            'date' => ['nullable', 'max:30'],
            'method' => ['required', 'max:30'],
            'description' => ['nullable', 'max:255'],
        ]);
        Payment::create($validated + ['invoice_id' => $request->invoice_id, 'receipt_no' => $receiptno[0]->result, 'ref_no' => $request->transact_no, 'user_id'=>auth()->id()]);
        return json_encode(['status' => 'success', 'message' => 'Payment saved successfully']);
    }

    function print($id)
    {
        $payment = Payment::with('member', 'invoice')->find($id);
        $pdf = PDF::loadView('receipt', ['payment' => $payment]);
        return $pdf->stream('document.pdf');
    }

    function mpesa(Request $request)
    {
        $validated = $request->validate([
            'members_id' => 'required',
            'invoice_id' => 'required',
            'phone' => 'required',
            'amount' => 'required',
        ]);
        $paymentRequest = Http::post('https://payments.aakenya.co.ke/api/stk/v2/makePayment', [
            'phone' => $validated["phone"],
            'amount' => 1,
            'description' => 'Payment for test app.',
            'callBackUrl' => 'http://aak-receipting.aakenya.co.ke/api/callback'
        ]);

        $data = json_decode($paymentRequest);
        if (isset($data->checkoutID) && !is_null($data->checkoutID)) {
            Tempmpesa::create([
                'members_id' => $validated['members_id'],
                'invoice_id' => $validated["invoice_id"],
                'phone' => $validated["phone"],
                'amount' => $validated["amount"],
                'description' => 'Payment for test app.',
                'checkoutid' => $data->checkoutID,
                'status' => 'pending',
                'user_id'=>auth()->id(),
            ]);
            return json_encode(['status' => 'success', 'message' => 'Payment initiated successfully, please check your phone and complete the transaction.']);
        } else {
            return json_encode(['status' => 'error', 'message' => 'Payment failed. Please retry']);
        }
    }

    function callback(Request $request)
    {
        Log::alert($request);
        $data = $request;
        Log::info($data);
        if (isset($data["mpesaReference"]) && !is_null($data["mpesaReference"])) {
            $payment = Tempmpesa::where('checkoutid', $data["checkoutID"])->first();
            if ($data->status === "SUCCESSFUL") {
                $payment = Tempmpesa::where('checkoutid', $data["checkoutID"])->first();
                $payment->update(['mpesareference' => $data["mpesaReference"], 'status' => $data["status"]]);
                $receiptno = DB::select(DB::raw('SELECT fn_generateReceiptNumber() AS result'));
                $rpayment = $this->payment->create([
                    'receipt_no' => $receiptno[0]->result,
                    'members_id' => $payment->members_id,
                    'ref_no' => $payment->mpesareference,
                    'method'=>'Mpesa',
                    'invoice_id' => $payment->invoice_id,
                    'amount' => $payment->amount,
                    'date' => date('Y-m-d'),
                    'description' => $payment->description,
                    'user_id'=>$payment->user_id
                ]);
                Log::alert($rpayment);
            } else {
                Log::alert('here we are');
            }
        } else {
            return $data;
        }
    }

    function apitest($payment_id) {
        $payment = $this->payment->find($payment_id);
        
        $data = json_encode(['data'=>[
            'IDNo' => $payment->member->idNo,
            'InvoiceNo' => $payment->invoice->invoice_no,
            'GL1' =>5337,
            'CustomerName' => $payment->member->firstName . ' ' . $payment->member->secondName . ' ' . $payment->member->surNameName,
            'CustomerEmail' => $payment->member->emailAddress,
            'PhoneNo' => $payment->member->mobilePhoneNumber,
            'ReceiptAmount' => $payment->amount,
            'Branch' => $payment->invoice->branch->name,
            'ReceiptNo' => $payment->receipt_no,
            'Narration' => $payment->description,
            'PostedBy' => $payment->user->name,
            'ExternalDocNo' => 245345646,
            'GLAmount' => $payment->invoice->amount,
            'InvoiceDate' => $payment->invoice->date,
            'ReceiptDate' => $payment->date,
            'Paymode' => $payment->method,
        ]]);
       
        $response = Http::withBasicAuth('integration', 'ieceePhaeshie9yo')
            ->post("http://197.248.13.206:7048/DynamicsNAV100/ODataV4/Company('AAKENYA%20LTD')/RRM", $data);
        return $response;
    }

}

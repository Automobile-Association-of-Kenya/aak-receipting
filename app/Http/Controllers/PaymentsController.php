<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\members;
use App\Models\Payment;
use App\Models\Tempmpesa;
use App\Models\trans_references;
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

    function payments()
    {
        $transactions = Payment::with(['member:id,idNo,mobilePhoneNumber,firstName,secondName,surNameName','invoice:id,invoice_no', 'user:id,name'])
                        ->latest()->get();
        return $transactions;
    }

    function getlocalpayments()
    {
        $transactions = Payment::with(['member:id,idNo,mobilePhoneNumber,firstName,secondName,surNameName', 'invoice:id,invoice_no'])->latest()->get();
        return json_encode($transactions);
    }

    public function fetchTransDetails()
    {
        $transactions = trans_references::select('TransID', 'TransAmount')
            ->orderBy('TransID', 'desc')
            ->get();
        return response()->json($transactions);
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
            'description' => ['required', 'max:50'],
            'ref_no'=>['required','unique:payments,ref_no']
        ]);
        Payment::create($validated + ['invoice_id' => $request->invoice_id, 'receipt_no' => $receiptno[0]->result, 'ref_no' => $request->ref_no, 'user_id' => auth()->id()]);
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
            'description' => 'required',
            'amount' => 'required',
        ]);

        $paymentRequest = Http::post('https://payments.aakenya.co.ke/api/stk/v2/makePayment', [
            'phone' => $validated["phone"],
            'amount' => $validated['amount'],
            'description' => $validated['description'],
            'callBackUrl' => 'https://aak-receipting.aakenya.co.ke/api/callback'
        ]);
        $data = json_decode($paymentRequest);
        if (isset($data->checkoutID) && !is_null($data->checkoutID)) {
            Tempmpesa::create([
                'members_id' => $validated['members_id'],
                'invoice_id' => $validated["invoice_id"],
                'phone' => $validated["phone"],
                'amount' => $validated["amount"],
                'description' => $validated["description"],
                'checkoutid' => $data->checkoutID,
                'status' => 'pending',
                'user_id' => auth()->id(),
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
                    'method' => 'MPESA',
                    'invoice_id' => $payment->invoice_id,
                    'amount' => $payment->amount,
                    'date' => date('Y-m-d'),
                    'description' => $payment->description,
                    'user_id' => $payment->user_id
                ]);
                Log::alert($rpayment);
            } else {
                Log::alert('here we are');
            }
        } else {
            return $data;
        }
    }
}

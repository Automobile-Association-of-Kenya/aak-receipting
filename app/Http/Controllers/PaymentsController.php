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
        Payment::create($validated + ['invoice_id' => $request->invoice_id, 'receipt_no' => $receiptno[0]->result, 'ref_no' => $request->transact_no, 'user_id' => auth()->id()]);
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
            'callBackUrl' => 'https://ff96-2c0f-fe38-2186-3ae5-5c83-fdc8-f5a4-5ff.ngrok-free.app/api/callback'
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
                    'method' => 'Mpesa',
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

    function apitest($payment_id)
    {
        $payment = $this->payment->find($payment_id);
        // $data = array(
        //     // "@odata.etag" => "W/\"JzgwO1djTUFBQUY3TVFBeUFETUFOQUExQURZQU53QTRBQUFBQVh0SkFFNEFWZ0F0QURFQU1nQXpBRFFBQUFBQmV6QUFNUUF4QURFQUFBQUFBQT09OTsxMjYxNzk1MDIwOyc=\"",
        //     'IDNo' => $payment->member->idNo,
        //     'InvoiceNo' => $payment->invoice->invoice_no,
        //     'GL1' => 509,
        //     'CustomerName' => $payment->member->firstName . ' ' . $payment->member->secondName . ' ' . $payment->member->surNameName,
        //     'CustomerEmail' => $payment->member->emailAddress,
        //     'PhoneNo' => $payment->member->mobilePhoneNumber,
        //     'ReceiptAmount' => (float)$payment->amount,
        //     'Branch' => $payment->invoice->branch->name,
        //     'ReceiptNo' => $payment->receipt_no,
        //     'Narration' => $payment->description,
        //     'PostedBy' => $payment->user->name,
        //     'ExternalDocNo' => $payment->ref_no,
        //     'GLAmount1' => (float)$payment->invoice->amount,
        //     'InvoiceDate' => $payment->invoice->date,
        //     'ReceiptDate' => $payment->date,
        //     'Paymode' => $payment->method,
        //     // "ETag" => "80;WcMAAAF7MQAyADMANAA1ADYANwA4AAAAAXtJAE4AVgAtADEAMgAzADQAAAABezAAMQAxADEAAAAAAA==9;1261795020;"
        // );


        $data = array(
            // "@odata.etag" => "W/\"JzgwO1djTUFBQUY3TVFBeUFETUFOQUExQURZQU53QTRBQUFBQVh0SkFFNEFWZ0F0QURFQU1nQXpBRFFBQUFBQmV6QUFNUUF4QURFQUFBQUFBQT09OTsxMjYxNzk1MDIwOyc=\"",
            "IDNo" => $payment->member->idNo,
            // "IDNo" => "5560949",
            "InvoiceNo" => $payment->invoice->invoice_no,
            // "InvoiceNo" => "INV0020",
            "GL1" => "509",
            // "GL1" => "null",
            "CustomerName" => $payment->member->firstName . ' ' . $payment->member->secondName . ' ' . $payment->member->surNameName,
            // "CustomerName" => "Kipkoech Birgen Kipkoech",
            "CustomerEmail" => $payment->member->emailAddress,
            // "CustomerEmail" => "john@john.co.ke",
            "PhoneNo" => $payment->member->mobilePhoneNumber,
            // "PhoneNo" => "0715614272",
            "ReceiptAmount" => (float)$payment->amount,
            // "ReceiptAmount" => 1200,
            "Branch" => $payment->invoice->branch->name,
            // "Branch" => "SARIT",
            "ReceiptNo" => $payment->receipt_no,
            // "ReceiptNo" => "RC-006",
            "Narration" => $payment->description,
            // "Narration" => "Payment for IDP",
            "PostedBy" => $payment->user->name,
            // "PostedBy" => "GODFREY TEST TEST",
            "ExternalDocNo" => $payment->ref_no,
            // "ExternalDocNo" => "SD455TYR674",
            "GLAmount1" => (float)$payment->invoice->amount,
            // "GLAmount1" => 5600,
            "InvoiceDate" => $payment->invoice->date,
            // "InvoiceDate" => "04/04/2024",
            "ReceiptDate" => $payment->date,
            // "ReceiptDate" => "04/04/2024",
            "Paymode" =>$payment->method 
            // "Paymode" => "MPESA"

            // "ETag" => "80;WcMAAAF7MQAyADMANAA1ADYANwA4AAAAAXtJAE4AVgAtADEAMgAzADQAAAABezAAMQAxADEAAAAAAA==9;1261795020;"
        );


        $response = Http::withBasicAuth('integration', 'ieceePhaeshie9yo')->post("http://197.248.13.206:7048/DynamicsNAV100/ODataV4/Company('AAKENYA%20LTD')/RRM", $data);
        return $response;
        $ch = curl_init();
        $url = "http://197.248.13.206:7048/DynamicsNAV100/ODataV4/Company('AAKENYA%20LTD')/RRM";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, 'integration:ieceePhaeshie9yo');
        //curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Connection: Keep-Alive',
            'Accept: application/json',
            'Content-Type: application/json; charset=utf-8',
            "Accept: /"
        ]);

        $jsonDataEncoded = json_encode($data);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
        }
        curl_close($ch);
        if (isset($error_msg)) {
            dd($error_msg);
        }
        dd($response);

        return $response;

        // {
        //     "@odata.etag": "W/\"JzgwO1djTUFBQUY3TVFBeUFETUFOQUExQURZQU53QTRBQUFBQVh0SkFFNEFWZ0F0QURFQU1nQXpBRFFBQUFBQmV6QUFNUUF4QURFQUFBQUFBQT09OTsxMjYxNzk1MDIwOyc=\"",
        //     "IDNo": "12345678",
        //     "InvoiceNo": "INV-1234",
        //     "GL1": "0111",
        //     "CustomerName": "ICT TEST1",
        //     "CustomerEmail": "aait@aakenya.co.ke",
        //     "PhoneNo": "0709933130",
        //     "ReceiptAmount": 10,
        //     "Branch": "RUAKA",
        //     "ReceiptNo": "RC-1234",
        //     "Narration": "IDP 3 MONTHS",
        //     "PostedBy": "WENDY KANAIZA",
        //     "ExternalDocNo": "SC12345678",
        //     "GLAmount1": 10,
        //     "InvoiceDate": "04/04/2024",
        //     "ReceiptDate": "04/04/2024",
        //     "Paymode": "PDQ",
        //     "ETag": "80;WcMAAAF7MQAyADMANAA1ADYANwA4AAAAAXtJAE4AVgAtADEAMgAzADQAAAABezAAMQAxADEAAAAAAA==9;1261795020;"
        //   },
    }
}

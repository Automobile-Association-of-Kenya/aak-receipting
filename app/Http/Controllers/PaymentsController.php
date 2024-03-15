<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\members;
use App\Models\Payment;
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
        $this->middleware('auth');
    }

    // function index()
    // {
    //     // $collection = Http::get('http://185.209.228.155:3000/api/payments/getAllPayments');
    //     // return json_encode($collection);
    //     return view('payments');
    // }

    function payments()
    {
        $transactions = Payment::with('member:id,idNo,mobilePhoneNumber,firstName,secondName,surNameName')->latest()->get();
        return $transactions;
    }

    function getlocalpayments()
    {
        $transactions = Payment::with('member:id,idNo,mobilePhoneNumber,firstName,secondName,surNameName')->latest()->get();
        return json_encode($transactions);
    }

    function store(Request $request)
    {
        $receiptno = DB::select(DB::raw('SELECT fn_generateReceiptNumber() AS result'));
        $validated = $request->validate([
            'members_id' => ['required', 'exists:members,id'],
            'amount' => ['required'],
            'date' => ['nullable', 'max:30'],
            'method' => ['required', 'max:30'],
            'description' => ['nullable', 'max:255'],
        ]);

        Payment::create($validated + ['invoice_id' => $request->invoice_id,'receipt_no' => $receiptno[0]->result, 'ref_no' => $request->transact_no]);

        return json_encode(['status' => 'success', 'message' => 'Payment saved successfully']);
    }

    function print($id)
    {
        $payment = Payment::with('member','invoice')->find($id);
        $pdf = PDF::loadView('receipt', ['payment' => $payment]);
        return $pdf->stream('document.pdf');
    }

    function mpesa(Request $request)
    {
        $request->validate([
            'mpesa_payment_member_id' => 'required',
            'payment_phone' => 'required',
            'mpesa_payment_amount' => 'required'
        ]);
        try {
            $payment = Payment::create([
                'members_id' => $request->mpesa_payment_member_id,
                'ref_no' => Str::random(5),
                'amount' => $request->mpesa_payment_amount,
                'date' => now(),
                'method' => 'Mpesa',
                'description' => 'Payment for Test App'
            ]);
            $paymentRequest = Http::post('http://185.209.228.155:4000/api/stk/makePayment', [
                'phone' => $request->payment_phone,
                'amount' => $request->mpesa_payment_amount,
                'description' => 'Payment for test app.'
            ]);
            if ($paymentRequest->successful()) {
                return redirect()->back()->with('stkSuccess', 'STK Request sent to the client successfully');
            } else {
                return redirect()->back()->with('stkError', 'STK Request failed. Please try again.');
            }
        } catch (Exception $e) {
            Log::critical($e);
            return redirect()->back()->with('stkError', 'STK Request failed. Please try again.');
        }
    }
}

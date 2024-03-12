<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\members;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

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
        $collection = Http::get('http://185.209.228.155:3000/api/payments/getAllPayments');
        return $collection;
    }

    function getlocalpayments()
    {
        $transactions = Payment::with('member:id,idNo,mobilePhoneNumber')->latest()->get();
        return json_encode($transactions);
    }

    function store(Request $request)
    {
        $validated = $request->validate([
            'members_id' => ['required', 'exists:members,id'],
            'amount' => ['required'],
            'date' => ['nullable', 'max:30'],
            'method' => ['required', 'max:30'],
            'description' => ['nullable', 'max:255'],
        ]);

        Payment::create($validated + ['ref_no' => $request->transact_no]);

        return json_encode(['status' => 'success', 'message' => 'Payment saved successfully']);
    }

    function print($id, $amount, $description, $member_id)
    {
        $member = members::where('idNo', $member_id)->first();
        $payment = Payment::with('member')->find($id);
        $pdf = PDF::loadView('receipt', ['payment' => $payment, 'member_id'=> $member_id,'amount'=>$amount, 'description'=> $description]);
        return $pdf->stream('document.pdf');
    }

    function mpesa(Request $request)
    {
    }
}

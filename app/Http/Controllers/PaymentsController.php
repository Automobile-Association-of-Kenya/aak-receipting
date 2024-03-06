<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
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

    function index() {
        // $collection = Http::get('http://185.209.228.155:3000/api/payments/getAllPayments');
        // return json_encode($collection);
        return view('payments');
    }

    function payments()
    {
        $collection= Http::get('http://185.209.228.155:3000/api/payments/getAllPayments');

        return $collection;
    }

    function store(Request $request) {
        $validated = $request->validate([
            'members_id' => ['required','exists:members,id'],
            'amount' => ['required'],
            'date' => ['nullable','max:30'],
            'method' => ['required','max:30'],
            'description'=>['nullable','max:255'],
        ]);

        Payment::create($validated+['ref_no'=>$request->transact_no]);
        
        return json_encode(['status'=>'success','message'=>'Payment saved successfully']);
    }

    function print($id) {
        $invoice = Invoice::with(['member', 'product'])->find($id);
        // return $invoice;
        $pdf = PDF::loadView('invoice', ['invoice' => $invoice]);

        // Output the generated PDF (inline or download)
        return $pdf->stream('document.pdf');
    }

    function mpesa(Request $request) {

    }

}

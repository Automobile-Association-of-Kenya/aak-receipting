<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Dompdf\Dompdf;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'members_id' => ['required', 'exists:members,id'],
            'product_id' => ['required', 'exists:products,id'],
            'amount' => ['required'],
            'date' => ['nullable'],
        ]);
        $invoice = Invoice::create($validated + ['status' => 'pending']);

        return json_encode(['status' => 'success', 'message' => 'Invoice created successfully']);
    }

    function invoices()
    {
        $invoices = Invoice::with(['member:id,idNo,surNameName,firstName,secondName', 'product:id,name'])->get();

        return json_encode($invoices);
    }

    function print($id)
    {
        $invoice = Invoice::with(['member', 'product'])->find($id);
        // return $invoice;
        $pdf = PDF::loadView('invoice', ['invoice'=>$invoice]);

        // Output the generated PDF (inline or download)
        return $pdf->stream('document.pdf');
    }
}

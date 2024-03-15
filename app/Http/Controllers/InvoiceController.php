<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Dompdf\Dompdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::with('product')->get();
        return $invoices;
    }

    function show($id) {
        $invoice = Invoice::find($id);
        return json_encode($invoice);
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
    Log::critical($request->all());
        $validated = $request->validate([
            'members_id' => ['required', 'exists:members,id'],
            'product_id' => ['required', 'exists:departments_products,id'],
            'amount' => ['required'],
            'date' => ['nullable'],
        ]);
        // Example using raw SQL query
        $invoiceno = DB::select(DB::raw('SELECT fn_generateInvoiceNumber() AS result'));
        try {
            $invoice = Invoice::create([
                'invoice_no' => $invoiceno[0]->result,
                'members_id' => $request->members_id,
                'departments_products_id' => $request->product_id,
                'amount' => $request->amount,
                'status' => 'pending',
                'date' => $request->date?? now()
            ]);
            return json_encode(['status' => 'success', 'message' => 'Invoice created successfully']);
        } catch (Exception $e) {
            Log::critical($e);
            return json_encode(['status' => 'error', 'message' => 'An expected error occurred.']);
        }
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
        // return $invoice;
        $pdf = PDF::loadView('invoice', ['invoice'=>$invoice]);

        // Output the generated PDF (inline or download)
        return $pdf->stream('document.pdf');
    }
}

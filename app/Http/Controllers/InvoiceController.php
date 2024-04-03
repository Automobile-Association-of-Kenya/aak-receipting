<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
<<<<<<< HEAD
use App\Models\InvoiceProduct;
=======
>>>>>>> 6ca1795e5d40cf2e63222e9b256f4797b59d89d6
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
<<<<<<< HEAD
        $invoices = Invoice::get();
        return $invoices;
    }

    function show($id)
    {
=======
        $invoices = Invoice::with('product')->get();
        return $invoices;
    }

    function show($id) {
>>>>>>> 6ca1795e5d40cf2e63222e9b256f4797b59d89d6
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
<<<<<<< HEAD
        Log::critical($request->all());
        $validated = $request->validate([
            'branch_id' => ['required', 'exists:branches,id'],
            'members_id' => ['required', 'exists:members,id'],
            'amount' => ['required'],
            'date' => ['nullable'],
        ]);
        // return $request->products;
        // Example using raw SQL query
        $invoiceno = DB::select(DB::raw('SELECT fn_generateInvoiceNumber() AS result'));
            $invoice = Invoice::create($validated + ['invoice_no' => $invoiceno[0]->result, 'status' => 'pending']);
            foreach ($request->products as $key => $value) {
                InvoiceProduct::create([
                    'invoice_id' => $invoice->id,
                    'departments_products_id' => $value["product_id"],
                    'amount' => $value["amount"],
                ]);
            }
            return json_encode(['status' => 'success', 'message' => 'Invoice created successfully']);

=======
    Log::critical($request->all());
        $validated = $request->validate([
            'branch_id'=>['required','exists:branches,id'],
            'members_id' => ['required', 'exists:members,id'],
            'departments_products_id' => ['required', 'exists:departments_products,id'],
            'amount' => ['required'],
            'date' => ['nullable'],
        ]);
        // Example using raw SQL query
        $invoiceno = DB::select(DB::raw('SELECT fn_generateInvoiceNumber() AS result'));
        try {
            $invoice = Invoice::create($validated+['invoice_no' => $invoiceno[0]->result,'status' => 'pending']);
            return json_encode(['status' => 'success', 'message' => 'Invoice created successfully']);
        } catch (Exception $e) {
            Log::critical($e);
            return json_encode(['status' => 'error', 'message' => 'An expected error occurred.']);
        }
>>>>>>> 6ca1795e5d40cf2e63222e9b256f4797b59d89d6
    }

    function invoices()
    {
<<<<<<< HEAD
        $invoices = Invoice::with(['member:id,idNo,surNameName,firstName,secondName', 'branch:id,name'])->latest()->get();
=======
        $invoices = Invoice::with(['member:id,idNo,surNameName,firstName,secondName', 'product:id,name','branch:id,name'])->latest()->get();
>>>>>>> 6ca1795e5d40cf2e63222e9b256f4797b59d89d6
        return json_encode($invoices);
    }

    function print($id)
    {
<<<<<<< HEAD
        $invoice = Invoice::with(['member', 'items.product'])->find($id);
        // return $invoice;
        // return $invoice;
        // return $invoice;
        $pdf = PDF::loadView('invoice', ['invoice' => $invoice]);
=======
        $invoice = Invoice::with(['member', 'product'])->find($id);
        // return $invoice;
        // return $invoice;
        $pdf = PDF::loadView('invoice', ['invoice'=>$invoice]);
>>>>>>> 6ca1795e5d40cf2e63222e9b256f4797b59d89d6

        // Output the generated PDF (inline or download)
        return $pdf->stream('document.pdf');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceProduct;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;
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
        $invoices = Invoice::get();
        return $invoices;
    }

    function show($id)
    {
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
            'branch_id' => ['required', 'exists:branches,id'],
            'members_id' => ['required', 'exists:members,id'],
            'amount' => ['required'],
            'sales_code' => ['required'],
            'date' => ['nullable'],
        ]);
        // return $request->products;
        // Example using raw SQL query
        $invoiceno = DB::select(DB::raw('SELECT fn_generateInvoiceNumber() AS result'));
        $invoice = Invoice::create($validated + ['invoice_no' => $invoiceno[0]->result, 'status' => 'pending','user_id'=>auth()->id()]);
        foreach ($request->products as $key => $value) {
            InvoiceProduct::create([
                'invoice_id' => $invoice->id,
                'departments_products_id' => $value["product_id"],
                'amount' => $value["amount"],
            ]);
        }
        return json_encode(['status' => 'success', 'message' => 'Invoice created successfully']);
    }

    function invoices()
    {
        $invoices = Invoice::with(['member:id,idNo,surNameName,firstName,secondName', 'branch:id,name','user:id,name'])->latest()->get();
        return json_encode($invoices);
    }

    function print($id)
    {
        $invoice = Invoice::with(['member', 'items.product'])->find($id);
        // return $invoice;
        // return $invoice;
        // return $invoice;
        $pdf = PDF::loadView('invoice', ['invoice' => $invoice]);

        // Output the generated PDF (inline or download)
        return $pdf->stream('document.pdf');
    }

    function invoicesSummary($year)
    {
        $data = [];
        $months = [];
        for ($i = 1; $i < 13; $i++) {
            $date = Carbon::create($year,$i,1);
            array_push($months, $date->format('Y-m'));
        }
        foreach ($months as $month) {
            $startTime = $month . '-01 00:00:00';
            $endTime = Carbon::createFromFormat('Y-m', $month)->endOfMonth()->format('Y-m-d') . ' 23:59:59';
            $invoice = DB::select("SELECT SUM(`amount`) as total FROM `invoices` WHERE `created_at` BETWEEN '$startTime' AND '$endTime'");
            $payment = DB::select("SELECT SUM(`amount`) as total FROM `payments` WHERE `created_at` BETWEEN '$startTime' AND '$endTime'");
            array_push($data,['month'=>date('M Y', strtotime($month)),'payments'=> $payment[0]->total,'invoices'=> $invoice[0]->total]);
        }
        return $data;
    }
}

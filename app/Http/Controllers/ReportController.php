<?php

namespace App\Http\Controllers;

use App\Exports\PaymentsExport;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->middleware('auth');
        return view('reports');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function generate(Request $request)
    {
        $payments = DB::select("CALL sp_generatereport(
            $request->department_id,
            $request->product_id,
            $request->start_date,
            $request->end_date,
            $request->branch_id)");
        $data = [];
        // return $payments;
        array_push($data, ['Branch', "Department", 'Date paid', 'Customer NO', 'Name', 'Invoice NO', 'Product/Service',  'Invoiced','Payment','Balance']);
        foreach ($payments as $key => $value) {
            $balance = floatval($value->invoice_amount) - floatval(@$value?->payment_amount ?? 0);
            array_push($data, [$value->branch_name, $value->department, $value->payment_date, $value->MembershipNumber ?? "", $value->member_name ?? "", $value->invoice_no, $value->product_name, $value->invoice_amount, @$value->payment_amount??0, $balance]);
        }
        return Excel::download(new PaymentsExport($data), 'payments.xlsx');
        // return json_encode($payments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

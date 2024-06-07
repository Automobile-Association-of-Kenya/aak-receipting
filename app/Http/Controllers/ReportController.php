<?php

namespace App\Http\Controllers;

use App\Exports\PaymentsExport;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }
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
        $start_date = $request->start_date . ' 00:00:00';
        $end_date = $request->end_date . ' 23:59:59';
        $payments = DB::select("CALL sp_generatereport(
            $request->department_id,
            $request->product_id,
            '$start_date',
            '$end_date',
            $request->branch_id)");
            // return$payments;
        $data = [];
        array_push($data, ['Branch', "Department", "Sales Person", 'Date paid', 'Customer NO', 'Name', 'Invoice NO', 'Product/Service',  'Invoiced', 'Payment', 'Balance']);
        foreach ($payments as $key => $value) {
            $balance = floatval($value->invoice_amount) - floatval(@$value?->payment_amount ?? 0);
            $surNameName = $value->surNameName==null?"":$value->surNameName;
            $firstName = $value->firstName==null?"":$value->firstName;
            $secondName = $value->secondName==null?"":$value->secondName;
            $MembershipNumber = $value->MembershipNumber==null?"":$value->MembershipNumber;
            $member_name = $surNameName. " " . $firstName. " " . $secondName;
            array_push($data, [$value->branch_name, $value->department, $value->sales_code, $value->payment_date, $MembershipNumber, $member_name, $value->invoice_no, $value->product_name, $value->invoice_amount, @$value->payment_amount ?? 0, $balance]);
        }
        return Excel::download(new PaymentsExport($data), 'payments.xlsx');
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

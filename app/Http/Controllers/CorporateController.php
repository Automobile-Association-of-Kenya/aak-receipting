<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\members;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CorporateController extends Controller
{
    function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('corporate');
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
    public function store(Request $request)
    {
        $request->validate([
            'id_number' => 'required|unique:members,idNo|string',
            'first_name' => 'required|string',
            'second_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'phone_number' => 'nullable|numeric|min:9',
            'status' => 'nullable|string',
            'member_number' => 'nullable|numeric',
            'email' => 'required|email'
        ]);
        $memberno = DB::select(DB::raw('SELECT fn_generateCustomerNumber() AS result'));
        try {
            members::create([
                'MembershipNumber' => $memberno[0]->result,
                'idNo' => $request->id_number,
                'surNameName' => $request->last_name,
                'firstName' => $request->first_name,
                'secondName' => $request->second_name,
                'memberStatus' => $request->status,
                'emailAddress' => $request->email,
                'mobilePhoneNumber' => $request->phone_number,
                'expiryDate' => $request->member_expiry_date
            ]);
            return json_encode(['status' => 'success', 'message' => 'Member created successfully']);
        } catch (Exception $e) {
            return json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }


    function getMemberinvoices($member_id)
    {
        $invoices = Invoice::where('members_id', $member_id)->get();
        return json_encode($invoices);
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

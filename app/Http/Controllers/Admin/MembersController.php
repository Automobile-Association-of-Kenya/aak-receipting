<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\members;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
<<<<<<< HEAD
use Illuminate\Support\Facades\DB;
=======
>>>>>>> 6ca1795e5d40cf2e63222e9b256f4797b59d89d6

class MembersController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
<<<<<<< HEAD
        return view('members.index');
=======
        $members = members::all();
        return view('members.index',compact('members'));
>>>>>>> 6ca1795e5d40cf2e63222e9b256f4797b59d89d6
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('members.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_number' => 'required|unique:members,idNo|numeric',
            'first_name' => 'required|string',
            'second_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'phone_number' => 'required|numeric|min:9',
            'status' => 'nullable|string',
            'member_number' => 'nullable|numeric',
            'email' => 'required|email'
        ]);
<<<<<<< HEAD
        $memberno = DB::select(DB::raw('SELECT fn_generateCustomerNumber() AS result'));
        try {
            members::create([
                'MembershipNumber' => $memberno[0]->result,
=======

        try {
            members::create([
                'MembershipNumber' => $request->member_number,
>>>>>>> 6ca1795e5d40cf2e63222e9b256f4797b59d89d6
                'idNo' => $request->id_number,
                'surNameName' => $request->last_name,
                'firstName' => $request->first_name,
                'secondName' => $request->second_name,
                'memberStatus' => $request->status,
                'emailAddress' => $request->email,
                'mobilePhoneNumber' => $request->phone_number,
                'expiryDate' => $request->member_expiry_date
            ]);
<<<<<<< HEAD
            return json_encode(['status' => 'success', 'message' => 'Member created successfully']);
        } catch (Exception $e) {
            return json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    function getMemberinvoices($member_id)
    {
        $invoices = Invoice::where('members_id', $member_id)->get();
=======
            return json_encode(['status'=>'success','message'=>'Member created successfully']);
        } catch (Exception $e) {
            return json_encode(['status'=>'error','message'=>$e->getMessage()]);
        }
    }

    function getMemberinvoices($member_id) {
        $invoices = Invoice::where('members_id',$member_id)->get();
>>>>>>> 6ca1795e5d40cf2e63222e9b256f4797b59d89d6
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

    function getmembers()
    {
        return json_encode(members::latest()->get());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
<<<<<<< HEAD
    public function get()
    {
        $members = members::latest()->get();
        return json_encode($members);
=======
    public function edit($id)
    {
        //
>>>>>>> 6ca1795e5d40cf2e63222e9b256f4797b59d89d6
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

<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\members;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Invoice;

class MembersController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $members = members::all();
        return view('members.index',compact('members'));
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

        try {
            members::create([
                'MembershipNumber' => $request->member_number,
                'idNo' => $request->id_number,
                'surNameName' => $request->last_name,
                'firstName' => $request->first_name,
                'secondName' => $request->second_name,
                'memberStatus' => $request->status,
                'emailAddress' => $request->email,
                'mobilePhoneNumber' => $request->phone_number,
                'expiryDate' => $request->member_expiry_date
            ]);
            return json_encode(['status'=>'success','message'=>'Member created successfully']);
        } catch (Exception $e) {
            return json_encode(['status'=>'error','message'=>$e->getMessage()]);
        }
    }

    function getMemberinvoices($member_id) {
        $invoices = Invoice::where('members_id',$member_id)->get();
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

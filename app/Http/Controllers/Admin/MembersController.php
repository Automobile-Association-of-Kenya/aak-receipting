<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\members;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


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

    public function searchByIdNo($idNo)
    {
        $member = members::where('idNo', $idNo)->first();
        if (!$member) {
            return response()->json(['error' => 'No member found with the provided ID Number.'], 404);
        }
    
        return response()->json([
            'success' => true,
            'message' => 'Member found successfully.',
            'member' => $member,
        ]);
    }
    

    public function filterByDate(Request $request)
{
    $validator = Validator::make($request->all(), [
        'startDate' => 'required|date',
        'endDate' => 'nullable|date|after_or_equal:startDate',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()->first()], 422);
    }

    $startDate = $request->input('startDate');
    $endDate = $request->input('endDate');

    if (is_null($endDate)) {
        $endDate = date('Y-m-d', strtotime('+100 years'));
    }

    $members = members::whereDate('created_at', '>=', $startDate)
                      ->whereDate('created_at', '<=', $endDate)
                      ->get();

    if ($members->isEmpty()) {
        return response()->json(['error' => 'No members found within the selected date range.'], 404);
    }

    return response()->json([
        'success' => true,
        'message' => 'Members filtered successfully.',
        'startDate' => $startDate,
        'endDate' => $endDate,
        'members' => $members,
        'token' => csrf_token(),
    ]);
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
            'id_number' => 'required|numeric|unique:members,idNo',
            'first_name' => 'required|string',
            'second_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'phone_number' => 'required|numeric|min:9',
            'status' => 'nullable|string',
            'member_number' => 'nullable|numeric',
            'email' => 'required|email|unique:members,emailAddress'
        ]);
    
        try {
            // Check if the idNo already exists
            $existingIdNo = members::where('idNo', $request->id_number)->first();
            if ($existingIdNo) {
                return response()->json(['status' => 'error', 'message' => 'ID Number already exists.'], 422);
            }
    
            // Check if the emailAddress already exists
            $existingEmail = members::where('emailAddress', $request->email)->first();
            if ($existingEmail) {
                return response()->json(['status' => 'error', 'message' => 'Email Address already exists.'], 422);
            }
    
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
            return response()->json(['status'=>'success','message'=>'Member created successfully']);
        } catch (Exception $e) {
            return response()->json(['status'=>'error','message'=>$e->getMessage()], 500);
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
        return json_encode(members::orderBy('id', 'desc')->get());
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

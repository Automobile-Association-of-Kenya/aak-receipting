<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\members;

class MembersController extends Controller
{
    // function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function store(Request $request)
    {
        return $request;
    }

    function member($idNo){
        return members::where("idNo",$idNo)->get();
    }

    function AddMember(Request $req) {
        $member= new members;
        $member->MembershipNumber=$req->MembershipNumber;
        $member->idNo=$req->idNo;
        $member->surNameName=$req->surNameName;
        $member->firstName=$req->firstName;
        $member->secondName=$req->secondName;
        $member->memberStatus=$req->memberStatus;
        $member->emailAddress=$req->emailAddress;
        $member->mobilePhoneNumber=$req->mobilePhoneNumber;
        $member->expiryDate=$req->expiryDate;
        $member->created_at=$req->created_at;
        $member->updated_at=$req->updated_at;

        $result=$member->save();
        if($result)
        {
            return ["Result"=>"Data has been saved"];
        }
        else
        {
            return ["Result"=>"Data has  not been saved"];
        }
    }
    function memberUpdate(Request $req)
    {


            $member= members ::find($req->id);
            $member->MembershipNumber=$req->MembershipNumber;
            $member->idNo=$req->idNo;
            $member->surNameName=$req->surNameName;
            $member->firstName=$req->firstName;
            $member->secondName=$req->secondName;
            $member->memberStatus=$req->memberStatus;
            $member->emailAddress=$req->emailAddress;
            $member->mobilePhoneNumber=$req->mobilePhoneNumber;
            $member->expiryDate=$req->expiryDate;
            $member->created_at=$req->created_at;
            $member->updated_at=$req->updated_at;

            $result=$member->save();
            if($result)
            {
                return ["Result"=>"Data has been Updated"];
            }
            else
            {
                return ["Result"=>"Data has  not been "];
            }


    }

    public function getMemberInfo(Request $request)
    {
        $idNo = $request->input('idNo');

        // Fetch member information based on the provided ID number
        $member = members::where("idNo", $idNo)->first();

        // Check if member exists
        if ($member) {
            return response()->json($member);
        } else {
            return response()->json(['error' => 'Member not found'], 404);
        }
    }

    function getmembers() {
        return json_encode(members::lastest()->get());
    }

}

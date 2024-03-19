<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member; // Assuming the model is named Member and not members

class MembersController extends Controller
{
    public function store(Request $request)
    {
        return $request;
    }

    function member($idNo)
    {
        return Member::where("idNo", $idNo)->get(); // Correcting the case of Member
    }

    function AddMember(Request $req)
    {
        $member = new Member; // Correcting the case of Member
        $member->MembershipNumber = $req->MembershipNumber;
        $member->idNo = $req->idNo;
        $member->surNameName = $req->surNameName;
        $member->firstName = $req->firstName;
        $member->secondName = $req->secondName;
        $member->memberStatus = $req->memberStatus;
        $member->emailAddress = $req->emailAddress;
        $member->mobilePhoneNumber = $req->mobilePhoneNumber;
        $member->expiryDate = $req->expiryDate;
        $member->created_at = $req->created_at;
        $member->updated_at = $req->updated_at;
        $result = $member->save();
        if ($result) {
            return ["Result" => "Data has been saved"];
        } else {
            return ["Result" => "Data has not been saved"]; // Correcting the typo
        }
    }

    function memberUpdate(Request $req)
    {
        $member = Member::find($req->id); // Correcting the case of Member
        $member->MembershipNumber = $req->MembershipNumber;
        $member->idNo = $req->idNo;
        $member->surNameName = $req->surNameName;
        $member->firstName = $req->firstName;
        $member->secondName = $req->secondName;
        $member->memberStatus = $req->memberStatus;
        $member->emailAddress = $req->emailAddress;
        $member->mobilePhoneNumber = $req->mobilePhoneNumber;
        $member->expiryDate = $req->expiryDate;
        $member->created_at = $req->created_at;
        $member->updated_at = $req->updated_at;
        $result = $member->save();
        if ($result) {
            return ["Result" => "Data has been Updated"];
        } else {
            return ["Result" => "Data has not been saved"]; // Correcting the typo
        }
    }

    public function getMemberInfo(Request $request)
    {
        $idNo = $request->input('idNo');
        $member = Member::where("idNo", $idNo)->first(); // Correcting the case of Member
        if ($member) {
            return response()->json($member);
        } else {
            return response()->json(['error' => 'Member not found'], 404);
        }
    }

    function getmembers()
    {
        return json_encode(Member::latest()->get()); // Correcting the case of Member
    }

    public function filterByDate(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        $members = Member::whereBetween('created_at', [$startDate, $endDate])->get(); // Correcting the case of Member

        return view('members.index', compact('members'));
    }

}

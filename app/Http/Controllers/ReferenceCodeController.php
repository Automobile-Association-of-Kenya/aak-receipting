<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\trans_references;

class ReferenceCodeController extends Controller
{
    public function add(Request $req)
{

    $validatedData = $req->validate([
        'MSISDN' => 'nullable|numeric',
        'TransID' => 'nullable|string|max:255',
        'TransAmount' => 'nullable|numeric',
        'BillRefNumber' => 'nullable|string|max:255',
    ]);

    // Check if the BillRefNumber contains the forbidden substring "AAK"
    if (strpos($validatedData['BillRefNumber'], 'AAK') === 0 && $validatedData['TransAmount'] >=600) {
        return response()->json(["error" => "BillRefNumber contains forbidden substring at the beginning and TransAmount is 1000 or more"], 400);
    }

    // Check if a reference with the same TransID already exists
    $existingReference = trans_references::where('TransID', $validatedData['TransID'])->first();

    if ($existingReference) {
        return response()->json(["error" => "Reference code already exists"], 400);
    }

    // Create a new reference record
    $reference = new trans_references;
    $reference->MSISDN = $validatedData['MSISDN'];
    $reference->TransID = $validatedData['TransID'];
    $reference->TransAmount = $validatedData['TransAmount'];
    $reference->BillRefNumber = $validatedData['BillRefNumber'];

    // Save the record and return appropriate response
    $result = $reference->save();

    if ($result) {
        return response()->json(["result" => "saved"], 201);
    } else {
        return response()->json(["error" => "not saved"], 500);
    }
}

}

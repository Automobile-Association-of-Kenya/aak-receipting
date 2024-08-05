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
            'MSISDN' => 'required|numeric',
            'TransID' => 'required|string|max:255',
            'TransAmount' => 'required|numeric',
            'BillRefNumber' => 'required|string|max:255',

        ]);

        if (strpos($validatedData['BillRefNumber'], 'AAK') !== false) {

            return response()->json(["error" => "BillRefNumber contains forbidden substring"], 400);
        }

        $existingReference = trans_references::where('MSISDN', $validatedData['TransID'])->first();

        if ($existingReference) {

            return response()->json(["error" => "Reference code already exists"], 400);
        }
        $reference = new trans_references;
        $reference->MSISDN = $validatedData['MSISDN'];
        $reference->TransID = $validatedData['TransID'];
        $reference->TransAmount = $validatedData['TransAmount'];
        $reference->BillRefNumber =$validatedData['BillRefNumber'];

        $result = $reference->save();

        if ($result) {

            return response()->json(["result" => "saved"], 201);
        } else {

            return response()->json(["error" => "not saved"], 500);
        }
    }
}

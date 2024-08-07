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


if (strpos($validatedData['BillRefNumber'], 'AAK') !== false) {
    if ($validatedData['TransAmount'] > 1000) {

        return response()->json(["message" => "BillRefNumber contains forbidden substring but amount is valid"], 200);
    } else {

        return response()->json(["error" => "BillRefNumber contains forbidden substring and amount is too high"], 400);
    }
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

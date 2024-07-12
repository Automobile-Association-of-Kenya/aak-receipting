<?php

namespace App\Http\Controllers;
use App\Models\CreditNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Http;

class CreditNoteController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'creditNumber' => 'required|string|max:255',
            'customerNumber' => 'required|string|max:255',
            'customerName' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'reason' => 'required|string',
        ]);

        $existingcreditnote =  credit_notes::where('creditNumber', $request-> creditNumber)->first();
        if ($existingcreditnote) {
            throw ValidationException::withMessages([
                'creditNumber' => ['The sales code already exists. Please try with a different sales code.'],
            ]);
        }

        credit_notes::create([
            'creditNumber' => $request->creditNumber,
            'customerNumber' => $request->customerNumber,
            'customerName' => $request->customerName,
            'amount' => $request->amount,
            'reason' => $request->reason,
        ]);

        return json_encode(['status'=>'success','message'=> 'Credit Note added successfully!']);
    }
}

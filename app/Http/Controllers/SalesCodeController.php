<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\SalesCode;

class SalesCodeController extends Controller
{
    //
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'sales_code' => 'required|unique:sales_codes',
        ]);

        // Check if the sales code already exists in the database
        $existingSalesCode = SalesCode::where('sales_code', $request->sales_code)->first();
        if ($existingSalesCode) {
            throw ValidationException::withMessages([
                'sales_code' => ['The sales code already exists. Please try with a different sales code.'],
            ]);
        }

        // If the sales code is unique, proceed to store it
        SalesCode::create([
            'name' => $request->name,
            'sales_code' => $request->sales_code,
        ]);

        return redirect()->back()->with('success', 'Sales code added successfully!');
    }
}

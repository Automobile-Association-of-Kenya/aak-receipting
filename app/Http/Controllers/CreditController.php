<?php

namespace App\Http\Controllers;
use App\Models\Credit;

use Illuminate\Http\Request;

class CreditController extends Controller

{ 
    public function index()
    {
        // Fetch credits data from the database and pass to the view
        $credits = Credit::orderBy('created_at', 'desc')->get();
        return view('credits', compact('credits'));
    }

    public function store(Request $request)
    {
        // Validate the input data
        try {
            $request->validate([
                'credit_no' => 'required|unique:credits,credit_no',
                'customer_no' => 'required|unique:credits,customer_no',
                'customer_name' => 'required',
                'amount' => 'required|numeric',
                'reasons' => 'required'
            ]);

            // If validation passes, proceed to store the credit data
            Credit::create([
                'credit_no' => $request->credit_no,
                'customer_no' => $request->customer_no,
                'customer_name' => $request->customer_name,
                'amount' => $request->amount,
                'reasons' => $request->reasons,
            ]);

            return redirect()->back()->with('success', 'Credit added successfully!');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }
}

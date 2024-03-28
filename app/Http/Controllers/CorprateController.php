<?php

namespace App\Http\Controllers;

use App\Models\Corprate;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CorprateController extends Controller
{
    public function index()
    {
        $corprates = Corprate::all();
        return view('corprate', compact('corprates'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:corprates,name'
            // 'customerNo' => 'required|unique:corprates,customerNo'
            
        ]);
        try {
            Corprate::create([
                'name' => $request->name,
                'customer_no' => $request->customerNo,
                'created_by_id' => Auth::user()->id
            ]);
            return redirect()->back()->with('success','Corprate created successfully.');
        } catch (Exception $e) {
            Log::critical($e);
            return redirect()->back()->with('exception','An unexpected error occurred. Please try again.');
        }
    }

    public function show(Corprate $corprate)
    {
        //
    }
    public function update(Request $request, Corprate $corprate)
    {
        //
    }

    public function destroy(Corprate $corprate)
    {
        //
    }

}



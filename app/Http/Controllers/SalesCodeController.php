<?php

namespace App\Http\Controllers;

use App\Models\SalesCode;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SalesCodeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Fetch sales codes data from the database and paginate
        $salescodes = SalesCode::orderBy('created_at', 'desc')->get();
        return view('salescode', compact('salescodes'));
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Handle form creation if needed
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'sales_code' => 'required|unique:sales_codes',
        ]);
    
        // Check if the sales code already exists in the database
        $existingSalesCode = SalesCode::where('sales_code', $request->sales_code)->first();
        if ($existingSalesCode) {
            return redirect()->back()->withErrors(['sales_code' => 'The sales code already exists. Please try with a different sales code.'])->withInput();
        }
    
        // If the sales code is unique, proceed to store it
        SalesCode::create([
            'name' => $request->name,
            'sales_code' => $request->sales_code,
        ]);
    
        return redirect()->back()->with('success', 'Sales code added successfully!');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Handle showing a specific resource if needed
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Handle form editing if needed
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
        // Handle updating a resource if needed
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Handle deleting a resource if needed
    }
}

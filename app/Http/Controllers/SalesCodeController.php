<?php

namespace App\Http\Controllers;

use App\Models\SalesCode;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SalesCodeController extends Controller
{
    function __construct()
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
        $salescodes = SalesCode::latest()->get();
        return view('salescode',compact('salescodes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
            throw ValidationException::withMessages([
                'sales_code' => ['The sales code already exists. Please try with a different sales code.'],
            ]);
        }

        // If the sales code is unique, proceed to store it
        SalesCode::create([
            'name' => $request->name,
            'sales_code' => $request->sales_code,
        ]);

        return json_encode(['status'=>'success','message'=> 'Sales code added successfully!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

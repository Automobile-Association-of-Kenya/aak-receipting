<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
<<<<<<< HEAD
        // $branches = Branch::all();
        return view('branches.index');
=======
        $branches = Branch::all();
        return view('branches.index',compact('branches'));
>>>>>>> 6ca1795e5d40cf2e63222e9b256f4797b59d89d6
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
            'name' => 'required|unique:branches,name,branch_code'
        ]);
<<<<<<< HEAD
        Branch::create([
            'name' => $request->name,
            'branch_code' => $request->branch_code,
            'created_by_id' => Auth::user()->id
        ]);
        return json_encode(['status' => 'success', 'message' => 'Branch created successfully.']);
=======
        try {
            Branch::create([
                'name' => $request->name,
                'branch_code' => $request->branch_code,
                'created_by_id' => Auth::user()->id
            ]);
            return redirect()->back()->with('success','Branch created successfully.');
        } catch (Exception $e) {
            Log::critical($e);
            return redirect()->back()->with('exception','An unexpected error occurred. Please try again.');
        }
>>>>>>> 6ca1795e5d40cf2e63222e9b256f4797b59d89d6
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function show(Branch $branch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Branch $branch)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Branch $branch)
    {
        //
    }
}

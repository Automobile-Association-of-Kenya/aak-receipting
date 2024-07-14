<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Performance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function showHome()
    {
        return view('home.home');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/dashboard');
        }

        return redirect()->back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function targets()
    {
        $startOfYear = Carbon::now()->startOfYear()->format('Y-m-d');
        return view('auth.sales', compact('startOfYear'));
    }

    public function getTotalTarget()
    {
        $overallTargets = Performance::where('sales_code', auth()->user()->sales_code)->sum('overall_targets');
        return response()->json(['totalTarget' => $overallTargets]);
    }

    public function getPerformanceToDate(Request $request)
    {
        $startDate = $request->query('startDate');
        $endDate = $request->query('endDate');
        $performanceData = Performance::whereBetween('created_at', [$startDate, $endDate])->get();
        $performanceData = [
            'performanceToDate' => 90000, // Replace with actual data
        ];

        return response()->json($performanceData);
    }

    public function fetchResult(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        $result = Performance::whereBetween('date_column', [$startDate, $endDate])
            ->sum('amount');



        return response()->json(['result' => $result]);
    }

    public function signupSalesCode()
    {
        return view('home.signup-sales-code');
    }

    public function loginSalesCode()
    {
        return view('home.login-sales-code');
    }

    function salesPersonTarget()
    {
        // $filter = "\$filter=Code eq 'AASC000453'";
        // $url = "http://197.248.13.206:7048/DynamicsNAV100/ODataV4/Company('AAKENYA%20LTD')/SalespersonRRM?$filter";
        // $response = Http::withBasicAuth('integration', 'ieceePhaeshie9yo')->get($url);
        // return $response;
        $target = Performance::where('sales_code',auth()->user()->sales_code)->where('year',date('Y'))->first();
        return json_encode($target);
    }

    function getSalesByPeriodRange(Request $request)
    {
        $start_date = date("m", strtotime($request->start_date)) . date("d", strtotime($request->start_date)) . date("y", strtotime($request->start_date)) . "D";
        $end_date = date("m", strtotime($request->end_date)) . date("d", strtotime($request->end_date)) . date("y", strtotime($request->end_date)) . "D";
        $response = Http::withBasicAuth('integration', 'ieceePhaeshie9yo')
            ->get("http://197.248.13.206:7048/DynamicsNAV100/ODataV4/Company('AAKENYA%20LTD')/SalespersonRRM?\$filter=Code eq '".auth()->user()->sales_code."' and Date_Filter gt '" . $start_date . "' and Date_Filter lt '" . $end_date . "'");
        return $response;
    }

    function getMonthlyPerfomance(Request $request)
    {
        $data = [];
        $months = [];
        for ($i = 1; $i < 13; $i++) {
            $date = Carbon::create($request->year, $i, 1);
            array_push($months, $date->format('Y-m'));
        }

        foreach ($months as $month) {
            $startTime = Carbon::createFromFormat('Y-m', $month)->startOfMonth()->format('Y-m-d');
            $endTime = Carbon::createFromFormat('Y-m', $month)->endOfMonth()->format('Y-m-d');
            $start_date = date("m", strtotime($startTime)) . date("d", strtotime($startTime)) . date("y", strtotime($startTime)) . "D";
            $end_date = date("m", strtotime($endTime)) . date("d", strtotime($endTime)) . date("y", strtotime($endTime)) . "D";
            $response = Http::withBasicAuth('integration', 'ieceePhaeshie9yo')
                ->get("http://197.248.13.206:7048/DynamicsNAV100/ODataV4/Company('AAKENYA%20LTD')/SalespersonRRM?\$filter=Code eq '" . auth()->user()->sales_code . "' and Date_Filter gt '" . $start_date . "' and Date_Filter lt '" . $end_date . "'");
            $value = json_decode($response);
            array_push($data, ['month' => date('M Y', strtotime($month)), 'amount' => $value->value[0]->Amounts]);
        }

        return $data;
    }
}

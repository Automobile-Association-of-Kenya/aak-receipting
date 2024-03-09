<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departments;
use App\Models\Departments_products;
use App\Models\members;
use App\Models\Product;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Http;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    function overview()
    {
        return view('home');
    }

    function transactions()
    {
        return view('transactions');
    }

    public function show()

    {
        $data = Departments::all();
        return view('service.create', ['data' => $data]);
    }

    public function summary()
    {
        $payments = collect(Http::get('http://185.209.228.155:3000/api/payments/getAllPayments'));
        $todaypayments = $payments->where('date_created', date('Y-m-d'));
        $todaypaymentscount = $todaypayments->count();
        $todaypaymentstotal = $todaypayments->sum('amount');
        $totalpayments = $payments->sum("amount");
        $members = members::count();
        $todaymembers = members::whereDate('created_at', date('Y-m-d'))->count();
        $expiredmembers = members::whereDate('expiryDate', '<', date('Y-m-d'))->count();
        return ['todaypaymentscount' => $todaypaymentscount, 'todaypaymentstotal' => $todaypaymentstotal, 'totalpayments' => $totalpayments, 'members' => $members, 'todaymembers' => $todaymembers, 'expiredmembers' => $expiredmembers];
    }

    function getdepartmentservices($department_id)
    {
        $products = Departments_products::where('departments_id', $department_id)->get();
        return json_encode($products);
    }

    function getproducts()
    {
        $products = Departments_products::get();
        return json_encode($products);
    }

    function getproductbyid($id)
    {
        $product = Departments_products::find($id);
        return json_encode($product);
    }

    function getdepartments()
    {
        $departments = Departments::get();
        return json_encode($departments);
    }

    function settings()
    {
        return view('settings');
    }
}

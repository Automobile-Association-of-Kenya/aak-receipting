<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use App\Models\Departments;
use App\Models\Departments_products;
use App\Models\Invoice;
use App\Models\members;
use App\Models\Payment;
use App\Models\Product;
use App\Models\SalesCode;
use App\Models\User;
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
        $total_customers = members::count();
        $total_invoices = Invoice::count();
        $total_payments = Payment::sum('amount');
        $total_users = User::count();
        return view('home', compact('total_customers', 'total_invoices', 'total_payments', 'total_users'));
    }

    function overview()
    {
        if (auth()->user()->role === "sale") {
            return redirect('sales');
        }
        return view('home');
    }

    function transactions()
    {
        $sales = User::where('role', 'sale')->get();
        return view('transactions', compact('sales'));
    }

    public function show()

    {
        $data = Departments::all();
        return view('service.create', ['data' => $data]);
    }

    public function summary()
    {
        $payments = Payment::get();
        $todaypayments = Payment::where('date', date('Y-m-d'))->sum('amount');
        $todaypaymentscount = Payment::whereDate('date', date('Y-m-d'))->count();
        $todaypaymentstotal = Payment::whereDate('date', date('Y-m-d'))->sum('amount');
        $totalpayments = $payments->sum("amount");
        $members = members::count();
        $todaymembers = members::whereDate('created_at', date('Y-m-d'))->count();
        $expiredmembers = members::whereDate('expiryDate', '<', date('Y-m-d'))->count();
        $invoicestotal = Invoice::sum('amount');
        $invoicetoday = Invoice::whereDate('date', date('Y-m-d'))->sum('amount');
        $todayivoicescount = Invoice::whereDate('date', date('Y-m-d'))->count();
        $usercount = User::count();
        $userscounttoday = User::whereDate('created_at', date('Y-m-d'))->count();
        return ['todaypaymentscount' => $todaypaymentscount, 'usercount' => $usercount, 'userscounttoday' => $userscounttoday, 'todayivoicescount' => $todayivoicescount, 'invoicestotal' => $invoicestotal, 'invoicetoday' => $invoicetoday, 'todaypaymentstotal' => $todaypaymentstotal, 'totalpayments' => $totalpayments, 'members' => $members, 'todaymembers' => $todaymembers, 'expiredmembers' => $expiredmembers];
    }

    function getdepartmentservices($department_id)
    {
        $products = Departments_products::where('departments_id', $department_id)->get();
        return json_encode($products);
    }

    function getproducts()
    {
        $products = Departments_products::with('department:id,name')->get();
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

    function getBranches()
    {
        $branches = Branch::with('user')->latest()->get();
        return json_encode($branches);
    }

    function getUsers()
    {
        $users = User::latest()->get();
        return json_encode($users);
    }
}

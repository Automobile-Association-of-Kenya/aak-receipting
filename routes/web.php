<?php

use App\Http\Controllers\Admin\MembersController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CorporateController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SalesCodeController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controller\CreditNoteController;
use App\Http\Controller\PerformanceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/', [MembersController::class, 'index']);

Route::get('/', [DashboardController::class, 'showHome'])->name('home');

// Route::get('/payments', function () {
//     return view('payments');
// });
Route::get('/flights', function () {
    return view('flight');
});

Route::resource('members', MembersController::class)->middleware(['admin', 'cea']);
Route::get('members-data', [MembersController::class, 'getmembers']);
Route::get('products-data', [HomeController::class, 'getproducts']);
Route::get('products/{id}', [HomeController::class, 'getproductbyid']);
Route::get('departments-data', [HomeController::class, 'getdepartments']);

Route::get('/sales', [DashboardController::class, 'targets'])->middleware(['auth', 'sale']);
Route::get('/signup', [DashboardController::class, 'signup']);
// Route::post('/creditnote', [CreditNoteController::class, 'store'])->name('creditnote');
Route::get('/total-target', [DashboardController::class, 'getTotalTarget'])->name('api.total-target');
Route::get('/performance-to-date', [DashboardController::class, 'fetchResult'])->name('api.performance-to-date');
Route::get('/login-performance', [DashboardController::class, 'targets'])->name('login');
Route::post('/login-sales-code', [DashboardController::class, 'loginSalesCode'])->name('salesCode');
Route::get('/signup-sales-code', [DashboardController::class, 'signupSalesCode'])->name('signupSalescode');


Route::get('member-invoices/{id}', [MembersController::class, 'getMemberinvoices']);

Route::resource('products', ProductController::class)->middleware('admin');

Route::get('branches-data', [HomeController::class, 'getBranches']);
Route::get('users-data', [HomeController::class, 'getUsers']);

Route::resource('invoices', InvoiceController::class)->middleware(['admin', 'cea']);
// Route::get('invoices/{id}', [InvoiceController::class,'edit']);
Route::get('invoices-data', [InvoiceController::class, 'invoices']);
Route::get('invoice-print/{id}', [InvoiceController::class, 'print']);

Route::get('overview', [HomeController::class, 'overview'])->name('overview');
Route::get('summary', [HomeController::class, 'summary']);

Route::get('/create', [App\Http\Controllers\HomeController::class, 'show'])->name('service');
Route::get('/create', [HomeController::class, 'fetch'])->name('amount');

// Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('payments', PaymentsController::class)->middleware(['admin', 'cea']);
Route::get('/payments-data', [PaymentsController::class, 'payments']);
Route::get('/payments-local', [PaymentsController::class, 'getlocalpayments']);
Route::post('/payments/mpesa', [PaymentsController::class, 'mpesa']);
Route::get('/payment-print/{id}', [PaymentsController::class, 'print']);
Route::post('/payment-mpesa', [PaymentsController::class, 'mpesa'])->name('payment.mpesa');
Route::get('/apitest/{id}', [PaymentsController::class, 'apitest']);

Route::get('transactions', [HomeController::class, 'transactions'])->name('transactions')->middleware(['admin', 'cea']);

Route::get('department-services/{dptid}', [HomeController::class, 'getdepartmentservices']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('settings', [HomeController::class, 'settings'])->name('settings')->middleware('admin');
Route::resource('users', UserController::class)->middleware('admin');
Route::resource('branches', BranchController::class)->middleware('admin');


Route::resource('corporates', CorporateController::class)->middleware('admin');
Route::resource('salescodes', SalesCodeController::class);
Route::get('reports', [ReportController::class, 'index'])->name('reports');
Route::post('reports-generete', [ReportController::class, 'generate'])->name('reports.generete');
Route::get('invoices-payments-summary/{year}', [InvoiceController::class, 'invoicesSummary']);
Route::get('sales-person', [DashboardController::class, 'salesPersonTarget']);
Route::post('sales-filter', [DashboardController::class, 'getSalesByPeriodRange']);
Route::post('monthly-perfomance', [DashboardController::class, 'getMonthlyPerfomance']);
require __DIR__ . '/auth.php';

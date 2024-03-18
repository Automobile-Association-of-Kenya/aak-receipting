<?php

use App\Http\Controllers\Admin\MembersController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\FlightsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Models\members;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


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

Route::get('/', [MembersController::class, 'index']);

// Route::get('/payments', function () {
//     return view('payments');
// });
Route::get('/flights', function () {
    return view('flight');
});

Route::resource('members', MembersController::class);
Route::get('members-data', [MembersController::class, 'getmembers']);
Route::get('products-data', [HomeController::class, 'getproducts']);
Route::get('products/{id}', [HomeController::class, 'getproductbyid']);
Route::get('departments-data', [HomeController::class, 'getdepartments']);

Route::get('member-invoices/{id}', [MembersController::class,'getMemberinvoices']);
Route::post('members/filterByDate', [App\Http\Controllers\Admin\MembersController::class, 'filterByDate'])->name('members.filterByDate');
Route::post('/members/checkIdNumber', 'Admin\MembersController@checkIdNumber')->name('members.checkIdNumber');
Route::post('/members/checkEmailAddress', 'Admin\MembersController@checkEmailAddress')->name('members.checkEmailAddress');


Route::resource('products', ProductController::class);


Route::resource('invoices', InvoiceController::class);
// Route::get('invoices/{id}', [InvoiceController::class,'edit']);
Route::get('invoices-data', [InvoiceController::class, 'invoices']);
Route::get('invoice-print/{id}', [InvoiceController::class, 'print']);

Route::get('overview', [HomeController::class, 'overview'])->name('overview');
Route::get('summary', [HomeController::class, 'summary']);

Route::get('/create', [App\Http\Controllers\HomeController::class, 'show'])->name('service');
Route::get('/create', [HomeController::class, 'fetch'])->name('amount');

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('payments', PaymentsController::class);
Route::get('/payments-data', [PaymentsController::class, 'payments']);
Route::get('/payments-local', [PaymentsController::class, 'getlocalpayments']);
Route::post('/payments/mpesa', [PaymentsController::class, 'mpesa']);
Route::get('/payment-print/{id}', [PaymentsController::class, 'print']);
Route::post('/payment-mpesa', [PaymentsController::class, 'mpesa'])->name('payment.mpesa');

Route::get('/flights', [FlightsController::class, 'getAllFlights']);
Route::get('transactions', [HomeController::class, 'transactions'])->name('transactions');

Route::get('department-services/{dptid}', [HomeController::class, 'getdepartmentservices']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('settings', [HomeController::class, 'settings'])->name('settings');
Route::resource('users',UserController::class);
Route::resource('branches',BranchController::class);

require __DIR__ . '/auth.php';

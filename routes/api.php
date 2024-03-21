<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MembersController;
use App\Http\Controllers\FlightsController;
use App\Http\Controllers\PaymentsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/




Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();



});

Route::get("members/{idNo}", [MembersController::class,'member']);
Route::post("addflight",[FlightsController::class, 'addFlight']);
Route::get("flights/{memberId}", [FlightsController::class,'getFlight']);
Route::post("addmember", [MembersController::class, 'AddMember']);
Route::get("payments" , [PaymentsController::class, 'payments']);
Route::get("flights", [FlightsController::class, 'getAllFlights']);


Route::post("callbackurl", [PaymentsController::class, 'callurl']);





<?php

use App\Http\Controllers\API\DefaultController;
use App\Http\Controllers\API\DeliveryController;
use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login', [LoginController::class, 'authenticateUser'])->name('login');
Route::post('/register', [RegisterController::class, 'registerUser'])->name('register');
Route::get('/package-types', [DefaultController::class, 'getPackageTypes'])->name('package-types');
Route::get('/payment-types', [DefaultController::class, 'getPaymentTypes'])->name('payment-types');

Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::post('/new-delivery', [DeliveryController::class, 'newDelivery'])->name('new-delivery');
});
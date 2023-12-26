<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Service\CategoryServiceController;
use App\Http\Controllers\Service\ServiceController;
use Illuminate\Support\Facades\Auth;
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
Route::get('login',[AuthController::class, 'index']);
Route::post('login',[AuthController::class, 'verify']);
Route::resource('category-service', CategoryServiceController::class);
Route::resource('service', ServiceController::class);
Route::get('/', function () {
    return view('dashboard');
});

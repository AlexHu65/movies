<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MovieController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:api')->group( function () {
    Route::resource('movies', MovieController::class);
});

Route::controller(AuthController::class)->group(function () {
    Route::get('login/me', 'me');
    Route::post('login', 'login');
    Route::get('logout', 'logout');
});

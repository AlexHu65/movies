<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MovieController;
use App\Http\Controllers\Api\PlaceController;

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

    Route::resource('movies', MovieController::class)->except(['update']);
    Route::resource('places', PlaceController::class)->except(['update']);
    
    //Multiform update
    Route::post('movies/{movie}', [MovieController::class, 'update']);
    Route::post('places/{movie}', [PlaceController::class, 'update']);

    Route::get('movies/disable/{movie}', [MovieController::class, 'disable']);
    Route::post('movies/assign/{movie}', [MovieController::class, 'assignPlaces']);

    Route::get('places/disable/{place}', [PlaceController::class, 'disable']);
    Route::get('places/get/all', [PlaceController::class, 'all']);

});

Route::controller(AuthController::class)->group(function () {
    Route::get('login/me', 'me');
    Route::post('login', 'login');
    Route::get('logout', 'logout');
});

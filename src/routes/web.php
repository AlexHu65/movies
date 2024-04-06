<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\MovieController;
use App\Http\Controllers\Web\PlaceController;

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

    Route::get('/' , function(){
        return view('login.index');
    });

    Route::get('/dashboard' , [DashboardController::class, 'index']);

    Route::resource('dashboard/movies', MovieController::class);
    Route::resource('dashboard/places', PlaceController::class);




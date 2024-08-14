<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ForecastController;
use App\Http\Controllers\UserController;
Route::get('/', function () {
    return view('layouts.main');
});

Route::get('/forecast',[ForecastController::class, 'index'])->name('forecast.index');
Route::post('/forecast_post',[ForecastController::class, 'store'])->name('forecast.store');

Route::resource('users', UserController::class,['names'=>[
    'index'=>'users.index',   
    'store'=>'users.store',
],'only' => ['index', 'store']]);
Route::post('/update_user',[UserController::class, 'update_user'])->name('update_user');

Route::get('/token', function () {
    return csrf_token(); 
});
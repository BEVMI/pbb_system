<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ForecastController;
use App\Http\Controllers\UserController;

Route::get('/', ['middleware' => 'guest', function()
{
    return redirect('/login')->with('danger','YOUR ARE ALREADY LOG IN');
}]);

Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');;

Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
    'confirm'=>false, // Password Confirm
]);
Route::middleware([IsActive::class])->group(function () {
    Route::group(['middleware' => 'auth'], function () {
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
    });
});

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

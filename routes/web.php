<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ForecastController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PoComplianceController;
use App\Http\Controllers\InventoryMaterials;
use App\Http\Controllers\InventoriesFGController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\PmController;
use App\Http\Controllers\MrpController;

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
        // FORECAST ROUTES
        Route::get('/forecast',[ForecastController::class, 'index'])->name('forecast.index');
        Route::post('/forecast_post',[ForecastController::class, 'store'])->name('forecast.store');
        Route::post('/forecast_check',[ForecastController::class, 'check'])->name('forecast.check');
        Route::post('/pbb_stockcode',[ForecastController::class, 'pbb_stockcode'])->name('pbb.stockcode');
        // END FORECAST ROUTES

        // PO COMPLIANCE ROUTES
        Route::get('/pocompliance',[PoComplianceController::class, 'index'])->name('pocompliance.index');
        // END PO COMPLIANCE ROUTES
        
        // USER ROUTES
        Route::resource('users', UserController::class,['names'=>[
            'index'=>'users.index',   
            'store'=>'users.store',
        ],'only' => ['index', 'store']]);
        Route::post('/update_user',[UserController::class, 'update_user'])->name('update_user');
        Route::get('/token', function () {
            return csrf_token(); 
        });
        // END USER ROUTES

        // INVENTORY MATERIALS
        Route::get('/inventorymaterials',[InventoryMaterials::class, 'index'])->name('inventorymaterials.index');
        // END INVENTORY MATERIALS

        // INVENTORY MATERIALS
        Route::get('/inventoryfg',[InventoriesFGController::class, 'index'])->name('inventoryfg.index');
        // END INVENTORY MATERIALS

        // PLAN
        Route::group(['middleware' => 'IsLine1'], function () {
            Route::get('/plan_line_1',[PlanController::class, 'index'])->name('plan_line1.index');
        });
        Route::group(['middleware' => 'IsLine2'], function () {
            Route::get('/plan_line_2',[PlanController::class, 'line_2'])->name('plan_line2.index');
        });
        Route::group(['middleware' => 'IsInjection'], function () {
            Route::get('/injection',[PlanController::class, 'injection'])->name('injection.index');
        });

        Route::group(['middleware' => 'IsPm'], function () {
            Route::get('/pm',[PmController::class, 'index'])->name('pm.index');
        });
        Route::post('/planupload',[PlanController::class, 'upload'])->name('plan.upload');
        Route::get('/plan_ajax/{year}/{month}/{line}',[PlanController::class, 'plan_ajax'])->name('plan.ajax');
        // END PLAN

        // MRP
        Route::get('/mrp',[MrpController::class, 'index'])->name('mrp.index');
        Route::get('/mrp_detail/{month}/{year}/{source}',[MrpController::class, 'detail'])->name('mrp.detail');
        // END MRP
    });
});

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

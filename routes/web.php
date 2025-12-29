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
use App\Http\Controllers\JobController;
use App\Http\Controllers\RejectController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\MachineCounter;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\QcController;
use App\Http\Controllers\PalletsController;
use App\Http\Controllers\TosController;
use App\Http\Controllers\ApprovalLevelConntroller;
use App\Http\Controllers\DowntimeController;
use App\Http\Controllers\QcRejectController;
use App\Http\Controllers\QcDataRejectController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\LoadSheetController;

Route::get('/', ['middleware' => 'guest', function()
{
    return redirect('/login')->with('danger','YOUR ARE ALREADY LOG IN');
}]);

Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');;
Route::get('/emaildesign',[TestController::class, 'emaildesign'])->name('test.emaildesign');
Route::get('/emailtest',[TestController::class, 'emailtest'])->name('test.emailtest');

Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
    'confirm'=>false, // Password Confirm
]);
    
    Route::group(['middleware' => 'auth',IsActive::class], function () {
        
        Route::group(['middleware' => 'IsManager'], function () {
            // FORECAST ROUTES
            Route::get('/forecast',[ForecastController::class, 'index'])->name('forecast.index');
            Route::post('/forecast_post',[ForecastController::class, 'store'])->name('forecast.store');
            Route::post('/forecast_check',[ForecastController::class, 'check'])->name('forecast.check');
            Route::post('/pbb_stockcode',[ForecastController::class, 'pbb_stockcode'])->name('pbb.stockcode');
            // END FORECAST ROUTES

            // PO COMPLIANCE ROUTES
            Route::get('/pocompliance',[PoComplianceController::class, 'index'])->name('pocompliance.index');
            // END PO COMPLIANCE ROUTES

             // INVENTORY MATERIALS
            Route::get('/inventorymaterials',[InventoryMaterials::class, 'index'])->name('inventorymaterials.index');
            // END INVENTORY MATERIALS

            // INVENTORY MATERIALS
            Route::get('/inventoryfg',[InventoriesFGController::class, 'index'])->name('inventoryfg.index');
            // END INVENTORY MATERIALS

            // MRP
            Route::get('/mrp',[MrpController::class, 'index'])->name('mrp.index');
            Route::get('/mrp_detail/{month}/{year}/{source}',[MrpController::class, 'detail'])->name('mrp.detail');
            // END MRP

        });
        
        Route::group(['middleware' => 'IsAdmin'], function () {
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
        });
       
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

        Route::group(['middleware' => 'IsProduction'], function () {
            // JOB
            Route::get('/job',[JobController::class, 'index'])->name('job.index');
            // END JOB

            // REJECT
            Route::get('/reject',[RejectController::class, 'index'])->name('reject.index');
            // END REJECT

            // EMAIL
            Route::post('/email_post',[PlanController::class, 'email_post'])->name('email.post');
            // END EMAIL

            // EMAIL
            Route::get('/machine_counter',[MachineCounter::class, 'index'])->name('machine_counter.index');
            // END EMAIL

            // DOWNTIME
            Route::get('/downtime',[DowntimeController::class, 'index'])->name('downtime.index');
            // ENDDOWNTIME

            // PDF TEST
            Route::get('/test_quarantine',[PdfController::class, 'test_quarantine'])->name('pdf.test_quarantine');
            Route::get('/test_tos',[PdfController::class, 'test_tos'])->name('pdf.test_tos');
            Route::get('/test_report1',[PdfController::class, 'static_report1'])->name('pdf.static_report1');
            // END PDF
        });

        Route::group(['middleware' => 'IsQc'], function () {
            // PALLETS
            Route::get('/pallets',[PalletsController::class, 'index'])->name('pallets.index');
            // END PALLETS
            // REJECTS
            Route::get('/qc_rejects',[QcRejectController::class, 'index'])->name('qc.rejects');
            Route::get('/qc_data_rejects',[QcDataRejectController::class, 'index'])->name('qc.data.rejects');
            Route::get('/get_edited_rejects/{jobId}/{dbatch}/{categoryId}/{dYearDate}/{dMonthDate}',[QcDataRejectController::class, 'getEditedData'])->name('qc.data.rejects.edited');
            Route::get('/get_category_data',[QcDataRejectController::class, 'getCategoryData'])->name('qc.data.rejects.category');
            // END REJECTS
        });

        Route::group(['middleware' => 'IsWarehouse'], function () {
            Route::get('/loadsheet',[LoadSheetController::class, 'index'])->name('loadsheet.index');
            Route::get('/print_loadsheet/{id}',[LoadSheetController::class, 'print_loadsheet'])->name('loadsheet.print');
        });

        // HOLIDAY
            Route::get('/holidays',[HolidayController::class, 'index'])->name('holidays.index');
            // END HOLIDAY

        // PALLETS
        Route::get('/tos',[TosController::class, 'index'])->name('tos.index');
        // END PALLETS

        // APPROVER LEVEL
        Route::get('/approver_level',[ApprovalLevelConntroller::class, 'index'])->name('approver_level.index');
        Route::post('/approver_post',[ApprovalLevelConntroller::class, 'update'])->name('approver_level.update');
        // END APPROVER LEVEL
        
       
    });


// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

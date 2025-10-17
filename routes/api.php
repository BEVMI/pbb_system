<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\PalletStatusController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\PmController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\CoaController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['middleware' => ['web']], function () {
    // PalletStatus
    Route::get('/pallet_status_check/{status}',[PalletStatusController::class, 'check'])->name('pallet_status.check');
    Route::get('/pallet_status_row/{status}',[PalletStatusController::class, 'row'])->name('pallet_status.row');
    Route::get('/pallet_status_check2/{status}',[PalletStatusController::class, 'check2'])->name('pallet_status.check2');
    // END PalletStatus


    // AUDIT
    Route::post('/post_audit',[AuditController::class, 'post_audit'])->name('audit.post');
    // END AUDIT

    // PDF
    Route::post('/print_pdf',[PdfController::class, 'print'])->name('pallet_status.print');
    Route::get('/print_pdf_now/{id}',[PdfController::class, 'print_now'])->name('pallet_status.print_now');
    Route::get('/turnover_form/{id}/{flag}',[PdfController::class, 'turnover_form'])->name('turnover_form');
    Route::get('/turnover_form1/{id}/{flag}',[PdfController::class, 'turnover_form1'])->name('turnover_form1');
    Route::get('/downtime_report/{id}',[PdfController::class, 'downtime_report'])->name('downtime_report');
    Route::get('/downtime_job/{job_id}',[PdfController::class, 'downtime_report_job'])->name('downtime_report_job');
    Route::get('/pallet_id/{tos_id}',[PdfController::class, 'pallet_id'])->name('pallet_id');

    Route::get('/print_pdf_advance/{job_id}/{pallet_count}/{date}',[PdfController::class, 'print_pdf_advance'])->name('pallet_status.print_pdf_advance');
    // END PDF
    
    // JOB
    Route::get('/job/{id}',[JobController::class, 'check'])->name('job.check');
    // END JOB
    Route::get('/pm_mass_date/{from_date}/{to_date}/{remarks}/{year}/{month}/{line}',[PmController::class, 'mass_date'])->name('pm.mass_date');
    Route::get('/emailSend/{title}/{content}/{department}',[TestController::class, 'emailSend'])->name('test.emailSend');

    Route::post('/upload_coa',[CoaController::class, 'upload_coa'])->name('coa.upload');
    Route::get('/preview_coa/{id}',[CoaController::class, 'preview_coa'])->name('coa.preview');
    Route::get('/coa_view/{id}',[CoaController::class, 'coa_view'])->name('coa.view');
});
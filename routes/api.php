<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\PalletStatusController;
use App\Http\Controllers\PdfController;

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
    Route::get('/print_pdf',[PdfController::class, 'print'])->name('pallet_status.print');
    Route::get('/print_pdf_now/{id}',[PdfController::class, 'print_now'])->name('pallet_status.print_now');
    Route::get('/turnover_form/{id}/{flag}',[PdfController::class, 'turnover_form'])->name('turnover_form');
    Route::get('/turnover_form1/{id}/{flag}',[PdfController::class, 'turnover_form1'])->name('turnover_form1');
    Route::get('/downtime_report/{id}',[PdfController::class, 'downtime_report'])->name('downtime_report');
    Route::get('/downtime_job/{job_id}',[PdfController::class, 'downtime_report_job'])->name('downtime_report_job');
    // END PDF
});
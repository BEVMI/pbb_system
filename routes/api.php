<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\PalletStatusController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// PalletStatus
Route::get('/pallet_status_check/{status}',[PalletStatusController::class, 'check'])->name('pallet_status.check');
Route::get('/pallet_status_row/{status}',[PalletStatusController::class, 'row'])->name('pallet_status.row');
// END PalletStatus


// AUDIT
Route::post('/post_audit',[AuditController::class, 'post_audit'])->name('audit.post');
// END AUDIT

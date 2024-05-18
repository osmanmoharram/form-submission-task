<?php

use App\Http\Controllers\Api\Auth\AuthenticatedTokenController;
use App\Http\Controllers\Api\FormSubmitController;
use App\Http\Controllers\Api\FormSubmitReportController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::post('login', [AuthenticatedTokenController::class, 'store']);
    Route::post('/formSubmits', [FormSubmitController::class, 'store'])->name('formSubmits.store');
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('logout', [AuthenticatedTokenController::class, 'destroy']);
    Route::apiResource('formSubmits', FormSubmitController::class)->only(['index', 'update']);

    Route::get('/formSubmits/report', [FormSubmitReportController::class, 'show'])->name('formSubmits.report.show');
    Route::get('/formSubmits/report/export', [FormSubmitReportController::class, 'export'])->name('formSubmits.report.export');

    Route::get('/formSubmits/{formSubmit}/download', [FormSubmitController::class, 'download'])->name('formSubmits.download');
});

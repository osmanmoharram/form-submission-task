<?php

use App\Http\Controllers\Api\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Api\FormSubmitController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/sanctum/csrf-cookie', function () {
        

    });
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    Route::post('/formSubmits', [FormSubmitController::class, 'store'])->name('formSubmits.store');
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy']);
    Route::apiResource('formSubmits', FormSubmitController::class)->only(['index', 'update']);
    Route::get('/formSubmits/{formSubmit}/download', [FormSubmitController::class, 'download'])->name('formSubmits.download');
});

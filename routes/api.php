<?php

use App\Http\Controllers\Api\FormSubmitController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/formSubmits', [FormSubmitController::class, 'store'])->name('formSubmits.store');
Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('formSubmits', FormSubmitController::class)->only(['index', 'update']);
    Route::get('/submits/{formSubmit}', [FormSubmitController::class, 'download'])->name('formSubmits.download');
});

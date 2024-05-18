<?php

use App\Http\Controllers\FormSubmitController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::post('/formSubmits', [FormSubmitController::class, 'store'])->name('formSubmits.store');
    Route::get('/', [FormSubmitController::class, 'create'])->name('formSubmits.create');
    Route::get('login', fn () => view('auth.login'))->name('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');
    Route::resource('formSubmits', FormSubmitController::class)->only(['index', 'update']);
    Route::get('/formSubmits/report', [FormSubmitController::class, 'showReport'])->name('formSubmits.report');
    Route::get('/formSubmits/{formSubmit}/download', [FormSubmitController::class, 'download'])->name('formSubmits.download');
});

require __DIR__.'/auth.php';

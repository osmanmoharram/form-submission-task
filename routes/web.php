<?php

use App\Http\Controllers\FormSubmitController;
use App\Http\Controllers\FormSubmitCvController;
use App\Http\Controllers\FormSubmitReportController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return to_route(Auth::check() ? 'formSubmits.index' : 'formSubmits.create');
});

Route::middleware('guest')->group(function () {
    Route::post('/formSubmits', [FormSubmitController::class, 'store'])->name('formSubmits.store');
    Route::get('/formSubmits/create', [FormSubmitController::class, 'create'])->name('formSubmits.create');
    Route::get('login', fn () => view('auth.login'))->name('login');
});

Route::middleware('auth')->group(function () {
    Route::resource('formSubmits', FormSubmitController::class)->only(['index', 'update']);
    
    Route::get('/formSubmits/report', [FormSubmitReportController::class, 'show'])->name('formSubmits.report.show');
    Route::get('/formSubmits/report/export', [FormSubmitReportController::class, 'export'])->name('formSubmits.report.export');

    Route::get('/formSubmits/{formSubmit}/cv', FormSubmitCvController::class)->name('formSubmits.cv');
});

require __DIR__.'/auth.php';

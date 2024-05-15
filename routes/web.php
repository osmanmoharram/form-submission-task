<?php

use App\Http\Controllers\FormSubmitController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::post('/submissions', [FormSubmitController::class, 'store'])->name('submissions.store');
    Route::get('/', fn () => view('welcome'))->name('home');
    Route::get('login', fn () => view('auth.login'))->name('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');
    Route::resource('submissions', FormSubmitController::class)->except(['create', 'store', 'show', 'edit']);
});

require __DIR__.'/auth.php';

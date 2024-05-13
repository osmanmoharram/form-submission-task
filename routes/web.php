<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'home');

Route::view('/login', 'auth.login');

require __DIR__.'/auth.php';

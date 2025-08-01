<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\HomeController;



Auth::routes();
Route::get('/', function () {
    return view('auth.login');
});



// Admin 
Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware(RoleMiddleware::class);
Route::get('/middlewareCheck', [HomeController::class, 'middlewareCheck'])->name('middlewareCheck');



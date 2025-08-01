<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\HomeController;

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);



// Admin 
Route::get('/home', [HomeController::class, 'dashboard'])->name('dashboard')->middleware(RoleMiddleware::class);



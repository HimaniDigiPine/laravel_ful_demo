<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\CategoryController;




Auth::routes();
Route::get('/', function () {
    return view('auth.login');
});



// Admin 
Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware(RoleMiddleware::class);
Route::get('/middlewareCheck', [HomeController::class, 'middlewareCheck'])->name('middlewareCheck');


//Categories
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::post('categories/restore/{id}', [CategoryController::class, 'restore'])->name('categories.restore');
    Route::delete('categories/force-delete/{id}', [CategoryController::class, 'forceDelete'])->name('categories.forceDelete');
     Route::delete('categories/bulkDelete', [CategoryController::class, 'bulkDelete'])
            ->name('categories.bulkDelete');
});

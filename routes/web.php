<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\Admin\ProductController;




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
     Route::delete('categories/bulkDelete', [CategoryController::class, 'bulkDelete'])->name('categories.bulkDelete');
});


//Sub Categories
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('subcategories', SubcategoryController::class);
    Route::delete('subcategories/bulk-delete', [SubcategoryController::class, 'bulkDelete'])->name('subcategories.bulkDelete');
    Route::post('subcategories/{id}/restore', [SubcategoryController::class, 'restore'])->name('subcategories.restore');
    Route::delete('subcategories/{id}/force-delete', [SubcategoryController::class, 'forceDelete'])->name('subcategories.forceDelete');
});


// Products
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('products', ProductController::class);

    // Restore and Force Delete
    Route::post('products/restore/{id}', [ProductController::class, 'restore'])->name('products.restore');
    Route::delete('products/force-delete/{id}', [ProductController::class, 'forceDelete'])->name('products.forceDelete');

    // Bulk Delete
    Route::delete('products/bulk-delete', [ProductController::class, 'bulkDelete'])->name('products.bulkDelete');

    // AJAX - Get Subcategories by Category
    Route::get('get-subcategories/{categoryId}', [ProductController::class, 'getSubcategories'])->name('products.getSubcategories');
});
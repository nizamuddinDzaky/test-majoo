<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
Route::middleware(['auth'])->group(function() {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'home'])->name('home');    

    Route::group(['prefix' => 'product'], function() {    
        Route::get('/list', [App\Http\Controllers\ProductController::class, 'index'])->name('list-product');
        Route::post('/file-upload-parser', [App\Http\Controllers\ProductController::class, 'fileUpload'])->name('file-upload-parser-product-category');
        Route::post('/add', [App\Http\Controllers\ProductController::class, 'add'])->name('add-product');
        Route::get('/get-data/{id}', [App\Http\Controllers\ProductController::class, 'getData'])->name('get-data-product');
        Route::post('/update-data/{id}', [App\Http\Controllers\ProductController::class, 'update'])->name('update-data-product');
        Route::get('/delete-data/{id}', [App\Http\Controllers\ProductController::class, 'delete'])->name('delete-data-product');
        Route::group(['prefix' => 'category'], function() {    
            Route::get('/list', [App\Http\Controllers\ProductCategoryController::class, 'index'])->name('list-product-category');
            Route::post('/add', [App\Http\Controllers\ProductCategoryController::class, 'add'])->name('add-product-category');
            Route::get('/get-data/{id}', [App\Http\Controllers\ProductCategoryController::class, 'getData'])->name('get-data-product-category');
            Route::post('/update-data/{id}', [App\Http\Controllers\ProductCategoryController::class, 'update'])->name('update-data-product-category');
            Route::get('/delete-data/{id}', [App\Http\Controllers\ProductCategoryController::class, 'delete'])->name('delete-data-product-category');
        });
    });
});


// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

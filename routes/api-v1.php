<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('register', [RegisterController::class, 'store'])->name('register');

// Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
// Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
// Route::get('categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
// Route::put('categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
// Route::delete('categories/{category}', [CategoryController::class, 'delete'])->name('categories.delete');

Route::apiResource('categories', CategoryController::class)->names('categories');

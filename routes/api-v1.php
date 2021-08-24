<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\Auth\LoginController;


Route::post('login', [LoginController::class, 'store']);
Route::post('register', [RegisterController::class, 'store'])->name('register');

Route::apiResource('categories', CategoryController::class)->names('categories');
Route::apiResource('posts', PostController::class)->names('posts');

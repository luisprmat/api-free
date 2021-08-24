<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('register', [RegisterController::class, 'store'])->name('register');

Route::apiResource('categories', CategoryController::class)->names('categories');
Route::apiResource('posts', PostController::class)->names('posts');

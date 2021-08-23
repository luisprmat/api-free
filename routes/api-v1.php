<?php

use App\Http\Controllers\Api\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('register', [RegisterController::class, 'store'])->name('api.v1.register');

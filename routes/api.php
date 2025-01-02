<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PhotosController;
use Illuminate\Support\Facades\Route;


Route::post('/upload-photo',[PhotosController::class,'store']);


Route::post('/register',[AuthController::class,'register']);

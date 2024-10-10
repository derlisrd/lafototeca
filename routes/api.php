<?php

use App\Http\Controllers\PhotosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/upload-photo',[PhotosController::class,'store']);

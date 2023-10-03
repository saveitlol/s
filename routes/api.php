<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\postController;
use App\Http\Controllers\StudentController;

Route::get('/data',[StudentController::class, 'post']);
Route::get('/data/{id}',[StudentController::class, 'postById']);
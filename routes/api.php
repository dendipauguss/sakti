<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/classified', [FileController::class, 'apiAll']);
Route::get('/classified/category/{category}', [FileController::class, 'apiByCategory']);

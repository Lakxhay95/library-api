<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/welcome', function () {
//     return response()->json(['message'=>'API is working fine!']);
// });

Route::prefix('books')->group(function () {
    Route::post('/create', [BookController::class, 'create']);
    Route::get('/list', [BookController::class, 'list']);
    Route::get('/{id}', [BookController::class, 'show']);
    Route::put('/update/{id}', [BookController::class, 'update']);
    Route::delete('/delete/{id}', [BookController::class, 'delete']);
    Route::post('/search', [BookController::class, 'search']);
});
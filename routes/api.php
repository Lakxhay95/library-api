<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/books/create', [BookController::class, 'create']);
Route::get('books/list', [BookController::class, 'list']);
Route::get('books/{id}', [BookController::class, 'show']);
Route::put('books/update/{id}', [BookController::class, 'update']);
Route::delete('books/delete/{id}', [BookController::class, 'delete']);
Route::post('books/search', [BookController::class, 'search']);

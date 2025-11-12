<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\MemberController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/books/create', [BookController::class, 'create']);
Route::get('books/list', [BookController::class, 'list']);
Route::get('books/{id}', [BookController::class, 'show']);
Route::put('books/update/{id}', [BookController::class, 'update']);
Route::delete('books/delete/{id}', [BookController::class, 'delete']);
Route::post('books/search', [BookController::class, 'search']);

Route::prefix('members')->group(function () {
    Route::post('/create', [MemberController::class, 'create']);        
    Route::get('/list', [MemberController::class, 'list']);             
    Route::get('/{id}', [MemberController::class, 'show']);             
    Route::put('/update/{id}', [MemberController::class, 'update']);    
    Route::delete('/delete/{id}', [MemberController::class, 'delete']); 
    Route::post('/search', [MemberController::class, 'search']);        
    Route::get('/{id}/borrowings', [MemberController::class, 'borrowings']); 
});

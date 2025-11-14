<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\BorrowingController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('books')->group(function() {
    Route::post('/create', [BookController::class, 'create']);
    Route::get('/list', [BookController::class, 'list']);
    Route::get('/{id}', [BookController::class, 'show']);
    Route::put('/update/{id}', [BookController::class, 'update']);
    Route::delete('/delete/{id}', [BookController::class, 'delete']);
    Route::post('/search', [BookController::class, 'search']);
});

Route::prefix('members')->group(function () {
    Route::post('/create', [MemberController::class, 'create']);        
    Route::get('/list', [MemberController::class, 'list']);             
    Route::get('/{id}', [MemberController::class, 'show']);             
    Route::put('/update/{id}', [MemberController::class, 'update']);    
    Route::delete('/delete/{id}', [MemberController::class, 'delete']); 
    Route::post('/search', [MemberController::class, 'search']);        
    Route::get('/{id}/borrowings', [MemberController::class, 'borrowings']); 
});

Route::prefix('borrowings')->group(function() {
    Route::post('/borrow', [BorrowingController::class, 'borrow']);
    Route::post('/return', [BorrowingController::class, 'returnBook']);
    Route::get('/list', [BorrowingController::class, 'list']);
    Route::get('/overdue', [BorrowingController::class, 'overdue']);
    Route::get('/{id}', [BorrowingController::class, 'show']);
});

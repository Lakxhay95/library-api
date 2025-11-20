<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schedule;

Schedule::command('books:delete-old')->everyTwoMinutes();

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

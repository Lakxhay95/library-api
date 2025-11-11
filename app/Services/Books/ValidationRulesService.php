<?php

namespace App\Services\Books;

// use App\Http\Controllers\BookController;

class ValidationRulesService
{
    public static function getCreateRules()
    {
        return [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books,isbn',
            'category' => 'required|string',
            'total_copies' => 'required|integer|min:1',
            'available_copies' => 'required|integer|min:0',
            'status' => 'required|string|in:available,unavailable',
        ];
    }

    public static function getUpdateRules($id)
    {
        return [
            'title' => 'somtimes|string|max:255',
            'author' => 'sometimes|string|max:255',
            'isbn' => 'spmetimes|string|unique:books,isbn,' .$id,
            'category' => 'sometimes|string',
            'total_copies' => 'sometimes|integer|min:1',
            'available_copies' => 'sometimes|string|min:0',
            'status' => 'sometimes|string|in:available, unavailable',  
        ];
    }
}
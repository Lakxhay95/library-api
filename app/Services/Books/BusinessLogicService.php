<?php

namespace App\Services\Books;

use App\Models\Book;

class BusinessLogicService
{
    public function createBook(array $validated)
    {
        \Log::info('Entered into createBook logic');
        return Book::create($validated);
    }

    public function listBooks()
    {
        return Book::paginate(10);
    }

    public function getBookById($id)
    {
        return Book::find($id);
    }

    public function updateBook($id, array $validated)
    {
        $book = Book::find($id);

        if (!$book) {
            return null;
        }

        $book->update($validated);
        return $book;
    }

    public function deleteBook($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return null;
        }

        $book->delete();
        return true;
    }

    public function searchBooks($keyword)
    {
        return Book::where('title', 'like', "%$keyword%")
            ->orWhere('author', 'like', "%$keyword%")
            ->orWhere('category', 'like', "%$keyword%")
            ->get();
    }
}

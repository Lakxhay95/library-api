<?php

namespace App\Services\Books;

use App\Models\Book;

class BusinessLogicService
{
    // ✅ Create a new book
    public function createBook(array $validated)
    {
        \Log::info('Entered into createBook logic');
        return Book::create($validated);
    }

    // ✅ List all books (with pagination)
    public function listBooks()
    {
        return Book::paginate(10);
    }

    // ✅ Get a single book by ID
    public function getBookById($id)
    {
        return Book::find($id);
    }

    // ✅ Update an existing book
    public function updateBook($id, array $validated)
    {
        $book = Book::find($id);

        if (!$book) {
            return null;
        }

        $book->update($validated);
        return $book;
    }

    // ✅ Delete a book
    public function deleteBook($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return null;
        }

        $book->delete();
        return true;
    }

    // ✅ Search for books by keyword
    public function searchBooks($keyword)
    {
        return Book::where('title', 'like', "%$keyword%")
            ->orWhere('author', 'like', "%$keyword%")
            ->orWhere('category', 'like', "%$keyword%")
            ->get();
    }
}

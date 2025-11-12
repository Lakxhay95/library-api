<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Books\BusinessLogicService;
use App\Services\Books\ValidationRulesService;

class BookController extends Controller
{
    protected $businessLogic;

    public function __construct(BusinessLogicService $businessLogic)
    {
        $this->businessLogic = $businessLogic;
    }

    public function create(Request $request)
    {
        $validated = $request->validate(ValidationRulesService::getCreateRules());
        $book = $this->businessLogic->createBook($validated);

        return response()->json([
            'message' => 'Book created successfully!',
            'data' => $book
        ], 201);
    }

    // ✅ LIST Books
    public function list()
    {
        $books = $this->businessLogic->listBooks();

        return response()->json([
            'message' => 'Books fetched successfully!',
            'data' => $books
        ], 200);
    }

    // ✅ SHOW single book
    public function show($id)
    {
        $book = $this->businessLogic->getBookById($id);

        if (!$book) {
            return response()->json(['message' => 'Book not found!'], 404);
        }

        return response()->json(['data' => $book], 200);
    }

    // ✅ UPDATE Book
    public function update(Request $request, $id)
    {
        $validated = $request->validate(ValidationRulesService::getUpdateRules($id));
        $book = $this->businessLogic->updateBook($id, $validated);

        if (!$book) {
            return response()->json(['message' => 'Book not found!'], 404);
        }

        return response()->json([
            'message' => 'Book updated successfully!',
            'data' => $book
        ], 200);
    }

    // ✅ DELETE Book
    public function delete($id)
    {
        $deleted = $this->businessLogic->deleteBook($id);

        if (!$deleted) {
            return response()->json(['message' => 'Book not found!'], 404);
        }

        return response()->json(['message' => 'Book deleted successfully!'], 200);
    }

    // ✅ SEARCH Books
    public function search(Request $request)
    {
        $keyword = $request->input('keyword', '');
        $books = $this->businessLogic->searchBooks($keyword);

        return response()->json([
            'message' => 'Search completed!',
            'data' => $books
        ], 200);
    }
}

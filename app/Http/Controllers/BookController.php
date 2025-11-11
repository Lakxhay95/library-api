<?php

// Controller = bridge between routes and services

// namespace App\Http\Controllers;

// use App\Models\Book;
// use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;

// class BookController extends Controller
// {

//     public function create(Request $request)
//     {   
//         \Log::info('Entered into log');
//         $validated = $request->validate([ // validate keyword
//             'title' => 'required|string|max:255', // format
//             'author' => 'required|string|max:255',
//             'isbn' => 'required|string|unique:books,isbn',
//             'category' => 'required|string',
//             'total_copies' => 'required|integer|min:1',
//             'available_copies' => 'required|integer|min:0',
//             'status' => 'required|string|in:available,unavailable',
//         ]);

//         $book = Book::create($validated); // Book
        
//         return response()->json([
//             'message' => 'Book created successfully!',
//             'data' => $book
//         ], 201);
//     }

//     public function list()
//     {
//         $books = Book::paginate(10);

//         return response()->json([
//             'message' => 'Books fetched successfully!',
//             'data' => $books
//         ], 200); // 200?
//     }

//     public function show($id)
//     {
//         $book = Book::find($id);

//         if (!$book) {
//             return response()->json(['message' => 'Book not found!'], 404);
//         }

//         return response()->json(['data' => $book], 200);
//     }

//     public function update(Request $request, $id)
//     {
//         $book = Book::find($id);

//         if (!$book) {
//             return response()->json(['message' => 'Book not found!'], 404);
//         }

//         $validated = $request->validate([
//             'title' => 'sometimes|string|max:255', // sometimes keyword means -> only validate if present.
//             'author' => 'sometimes|string|max:255',
//             'isbn' => 'sometimes|string|unique:books,isbn,' . $id,
//             'category' => 'sometimes|string',
//             'total_copies' => 'sometimes|integer|min:1',
//             'available_copies' => 'sometimes|integer|min:0',
//             'status' => 'sometimes|string|in:available,unavailable',
//         ]);

//         $book->update($validated);

//         return response()->json([
//             'message' => 'Book updated successfully!',
//             'data' => $book
//         ], 200);
//     }

//     public function delete($id)
//     {
//         $book = Book::find($id);

//         if (!$book) {
//             return response()->json(['message' => 'Book not found!'], 404);
//         }

//         $book->delete();

//         return response()->json(['message' => 'Book deleted successfully!'], 200);
//     }

//     public function search(Request $request)
//     {
//         $keyword = $request->input('keyword', '');

//         $books = Book::where('title', 'like', "%$keyword%")
//             ->orWhere('author', 'like', "%$keyword%")
//             ->orWhere('category', 'like', "%$keyword%")
//             ->get();

//         return response()->json([
//             'message' => 'Search completed!',
//             'data' => $books
//         ], 200);
//     }
// }

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Books\BusinessLogicService;
use App\Services\Books\ValidationRulesService;

class BookController extends Controller
{
    protected $businessLogic;

    // ✅ Constructor injection
    public function __construct(BusinessLogicService $businessLogic)
    {
        $this->businessLogic = $businessLogic;
    }

    // ✅ CREATE Book
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

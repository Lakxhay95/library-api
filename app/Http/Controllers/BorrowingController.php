<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Member;
use App\Models\Borrowing;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    public function borrow(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'book_id'   => 'required|exists:books,id',
        ]);

        $member = Member::find($request->member_id);
        $book   = Book::find($request->book_id);

        // 1. Check member active
        if ($member->status !== 'active') {
            return response()->json(['error' => 'Member is suspended'], 400);
        }

        // 2. Check book active
        if ($book->status !== 'available') {
            return response()->json(['error' => 'Book is not active'], 400);
        }

        // 3. Check available copies
        if ($book->available_copies <= 0) {
            return response()->json(['error' => 'Book is not available'], 400);
        }

        // 4. Prevent duplicate borrowing
        $already = Borrowing::where('member_id', $member->id)
            ->where('book_id', $book->id)
            ->where('status', 'borrowed')
            ->first();

        if ($already) {
            return response()->json(['error' => 'You already borrowed this book'], 400);
        }

        // 5. Reduce available copies
        $book->available_copies -= 1;
        $book->save();

        // 6. Due date = today + 14 days
        $borrowDate = Carbon::now();
        $dueDate = $borrowDate->copy()->addDays(14);

        // 7. Create borrowing record
        $borrow = Borrowing::create([
            'member_id' => $member->id,
            'book_id'   => $book->id,
            'borrowed_date' => $borrowDate,
            'due_date'      => $dueDate,
            'status'        => 'borrowed'
        ]);

        return response()->json([
            'message' => 'Book borrowed successfully',
            'borrowing' => $borrow
        ], 201);
    }

    public function returnBook(Request $request)
    {
        $request->validate([
            'borrowing_id' => 'required|exists:borrowings,id'
        ]);

        $borrow = Borrowing::find($request->borrowing_id);

        if ($borrow->status !== 'borrowed') {
            return response()->json(['error' => 'This book is not currently borrowed'], 400);
        }

        $returnedDate = Carbon::now();
        $lateFee = 0;

        // Correct: Convert due_date to Carbon
        $dueDate = Carbon::parse($borrow->due_date);

        if ($returnedDate->gt($dueDate)) {
            $daysLate = $returnedDate->diffInDays($dueDate);
            $lateFee = $daysLate * 10;
        }

        // Increase available copies
        $book = Book::find($borrow->book_id);
        $book->available_copies += 1;
        $book->save();

        // Update Borrowing
        $borrow->update([
            'returned_date' => $returnedDate,
            'status'        => 'returned',
            'late_fee'      => $lateFee
        ]);

        return response()->json([
            'message' => 'Book returned successfully',
            'late_fee' => $lateFee
        ]);
    }


    public function list()
    {
        return Borrowing::with(['member', 'book'])->get();
    }

    public function show($id)
    {
        $borrow = Borrowing::with(['member', 'book'])->find($id);

        if (!$borrow) {
            return response()->json(['error' => 'Record not found'], 404);
        }

        return $borrow;
    }

    public function overdue()
    {
        $today = Carbon::now();

        $overdues = Borrowing::where('status', 'borrowed')
            ->where('due_date', '<', $today)
            ->with(['member', 'book'])
            ->get();

        return $overdues;
    }
}

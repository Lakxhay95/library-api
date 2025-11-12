<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use Illuminate\Validation\ValidationException;

class MemberController extends Controller
{
    // Create a new member
    public function create(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:members,email',
                'phone' => ['required', 'string', 'regex:/^[0-9]{10,15}$/'],
                'status' => 'required|in:active,suspended',
                'joined_date' => 'nullable|date',
            ]);

            $validated['membership_number'] = $this->generateMembershipNumber();

            if (empty($validated['joined_date'])) {
                $validated['joined_date'] = now()->toDateString();
            }

            $member = Member::create($validated);

            return response()->json([
                'message' => 'Member created successfully',
                'data' => $member
            ], 201);

        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    // List all members
    public function list()
    {
        $members = Member::paginate(10);
        return response()->json([
            'message' => 'Members fetched successfully!',
            'data' => $members
        ], 200);
    }

    // Get specific member by ID
    public function show($id)
    {
        $member = Member::find($id);

        if (!$member) {
            return response()->json(['message' => 'Member not found'], 404);
        }

        return response()->json([
            'message' => 'Member fetched successfully!',
            'data' => $member
        ], 200);
    }

    // Update member details
    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'name' => 'sometimes|string|max:255',
                'email' => 'sometimes|email|unique:members,email',
                'phone' => ['sometimes', 'string', 'regex:/^[0-9]{10,15}$/'],
                'status' => 'sometimes|in:active,suspended',
            ]);

            $member = Member::find($id);

            if (!$member) {
                return response()->json(['message' => 'Member not found'], 404);
            }

            $member->update($validated);

            return response()->json([
                'message' => 'Member updated successfully',
                'data' => $member
            ], 200);

        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    // Delete a member
    public function delete($id)
    {
        $member = Member::find($id);

        if (!$member) {
            return response()->json(['message' => 'Member not found'], 404);
        }

        $member->delete();

        return response()->json(['message' => 'Member deleted successfully'], 200);
    }

    // Search members by name
    public function search(Request $request)
    {
        $keyword = $request->input('query');

        // Search across all relevant columns
        $members = Member::where(function ($query) use ($keyword) {
            $query->where('name', 'LIKE', "%{$keyword}%");
                // ->orWhere('email', 'LIKE', "%{$keyword}%")
                // ->orWhere('phone', 'LIKE', "%{$keyword}%")
                // ->orWhere('status', 'LIKE', "%{$keyword}%")
                // ->orWhere('membership_number', 'LIKE', "%{$keyword}%");
                // ->orWhere('joined_date', 'LIKE', "%{$keyword}%");
        })->get();

        // If no results found
        if ($members->isEmpty()) {
            return response()->json(['message' => 'No matching members found'], 404);
        }

        return response()->json($members, 200);
    }

    // Get member borrowing history
    // public function borrowings($id)
    // {
    //     $member = Member::with('borrowings.book')->find($id);

    //     if (!$member) {
    //         return response()->json(['message' => 'Member not found or no borrowings'], 404);
    //     }

    //     return response()->json($member->borrowings, 200);
    // }

    // Generate auto membership number
    private function generateMembershipNumber()
    {
        $year = now()->year;
        $random = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
        return "MEM-{$year}-{$random}";
    }
}

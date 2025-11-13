<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Services\Members\BusinessLogicService;
use App\Services\Members\ValidationRulesService;
use Illuminate\Validation\ValidationException;

class MemberController extends Controller
{
    protected $memberService;
    protected $validationService;

    public function __construct(BusinessLogicService $memberService, ValidationRulesService $validationService)
    {
        $this->memberService = $memberService;
        $this->validationService = $validationService;
    }

    // Create a new member
    public function create(Request $request)
    {
        try {
            $validated = $this->validationService->validateCreate($request);
            $member = $this->memberService->createMember($validated);

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

    // Get member by ID
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
            $validated = $this->validationService->validateUpdate($request);

            $member = Member::find($id);
            if (!$member) {
                return response()->json(['message' => 'Member not found'], 404);
            }

            $updated = $this->memberService->updateMember($member, $validated);

            return response()->json([
                'message' => 'Member updated successfully',
                'data' => $updated
            ], 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    // Delete member
    public function delete($id)
    {
        $member = Member::find($id);

        if (!$member) {
            return response()->json(['message' => 'Member not found'], 404);
        }

        $this->memberService->deleteMember($member);

        return response()->json(['message' => 'Member deleted successfully'], 200);
    }

    // Search member by name
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $members = $this->memberService->searchMembers($keyword);

        if ($members->isEmpty()) {
            return response()->json(['message' => 'No matching members found'], 404);
        }

        return response()->json([
            'message' => 'Members found successfully',
            'data' => $members
        ], 200);
    }
}

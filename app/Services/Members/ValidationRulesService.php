<?php

namespace App\Services\Members;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ValidationRulesService
{
    public function validateCreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:members,email',
            'phone' => ['required', 'string', 'regex:/^[0-9]{10,15}$/'],
            'status' => 'required|in:active,suspended',
            'joined_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }

    public function validateUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:members,email',
            'phone' => ['sometimes', 'string', 'regex:/^[0-9]{10,15}$/'],
            'status' => 'sometimes|in:active,suspended',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }
}

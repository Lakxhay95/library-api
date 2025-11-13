<?php

namespace App\Services\Members;

use App\Models\Member;

class BusinessLogicService
{
    public function createMember(array $data)
    {
        $data['membership_number'] = $this->generateMembershipNumber();

        if (empty($data['joined_date'])) {
            $data['joined_date'] = now()->toDateString();
        }

        return Member::create($data);
    }

    public function updateMember(Member $member, array $data)
    {
        $member->update($data);
        return $member;
    }

    public function deleteMember(Member $member)
    {
        $member->delete();
        return true;
    }

    public function searchMembers(string $keyword)
    {
        $keyword = strtolower($keyword); // convert to lowercase for case-insensitive search

        return Member::where(function ($query) use ($keyword) {
            $query->whereRaw('LOWER(name) LIKE ?', ["%{$keyword}%"])
                ->orWhereRaw('LOWER(email) LIKE ?', ["%{$keyword}%"])
                ->orWhereRaw('LOWER(phone) LIKE ?', ["%{$keyword}%"])
                ->orWhereRaw('LOWER(status) LIKE ?', ["%{$keyword}%"])
                ->orWhereRaw('LOWER(membership_number) LIKE ?', ["%{$keyword}%"])
                ->orWhereRaw('LOWER(joined_date) LIKE ?', ["%{$keyword}%"]);
        })->get();
    }

    private function generateMembershipNumber()
    {
        $year = now()->year;
        $random = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
        return "MEM-{$year}-{$random}";
    }
}

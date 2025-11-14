<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Borrowing;

class BorrowingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $borrowings = [
            [
                'book_id' => 1,
                'member_id' => 1,
                'borrowed_date' => '2024-10-01',
                'due_date' => '2024-10-10',
                'returned_date' => null,
                'status' => 'borrowed',
                'late_fee' => 0,
            ],
            [
                'book_id' => 2,
                'member_id' => 3,
                'borrowed_date' => '2024-09-15',
                'due_date' => '2024-09-25',
                'returned_date' => '2024-09-23',
                'status' => 'returned',
                'late_fee' => 0,
            ],
            [
                'book_id' => 5,
                'member_id' => 2,
                'borrowed_date' => '2024-08-10',
                'due_date' => '2024-08-20',
                'returned_date' => null,
                'status' => 'overdue',
                'late_fee' => 50,
            ],
        ];

        foreach ($borrowings as $row) {
            Borrowing::create($row);
        }
    }
}

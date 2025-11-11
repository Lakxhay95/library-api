<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BorrowingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('borrowings')->insert([
            [
                'book_id' => 1,
                'member_id' => 1,
                'borrowed_date' => '2024-10-01',
                'due_date' => '2024-10-15',
                'returned_date' => null,
                'status' => 'borrowed',
                'late_fee' => 0.00
            ],
            [
                'book_id' => 2,
                'member_id' => 2,
                'borrowed_date' => '2024-09-20',
                'due_date' => '2024-10-05',
                'returned_date' => '2024-10-04',
                'status' => 'returned',
                'late_fee' => 0.00
            ],
            [
                'book_id' => 3,
                'member_id' => 3,
                'borrowed_date' => '2024-09-25',
                'due_date' => '2024-10-10',
                'returned_date' => null,
                'status' => 'overdue',
                'late_fee' => 20.00
            ],
            [
                'book_id' => 4,
                'member_id' => 4,
                'borrowed_date' => '2024-10-05',
                'due_date' => '2024-10-20',
                'returned_date' => null,
                'status' => 'borrowed',
                'late_fee' => 0.00
            ],
            [
                'book_id' => 5,
                'member_id' => 5,
                'borrowed_date' => '2024-08-15',
                'due_date' => '2024-08-30',
                'returned_date' => '2024-09-02',
                'status' => 'returned',
                'late_fee' => 10.00
            ],
        ]);
    }
}

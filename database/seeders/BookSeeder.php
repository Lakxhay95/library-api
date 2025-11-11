<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books=[
            ['title' => 'The Silent Ocean', 'author' => 'John Smith', 'isbn' => 'ISBN001', 'category' => 'Fiction', 'total_copies' => 10, 'available_copies' => 7, 'status' => 'active'],
            ['title' => 'World of Physics', 'author' => 'Albert Wayne', 'isbn' => 'ISBN002', 'category' => 'Science', 'total_copies' => 8, 'available_copies' => 3, 'status' => 'active'],
            ['title' => 'History of Rome', 'author' => 'Marcus Aurelius', 'isbn' => 'ISBN003', 'category' => 'History', 'total_copies' => 6, 'available_copies' => 2, 'status' => 'inactive'],
            ['title' => 'The Creative Mind', 'author' => 'A. Parker', 'isbn' => 'ISBN004', 'category' => 'Non-fiction', 'total_copies' => 12, 'available_copies' => 10, 'status' => 'active'],
            ['title' => 'Mathematics Simplified', 'author' => 'R. Adams', 'isbn' => 'ISBN005', 'category' => 'Science', 'total_copies' => 9, 'available_copies' => 9, 'status' => 'active'],
            ['title' => 'Deep Space', 'author' => 'Eleanor James', 'isbn' => 'ISBN006', 'category' => 'Science', 'total_copies' => 7, 'available_copies' => 5, 'status' => 'active'],
            ['title' => 'Ancient Warriors', 'author' => 'Leonard Gray', 'isbn' => 'ISBN007', 'category' => 'History', 'total_copies' => 10, 'available_copies' => 8, 'status' => 'active'],
            ['title' => 'Mindful Living', 'author' => 'Sophia Ray', 'isbn' => 'ISBN008', 'category' => 'Non-fiction', 'total_copies' => 15, 'available_copies' => 12, 'status' => 'active'],
            ['title' => 'Ocean Wonders', 'author' => 'James Carter', 'isbn' => 'ISBN009', 'category' => 'Fiction', 'total_copies' => 6, 'available_copies' => 5, 'status' => 'active'],
            ['title' => 'The Art of Code', 'author' => 'Lakshay Gupta', 'isbn' => 'ISBN010', 'category' => 'Science', 'total_copies' => 10, 'available_copies' => 10, 'status' => 'active'],
        ];

        foreach ($books as $book) {
            Book::create($book); 
        }
    }
}

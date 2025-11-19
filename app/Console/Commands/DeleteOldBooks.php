<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Book;

class DeleteOldBooks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'app:delete-old-books';
    protected $signature = 'books:delete-old';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $books = Book::orderBy('id', 'asc')->take(2)->get();

        if ($books->count() < 2) {
            $this->info("Less than 2 books exist. Skipping...");
            return;
        }

        foreach ($books as $book) {
            $book->delete();
        }

        $this->info("Deleted the two books with smallest IDs.");
    }
}

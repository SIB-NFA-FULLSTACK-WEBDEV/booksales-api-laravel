<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Book::insert([
            ['title' => 'Harry Potter 1', 'description' => 'Wizarding journey.', 'price' => 120.00, 'stock' => 10, 'cover_photo' => 'hp1.jpg', 'genre_id' => 1, 'author_id' => 1],
            ['title' => 'Game of Thrones', 'description' => 'Politics and dragons.', 'price' => 150.00, 'stock' => 8, 'cover_photo' => 'got.jpg', 'genre_id' => 1, 'author_id' => 2],
            ['title' => 'Foundation', 'description' => 'Sci-fi future tale.', 'price' => 130.50, 'stock' => 6, 'cover_photo' => 'foundation.jpg', 'genre_id' => 2, 'author_id' => 3],
            ['title' => 'Murder on the Orient Express', 'description' => 'Detective classic.', 'price' => 90.00, 'stock' => 5, 'cover_photo' => 'orient.jpg', 'genre_id' => 4, 'author_id' => 4],
            ['title' => 'The Hunger Games', 'description' => 'Dystopian survival.', 'price' => 100.00, 'stock' => 12, 'cover_photo' => 'hunger.jpg', 'genre_id' => 3, 'author_id' => 5],
        ]);
    }
}

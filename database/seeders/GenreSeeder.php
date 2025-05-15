<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Genre::insert([
            ['name' => 'Fantasy', 'description' => 'Fiction with magical or supernatural elements.'],
            ['name' => 'Science Fiction', 'description' => 'Futuristic and scientific narratives.'],
            ['name' => 'Horror', 'description' => 'Scary and suspenseful stories.'],
            ['name' => 'Mystery', 'description' => 'Whodunit or investigative stories.'],
            ['name' => 'Historical Fiction', 'description' => 'Set in the past with historical context.'],
        ]);
    }
}

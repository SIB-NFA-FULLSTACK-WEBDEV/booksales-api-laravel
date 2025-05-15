<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuthorSeeder extends Seeder
{
    public function run(): void
    {
        Author::insert([
            ['name' => 'J.K. Rowling', 'photo' => 'jk_rowling.jpg', 'bio' => 'British author of Harry Potter.'],
            ['name' => 'George R.R. Martin', 'photo' => 'george_rr_martin.jpg', 'bio' => 'Author of A Song of Ice and Fire.'],
            ['name' => 'Isaac Asimov', 'photo' => 'asimov.jpg', 'bio' => 'Science fiction master.'],
            ['name' => 'Agatha Christie', 'photo' => 'agatha.jpg', 'bio' => 'Queen of mystery novels.'],
            ['name' => 'Suzanne Collins', 'photo' => 'suzanne.jpg', 'bio' => 'Author of The Hunger Games.'],
        ]);
    }
}

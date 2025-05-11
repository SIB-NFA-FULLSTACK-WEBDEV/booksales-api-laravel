<?php

namespace App\Models;

class Author
{
    public static function all()
    {
        return [
            ['id' => 1, 'name' => 'J.K. Rowling', 'photo' => 'jk_rowling.jpg', 'bio' => 'British author, best known for the Harry Potter series.'],
            ['id' => 2, 'name' => 'George R.R. Martin', 'photo' => 'george_rr_martin.jpg', 'bio' => 'Known for A Song of Ice and Fire.'],
            ['id' => 3, 'name' => 'Isaac Asimov', 'photo' => 'isaac_asimov.jpg', 'bio' => 'Science fiction writer and professor.'],
            ['id' => 4, 'name' => 'Suzanne Collins', 'photo' => 'suzanne_collins.jpg', 'bio' => 'Author of The Hunger Games.'],
            ['id' => 5, 'name' => 'Stephen King', 'photo' => 'stephen_king.jpg', 'bio' => 'Master of horror and suspense.'],
        ];
    }
}

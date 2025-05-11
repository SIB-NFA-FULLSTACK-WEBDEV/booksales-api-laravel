<?php

namespace App\Models;

class Genre
{
    public static function all()
    {
        return [
            ['id' => 1, 'name' => 'Fantasy', 'description' => 'Fiction with magical or supernatural elements.'],
            ['id' => 2, 'name' => 'Science Fiction', 'description' => 'Futuristic and scientific narratives.'],
            ['id' => 3, 'name' => 'Horror', 'description' => 'Scary and suspenseful stories.'],
            ['id' => 4, 'name' => 'Mystery', 'description' => 'Whodunit or investigative stories.'],
            ['id' => 5, 'name' => 'Historical Fiction', 'description' => 'Set in the past with historical context.'],
        ];
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $fillable = ['name', 'description'];

    // Relasi ke buku
    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Book;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with(['genre', 'author'])->get();
        return view('book', compact('books'));
    }
}
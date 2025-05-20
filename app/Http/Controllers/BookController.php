<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();
        if ($books->isEmpty()) {
            return response()->json([
                "success" => true,
                "message" => "Resource data not found!",
            ], 200);
        }

        return response()->json([
            "success" => true,
            "message" => "Get all resources",
            "data" => $books
        ],200);
    }

    public function store(Request $request) {
        //1. Validator
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'cover_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'genre_id' => 'required|exists:genres,id',
            'author_id' => 'required|exists:authors,id'
        ]);
    
        //2. Check validator error
        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => "Validator error",
                "data" => $validator->errors()
            ], 422);
        }
    
        //3. Upload image
        $image = $request->file('cover_photo');
        $image ->store('books', 'public');
    
        //4. Insert data
        Book::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'stock' => $request->input('stock'),
            'cover_photo' => $image->hashName(),
            'genre_id' => $request->input('genre_id'),
            'author_id' => $request->input('author_id')
        ]);
    
        //5. Return response
        return response()->json([
            "success" => true,
            "message" => "Resource created successfully",
            "data" => [
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'price' => $request->input('price'),
                'stock' => $request->input('stock'),
                'cover_photo' => $image->hashName(),
                'genre_id' => $request->input('genre_id'),
                'author_id' => $request->input('author_id')
            ]
        ], 201);
    }
}
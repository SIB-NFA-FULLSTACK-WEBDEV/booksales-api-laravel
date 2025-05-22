<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

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

    // Fungsi show untuk menampilkan detail buku berdasarkan ID
    public function show($id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json([
                "success" => false,
                "message" => "Resource not found",
            ], 404);
        }

        return response()->json([
            "success" => true,
            "message" => "Get resource",
            "data" => $book
        ], 200);
    }

    // Fungsi destroy untuk menghapus buku berdasarkan ID
    public function destroy($id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json([
                "success" => false,
                "message" => "Resource not found",
            ], 404);
        }

        if ($book->cover_photo) {
            // Hapus file gambar dari storage
            Storage::disk('public')->delete('books/' . $book->cover_photo);
        }

        $book->delete();

        return response()->json([
            "success" => true,
            "message" => "Resource deleted successfully",
        ], 200);
    }

    // Fungsi untuk mengupdate buku berdasarkan ID
    public function update(Request $request, $id)
    {
        // 1. Mencari Data
        $book = Book::find($id);
        if (!$book) {
            return response()->json([
                "success" => false,
                "message" => "Resource not found",
            ], 404);
        }

        // 2. Validator
        $validator = Validator::make($request->all(), [
            'title' => 'string|max:255',
            'description' => 'string',
            'price' => 'numeric',
            'stock' => 'integer',
            'cover_photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'genre_id' => 'exists:genres,id',
            'author_id' => 'exists:authors,id'
        ]);

        // 3. Check validator error
        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => "Validator error",
                "data" => $validator->errors()
            ], 422);
        }

        //4. Siapkan data untuk update
        $data = [
            'title' => $request->input('title', $book->title),
            'description' => $request->input('description', $book->description),
            'price' => $request->input('price', $book->price),
            'stock' => $request->input('stock', $book->stock),
            'genre_id' => $request->input('genre_id', $book->genre_id),
            'author_id' => $request->input('author_id', $book->author_id)
        ];

        // 5. Handle image (upload dan hapus gambar)
        if ($request->hasFile('cover_photo')) {
            $image = $request->file('cover_photo');
            $image->store('books', 'public');

            if ($book->cover_photo) {
                // Hapus file gambar lama dari storage
                Storage::disk('public')->delete('books/' . $book->cover_photo);
            }
            
            $data['cover_photo'] = $image->hashName();
        }
        // 6. Update data buku
        $book->update($data);

        return response()->json([
            "success" => true,
            "message" => "Resource updated successfully",
            "data" => $book
        ], 200);
    }
}
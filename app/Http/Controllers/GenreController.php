<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GenreController extends Controller
{
    public function index()
    {

        $genres = Genre::all();
        if ($genres->isEmpty()) {
            return response()->json([
                "success" => true,
                "message" => "Resource data not found!",
            ], 200);
        }

        $genres = Genre::all();
        return response()->json([
            "succes" => true,
            "mesage" => "Get all resources",
            "data" => $genres
        ],200);
    }

    //1. Validator
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        //2. Check validator error
        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => "Validator error",
                "data" => $validator->errors()
            ], 422);
        }

        //3. Insert data
        Genre::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        return response()->json([
            "success" => true,
            "message" => "Resource created successfully",
        ], 201);
    }

    // Fungsi show untuk menampilkan detail genre berdasarkan ID
    public function show($id)
    {
        $genre = Genre::find($id);
        if (!$genre) {
            return response()->json([
                "success" => false,
                "message" => "Resource not found",
            ], 404);
        }
    
        return response()->json([
            "success" => true,
            "message" => "Get resource",
            "data" => $genre
        ], 200);
    }
    
    // Fungsi destroy untuk menghapus genre berdasarkan ID
    public function destroy($id)
    {
        $genre = Genre::find($id);
        if (!$genre) {
            return response()->json([
                "success" => false,
                "message" => "Resource not found",
            ], 404);
        }
    
        $genre->delete();
    
        return response()->json([
            "success" => true,
            "message" => "Resource deleted successfully",
        ], 200);
    }
    
    // Fungsi untuk mengupdate genre berdasarkan ID
    public function update(Request $request, $id)
    {
        // 1. Mencari Data
        $genre = Genre::find($id);
        if (!$genre) {
            return response()->json([
                "success" => false,
                "message" => "Resource not found",
            ], 404);
        }
    
        // 2. Validator
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'description' => 'string',
        ]);
    
        // 3. Check validator error
        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => "Validator error",
                "data" => $validator->errors()
            ], 422);
        }
    
        // 4. Siapkan data untuk update
        $data = [
            'name' => $request->input('name', $genre->name),
            'description' => $request->input('description', $genre->description),
        ];
    
        // 5. Update data genre
        $genre->update($data);
    
        return response()->json([
            "success" => true,
            "message" => "Resource updated successfully",
            "data" => $genre
        ], 200);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{
    public function index()
    {

        $authors = Author::all();
        if ($authors->isEmpty()) {
            return response()->json([
                "success" => true,
                "message" => "Resource data not found!",
            ], 200);
        }

        $authors = Author::all();
        return response()->json([
            "success" => true,
            "message" => "Get all resources",
            "data" => $authors
        ], 200);
    }

    public function store (Request $request) {
        //1. Validator
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio' => 'required|string',
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
        $image = $request->file('photo');
        if ($image) {
            $image->store('authors', 'public');
            $photoName = $image->hashName();
        } else {
            $photoName = null;
        }

        //4. Insert data
        Author::create ([
            'name' => $request->input('name'),
            'photo' => $photoName,
            'bio' => $request->input('bio'),
        ]);

        //5. Response
        return response()->json([
            "success" => true,
            "message" => "Resource created",
            "data" => [
                'name' => $request->input('name'),
                'photo' => $photoName,
                'bio' => $request->input('bio'),
            ]
        ], 201);
    }

    // Fungsi show untuk menampilkan detail author berdasarkan ID
    public function show($id)
    {
        $author = Author::find($id);
        if (!$author) {
            return response()->json([
                "success" => false,
                "message" => "Resource not found",
            ], 404);
        }
    
        return response()->json([
            "success" => true,
            "message" => "Get resource",
            "data" => $author
        ], 200);
    }
    
    // Fungsi destroy untuk menghapus author berdasarkan ID
    public function destroy($id)
    {
        $author = Author::find($id);
        if (!$author) {
            return response()->json([
                "success" => false,
                "message" => "Resource not found",
            ], 404);
        }
    
        if ($author->photo) {
            // Hapus file foto dari storage
            \Storage::disk('public')->delete('authors/' . $author->photo);
        }
    
        $author->delete();
    
        return response()->json([
            "success" => true,
            "message" => "Resource deleted successfully",
        ], 200);
    }
    
    // Fungsi untuk mengupdate author berdasarkan ID
    public function update(Request $request, $id)
    {
        // 1. Mencari Data
        $author = Author::find($id);
        if (!$author) {
            return response()->json([
                "success" => false,
                "message" => "Resource not found",
            ], 404);
        }
    
        // 2. Validator
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'bio' => 'string',
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
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
            'name' => $request->input('name', $author->name),
            'bio' => $request->input('bio', $author->bio),
        ];
    
        // 5. Handle image (upload dan hapus foto)
        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $image->store('authors', 'public');
    
            if ($author->photo) {
                // Hapus file foto lama dari storage
                \Storage::disk('public')->delete('authors/' . $author->photo);
            }
    
            $data['photo'] = $image->hashName();
        }
        // 6. Update data author
        $author->update($data);
    
        return response()->json([
            "success" => true,
            "message" => "Resource updated successfully",
            "data" => $author
        ], 200);
    }
}

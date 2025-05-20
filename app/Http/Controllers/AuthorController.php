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
}

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
}

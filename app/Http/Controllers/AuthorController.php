<?php

namespace App\Http\Controllers;

use App\Models\Author;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::all();
        return response()->json([
            "succes" => true,
            "mesage" => "Get all resources",
            "data" => $authors
        ],200);
    }
}

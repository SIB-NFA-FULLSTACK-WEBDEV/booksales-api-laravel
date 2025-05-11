<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\GenreController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/authors', [AuthorController::class, 'index'])->name('authors.index');
Route::get('/genres', [GenreController::class, 'index'])->name('genres.index');
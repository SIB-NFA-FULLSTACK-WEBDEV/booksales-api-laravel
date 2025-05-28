<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Autentikasi
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');

// Cek user login
Route::middleware(['auth:api'])->group(function() {

    Route::apiResource('/books', BookController::class)->only(['index', 'show']);
    Route::apiResource('/authors', AuthorController::class)->only(['index', 'show']);
    Route::apiResource('/genres', GenreController::class)->only(['index', 'show']);
    Route::apiResource('/transactions', TransactionController::class)->only(['index', 'store', 'show']);

    // Hanya untuk admin (butuh autentikasi dan role admin)
    Route::middleware('role:admin')->group(function () {
        Route::apiResource('books', BookController::class)->only(['store', 'update', 'destroy']);
        Route::apiResource('authors', AuthorController::class)->only(['store', 'update', 'destroy']);
        Route::apiResource('genres', GenreController::class)->only(['store', 'update', 'destroy']);
        Route::apiResource('transactions', TransactionController::class)->only(['update', 'destroy']);
    });
});

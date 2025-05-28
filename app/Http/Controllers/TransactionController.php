<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('user', 'book')->get();

        if ($transactions->isEmpty()) {
            return response()->json([
                "success" => true,
                "message" => "Resource data not found!",
            ], 200);
        }

        return response()->json([
            "success" => true,
            "message" => "Get all resources",
            "data" => $transactions
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'book_id' => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => "Validation failed",
                "errors" => $validator->errors()
            ], 422);
        }

        $uniqueCode = 'ORD-' . strtoupper(uniqid());

        $user = auth('api')->user();
        if (!$user) {
            return response()->json([
                "success" => false,
                "message" => "Unauthorised!"
            ], 401);
        }

        $book = Book::find($request->book_id);

        if ($book->stock < $request->quantity) {
            return response()->json([
                "success" => false,
                "message" => "Stok barang tidak cukup"
            ], 400);
        }

        $totalAmount = $book->price * $request->quantity;

        $book->stock -= $request->quantity;
        $book->save();

        $transaction = Transaction::create([
            'order_number' => $uniqueCode,
            'user_id' => $user->id,
            'book_id' => $request->book_id,
            'quantity' => $request->quantity,
            'total_amount' => $totalAmount
        ]);

        return response()->json([
            "success" => true,
            "message" => "Transaction created successfully",
            "data" => $transaction
        ], 201);
    }

    // Menampilkan detail transaksi berdasarkan ID
    public function show($id)
    {
        $transaction = Transaction::find($id);
        if (!$transaction) {
            return response()->json([
                "success" => false,
                "message" => "Resource not found",
            ], 404);
        }

        return response()->json([
            "success" => true,
            "message" => "Get resource",
            "data" => $transaction
        ], 200);
    }

    // Menghapus transaksi berdasarkan ID
    public function destroy($id)
    {
        $transaction = Transaction::find($id);
        if (!$transaction) {
            return response()->json([
                "success" => false,
                "message" => "Resource not found",
            ], 404);
        }

        $transaction->delete();

        return response()->json([
            "success" => true,
            "message" => "Resource deleted successfully",
        ], 200);
    }

    // Mengupdate transaksi berdasarkan ID
    public function update(Request $request, $id)
    {
        $transaction = Transaction::find($id);
        if (!$transaction) {
            return response()->json([
                "success" => false,
                "message" => "Resource not found",
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'user_id' => 'exists:users,id',
            'book_id' => 'exists:books,id',
            'quantity' => 'integer',
            'total_price' => 'numeric',
            'status' => 'string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => "Validator error",
                "data" => $validator->errors()
            ], 422);
        }

        $data = [
            'user_id' => $request->input('user_id', $transaction->user_id),
            'book_id' => $request->input('book_id', $transaction->book_id),
            'quantity' => $request->input('quantity', $transaction->quantity),
            'total_price' => $request->input('total_price', $transaction->total_price),
            'status' => $request->input('status', $transaction->status),
        ];

        $transaction->update($data);

        return response()->json([
            "success" => true,
            "message" => "Resource updated successfully",
            "data" => $transaction
        ], 200);
    }
}

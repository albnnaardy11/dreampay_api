<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['user', 'recipient', 'category'])->latest()->get();
        return response()->json($transactions, 200);
    }

    public function userHistory(Request $request)
    {
        $transactions = Transaction::where('user_id', $request->user()->id)
            ->with(['recipient', 'category'])
            ->latest()
            ->get();
            
        return response()->json($transactions, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:1',
            'description' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            return DB::transaction(function () use ($request) {
                $user = User::where('id', $request->user_id)->lockForUpdate()->first();

                if (!$user) {
                    return response()->json(['message' => 'User not found'], 404);
                }

                if ($user->balance < $request->amount) {
                    return response()->json(['message' => 'Insufficient balance'], 400);
                }

                $user->decrement('balance', $request->amount);

                $transaction = Transaction::create([
                    'user_id' => $user->id,
                    'amount' => $request->amount,
                    'description' => $request->description,
                    'type' => 'payment',
                    'status' => 'success',
                    'category_id' => $request->category_id,
                ]);

                // Award points (example: 1 point for every 1000 spent)
                $points = floor($request->amount / 1000);
                $user->increment('points', $points);

                // Update Tier logic
                if ($user->points > 1000) {
                    $user->tier = 'Gold';
                } elseif ($user->points > 500) {
                    $user->tier = 'Silver';
                }
                $user->save();

                return response()->json([
                    'message' => 'Payment successful',
                    'transaction' => $transaction,
                    'current_balance' => $user->balance,
                    'points_earned' => $points,
                    'current_tier' => $user->tier
                ], 201);
            });
        } catch (\Exception $e) {
            return response()->json(['message' => 'Payment failed', 'error' => $e->getMessage()], 500);
        }
    }

    public function show(string $id)
    {
        $transaction = Transaction::with(['user', 'recipient', 'category'])->find($id);

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        return response()->json($transaction, 200);
    }

    public function destroy(string $id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        $transaction->delete();
        return response()->json(['message' => 'Transaction deleted successfully'], 200);
    }
}
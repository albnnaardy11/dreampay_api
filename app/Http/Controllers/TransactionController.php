<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    /**
     * @OA\Get(
     *     path="/transactions",
     *     summary="List all transactions (Admin)",
     *     tags={"Transactions"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of transactions",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Transaction"))
     *     )
     * )
     */
    public function index()
    {
        $transactions = Transaction::with(['user', 'recipient', 'category'])->latest()->get();
        return response()->json($transactions, 200);
    }

    /**
     * @OA\Get(
     *     path="/history",
     *     summary="Get authenticated user transaction history",
     *     tags={"Transactions"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="User transaction history",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Transaction"))
     *     )
     * )
     */
    public function userHistory(Request $request)
    {
        $transactions = Transaction::where('user_id', $request->user()->id)
            ->with(['recipient', 'category'])
            ->latest()
            ->get();
            
        return response()->json($transactions, 200);
    }

    /**
     * @OA\Post(
     *     path="/transactions",
     *     summary="Create a new payment transaction",
     *     tags={"Transactions"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_id","amount","description"},
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="amount", type="number", example=15000),
     *             @OA\Property(property="description", type="string", example="Beli Nasi Goreng"),
     *             @OA\Property(property="category_id", type="integer", example=2)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Payment successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Payment successful"),
     *             @OA\Property(property="transaction", ref="#/components/schemas/Transaction"),
     *             @OA\Property(property="current_balance", type="number", example=35000),
     *             @OA\Property(property="points_earned", type="integer", example=15)
     *         )
     *     ),
     *     @OA\Response(response=400, description="Insufficient balance or validation error"),
     *     @OA\Response(response=404, description="User not found")
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/transactions/{id}",
     *     summary="Get transaction details",
     *     tags={"Transactions"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="string")),
     *     @OA\Response(
     *         response=200,
     *         description="Transaction details",
     *         @OA\JsonContent(ref="#/components/schemas/Transaction")
     *     ),
     *     @OA\Response(response=404, description="Transaction not found")
     * )
     */
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
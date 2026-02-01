<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Topup;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    /**
     * Topup User Balance (Admin Only)
     */
    public function topup(Request $request)
    {
        // Simple role check (In real app, use Middleware)
        if ($request->user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized. Admin only.'], 403);
        }

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:1000',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            return DB::transaction(function () use ($request) {
                $user = User::where('id', $request->user_id)->lockForUpdate()->first();
                
                // 1. Create Topup Record
                Topup::create([
                    'user_id' => $user->id,
                    'amount' => $request->amount,
                ]);

                // 2. Increment Balance
                $user->increment('balance', $request->amount);

                // 3. Record Transaction
                Transaction::create([
                    'user_id' => $user->id,
                    'amount' => $request->amount,
                    'description' => 'Topup via Admin',
                    'type' => 'topup',
                    'status' => 'success',
                ]);

                return response()->json([
                    'message' => 'Topup successful',
                    'user' => $user->name,
                    'new_balance' => $user->balance
                ]);
            });
        } catch (\Exception $e) {
            return response()->json(['message' => 'Topup failed', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * List all users for admin management
     */
    public function listUsers()
    {
        $users = User::all();
        return response()->json($users);
    }
}

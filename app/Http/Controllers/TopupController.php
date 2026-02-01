<?php

namespace App\Http\Controllers;

use App\Models\Topup;
use Illuminate\Http\Request;

class TopupController extends Controller
{

    public function index()
    {
        $userTopups = Topup::all();

        return response()->json($userTopups, 200);
    }


    public function store(Request $request)
    {
        $requestData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:1000',
        ]);

        try {
            return \Illuminate\Support\Facades\DB::transaction(function () use ($requestData) {
                $topup = Topup::create([
                    'user_id' => $requestData['user_id'],
                    'amount' => $requestData['amount'],
                ]);

                // Update User Balance
                $user = \App\Models\User::find($requestData['user_id']);
                $user->increment('balance', $requestData['amount']);

                // Record Transaction
                \App\Models\Transaction::create([
                    'user_id' => $user->id,
                    'amount' => $requestData['amount'],
                    'description' => 'Topup Saldo via Admin/Gateway',
                    'type' => 'topup',
                    'status' => 'success',
                ]);

                return response()->json([
                    'message' => 'Topup successful',
                    'current_balance' => $user->balance
                ], 201);
            });
        } catch (\Exception $e) {
            return response()->json(['message' => 'Topup failed', 'error' => $e->getMessage()], 500);
        }
    }

    public function show(string $id)
    {
        // Ganti dengan cara Anda mengambil data topup, misalnya:
        $topup = Topup::find($id);

        // Check if the topup record exists
        if (!$topup) {
            return response()->json(['message' => 'Topup not found'], 404);
        }

        // Return the topup record as a JSON response
        return response()->json($topup, 200);
    }

    public function update(Request $request, string $id)
{
    $requestData = $request->validate([
        'amount' => 'required|numeric',
    ]);

    $topup = Topup::find($id);

    if (!$topup) {
        return response()->json(['message' => 'Topup not found'], 404);
    }

    $topup->update($requestData);

    return response()->json(['message' => 'Topup updated successfully'], 200);
}


public function destroy(string $id)
{
    $topup = Topup::find($id);

    if (!$topup) {
        return response()->json(['message' => 'Topup not found'], 404);
    }

    $topup->delete();

    return response()->json(['message' => 'Topup deleted successfully'], 200);
}

}

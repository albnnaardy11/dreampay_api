<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Topup;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::all();
        return response()->json(['transactions' => $transactions], 200);
    }

    public function store(Request $request)
    {
        $requestData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric',
            'description' => 'required|string',

        ]);

        $transaction = new Transaction([
            'user_id' => $requestData['user_id'],
            'amount' => $requestData['amount'],
            'description' => $requestData['description'],

        ]);

        $transaction->save();

        return response()->json(['message' => 'Transaction created successfully', 'transaction' => $transaction], 201);
    }

    public function show(string $id)
    {
        $transaction = Transaction::find($id);

        if ($transaction) {
            return response()->json(['transaction' => $transaction], 200);
        } else {
            return response()->json(['message' => 'Transaction not found'], 404);
        }
    }

    public function update(Request $request, string $id)
    {
        $transaction = Transaction::find($id);

        if ($transaction) {
            $transaction->amount = $request->input('amount');
            $transaction->save();

            return response()->json(['message' => 'Transaction updated successfully', 'transaction' => $transaction], 200);
        } else {
            return response()->json(['message' => 'Transaction not found'], 404);
        }
    }

    public function destroy(string $id)
    {
        $transaction = Transaction::find($id);

        if ($transaction) {
            $transaction->delete();
            return response()->json(['message' => 'Transaction deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Transaction not found'], 404);
        }
    }
}

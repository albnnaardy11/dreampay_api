<?php

namespace App\Http\Controllers;

use App\Models\Topup;
use Illuminate\Http\Request;

class TopupController extends Controller
{

    public function index()
{
    $user_id = auth()->id();

    $userTopups = Topup::where('user_id', $user_id)->get();

    // Return the topup records as a JSON response
    return response()->json($userTopups, 200);
}


    public function store(Request $request)
    {
        $requestData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric',
        ]);

        $topup = new Topup([
            'user_id' => $requestData['user_id'],
            'amount' => $requestData['amount'],
        ]);
        $topup->save();

        return response()->json(['message' => 'Topup created successfully'], 201);
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
        // Validate the request data
        $requestData = $request->validate([
            'amount' => 'required|numeric',
        ]);

        $topup = auth()->user()->topups->find($id);

        if (!$topup) {
            return response()->json(['message' => 'Topup not found'], 404);
        }

        $topup->update($requestData);

        return response()->json(['message' => 'Topup updated successfully'], 200);
    }

    public function destroy(string $id)
    {
        // Logic to delete the specific topup record for the current user
        $topup = auth()->user()->topups->find($id);

        if (!$topup) {
            return response()->json(['message' => 'Topup not found'], 404);
        }

        $topup->delete();

        return response()->json(['message' => 'Topup deleted successfully'], 200);
    }
}

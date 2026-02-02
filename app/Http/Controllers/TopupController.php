<?php

namespace App\Http\Controllers;

use App\Models\Topup;
use Illuminate\Http\Request;

class TopupController extends Controller
{

    /**
     * @OA\Get(
     *     path="/topups",
     *     summary="List all topup requests (Admin)",
     *     tags={"Topups"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of topups",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Topup"))
     *     )
     * )
     */
    public function index()
    {
        $userTopups = Topup::all();

        return response()->json($userTopups, 200);
    }


    /**
     * @OA\Post(
     *     path="/topups",
     *     summary="Create a new topup (Admin/Gateway)",
     *     tags={"Topups"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_id","amount"},
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="amount", type="number", example=50000)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Topup successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Topup successful"),
     *             @OA\Property(property="current_balance", type="number")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/topups/{id}",
     *     summary="Get topup details",
     *     tags={"Topups"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="string")),
     *     @OA\Response(
     *         response=200,
     *         description="Topup details",
     *         @OA\JsonContent(ref="#/components/schemas/Topup")
     *     ),
     *     @OA\Response(response=404, description="Topup not found")
     * )
     */
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

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TransferController extends Controller
{
    /**
     * @OA\Post(
     *     path="/transfer",
     *     summary="Transfer balance to another user",
     *     tags={"Transactions"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"recipient_email","amount","pin"},
     *             @OA\Property(property="recipient_email", type="string", format="email", example="santri2@example.com"),
     *             @OA\Property(property="amount", type="number", example=10000),
     *             @OA\Property(property="pin", type="string", example="123456")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Transfer successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Transfer successful"),
     *             @OA\Property(property="current_balance", type="number")
     *         )
     *     ),
     *     @OA\Response(response=400, description="Invalid data or insufficient balance"),
     *     @OA\Response(response=403, description="Invalid PIN"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function transfer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'recipient_email' => 'required|email|exists:users,email',
            'amount' => 'required|numeric|min:1',
            'pin' => 'required|string|size:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            DB::beginTransaction();

            $sender = User::where('id', $request->user()->id)->lockForUpdate()->first();
            $recipient = User::where('email', $request->recipient_email)->lockForUpdate()->first();

            if ($sender->id === $recipient->id) {
                return response()->json(['message' => 'Cannot transfer to yourself'], 400);
            }

            // 1. Check PIN
            if (!\Illuminate\Support\Facades\Hash::check($request->pin, $sender->pin)) {
                return response()->json(['message' => 'Invalid PIN'], 403);
            }

            // 2. Check Balance
            if ($sender->balance < $request->amount) {
                return response()->json(['message' => 'Insufficient balance'], 400);
            }

            // Deduct from sender
            $sender->decrement('balance', $request->amount);
            
            // Add to recipient
            $recipient->increment('balance', $request->amount);

            // Record transaction for sender (OUT)
            Transaction::create([
                'user_id' => $sender->id,
                'recipient_id' => $recipient->id,
                'amount' => $request->amount,
                'description' => 'Transfer to ' . $recipient->name,
                'type' => 'transfer_out',
                'status' => 'success',
            ]);

            // Record transaction for recipient (IN)
            Transaction::create([
                'user_id' => $recipient->id,
                'recipient_id' => $sender->id, // sender as source
                'amount' => $request->amount,
                'description' => 'Transfer from ' . $sender->name,
                'type' => 'transfer_in',
                'status' => 'success',
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Transfer successful',
                'current_balance' => $sender->balance,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Transfer failed', 'error' => $e->getMessage()], 500);
        }
    }
}

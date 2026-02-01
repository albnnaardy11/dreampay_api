<?php

namespace App\Http\Controllers;

use App\Models\SplitBill;
use App\Models\SplitBillMember;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SplitBillController extends Controller
{
    /**
     * Create a new Split Bill
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'total_amount' => 'required|numeric|min:1',
            'description' => 'required|string|max:255',
            'participants' => 'required|array|min:1',
            'participants.*.user_id' => 'required|exists:users,id',
            'participants.*.amount' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            return DB::transaction(function () use ($request) {
                // 1. Create Split Bill Master
                $splitBill = SplitBill::create([
                    'owner_id' => $request->user()->id,
                    'total_amount' => $request->total_amount,
                    'description' => $request->description,
                    'status' => 'pending',
                ]);

                // 2. Create Participants/Members
                foreach ($request->participants as $participant) {
                    SplitBillMember::create([
                        'split_bill_id' => $splitBill->id,
                        'user_id' => $participant['user_id'],
                        'amount' => $participant['amount'],
                        'status' => 'pending',
                    ]);
                }

                return response()->json([
                    'message' => 'Split Bill created successfully',
                    'split_bill' => $splitBill->load('members'),
                ], 201);
            });
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create Split Bill', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Pay a specific Split Bill member share
     */
    public function pay(Request $request, $memberId)
    {
        $validator = Validator::make($request->all(), [
            'pin' => 'required|string|size:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            DB::beginTransaction();

            $member = SplitBillMember::with('splitBill')->where('id', $memberId)->lockForUpdate()->first();

            if (!$member || $member->user_id !== $request->user()->id) {
                DB::rollBack();
                return response()->json(['message' => 'Bill detail not found or unauthorized'], 404);
            }

            if ($member->status === 'paid') {
                DB::rollBack();
                return response()->json(['message' => 'You have already paid this bill'], 400);
            }

            $user = User::where('id', $request->user()->id)->lockForUpdate()->first();

            // Check PIN
            if (!\Illuminate\Support\Facades\Hash::check($request->pin, $user->pin)) {
                DB::rollBack();
                return response()->json(['message' => 'Invalid PIN'], 403);
            }

            if ($user->balance < $member->amount) {
                DB::rollBack();
                return response()->json(['message' => 'Insufficient balance'], 400);
            }

            // 1. Deduct member balance
            $user->decrement('balance', $member->amount);

            // 2. Add to split bill owner balance
            $owner = User::where('id', $member->splitBill->owner_id)->lockForUpdate()->first();
            $owner->increment('balance', $member->amount);

            // 3. Update member status
            $member->update(['status' => 'paid']);

            // 4. Record Transactions for both
            Transaction::create([
                'user_id' => $user->id,
                'recipient_id' => $owner->id,
                'amount' => $member->amount,
                'description' => 'Split Bill Payment: ' . $member->splitBill->description,
                'type' => 'transfer_out',
                'status' => 'success',
            ]);

            Transaction::create([
                'user_id' => $owner->id,
                'recipient_id' => $user->id,
                'amount' => $member->amount,
                'description' => 'Split Bill Received from ' . $user->name,
                'type' => 'transfer_in',
                'status' => 'success',
            ]);

            // 5. Check if all members paid, if so mark split bill as completed
            if ($member->splitBill->members()->where('status', 'pending')->count() === 0) {
                $member->splitBill->update(['status' => 'completed']);
            }

            DB::commit();

            return response()->json([
                'message' => 'Payment successful',
                'current_balance' => $user->balance,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Payment failed', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Get bills created by me
     */
    public function myCreatedBills(Request $request)
    {
        $bills = SplitBill::where('owner_id', $request->user()->id)
            ->with('members.user')
            ->latest()
            ->get();
            
        return response()->json($bills);
    }

    /**
     * Get bills I need to pay
     */
    public function myIncomingBills(Request $request)
    {
        $bills = SplitBillMember::where('user_id', $request->user()->id)
            ->with(['splitBill.owner'])
            ->latest()
            ->get();
            
        return response()->json($bills);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MerchantController extends Controller
{
    /**
     * @OA\Post(
     *     path="/merchant/scan-and-pay",
     *     summary="Merchant scans Santri QR Code to process payment",
     *     tags={"Merchant"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"qr_code","amount"},
     *             @OA\Property(property="qr_code", type="string", example="DP-ABC123XYZ"),
     *             @OA\Property(property="amount", type="number", example=15000),
     *             @OA\Property(property="description", type="string", example="Beli Nasi Goreng")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Payment successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Payment successful"),
     *             @OA\Property(property="merchant_balance", type="number")
     *         )
     *     ),
     *     @OA\Response(response=403, description="Only merchants can perform this action"),
     *     @OA\Response(response=404, description="Santri not found")
     * )
     */
    public function scanAndPay(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'qr_code' => 'required|exists:users,qr_code',
            'amount' => 'required|numeric|min:1',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            DB::beginTransaction();

            $merchant = User::where('id', $request->user()->id)->lockForUpdate()->first();
            if ($merchant->role !== 'merchant') {
                DB::rollBack();
                return response()->json(['message' => 'Only merchants can scan and pay'], 403);
            }

            $santri = User::where('qr_code', $request->qr_code)->lockForUpdate()->first();

            if (!$santri) {
                DB::rollBack();
                return response()->json(['message' => 'Santri not found'], 404);
            }

            if ($santri->balance < $request->amount) {
                DB::rollBack();
                return response()->json(['message' => 'Insufficient santri balance'], 400);
            }

            // 1. Deduct Santri Balance
            $santri->decrement('balance', $request->amount);

            // 2. Add Merchant Balance
            $merchant->increment('balance', $request->amount);

            // 3. Record Transaction (OUT for Santri)
            Transaction::create([
                'user_id' => $santri->id,
                'recipient_id' => $merchant->id,
                'amount' => $request->amount,
                'description' => $request->description ?? 'Payment to ' . $merchant->name,
                'type' => 'payment',
                'status' => 'success',
            ]);

            // 4. Record Transaction (IN for Merchant)
            Transaction::create([
                'user_id' => $merchant->id,
                'recipient_id' => $santri->id,
                'amount' => $request->amount,
                'description' => 'Received payment from ' . $santri->name,
                'type' => 'transfer_in',
                'status' => 'success',
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Payment successful',
                'merchant_balance' => $merchant->balance,
                'santri_name' => $santri->name
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Payment failed', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/merchant/products",
     *     summary="List merchant products",
     *     tags={"Merchant"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of products",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Product"))
     *     )
     * )
     */
    public function listProducts(Request $request)
    {
        $products = Product::where('merchant_id', $request->user()->id)->get();
        return response()->json($products);
    }

    /**
     * @OA\Post(
     *     path="/merchant/products",
     *     summary="Add a new product",
     *     tags={"Merchant"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","price","stock"},
     *             @OA\Property(property="name", type="string", example="Es Teh"),
     *             @OA\Property(property="price", type="number", example=3000),
     *             @OA\Property(property="stock", type="integer", example=100),
     *             @OA\Property(property="description", type="string", example="Es teh manis segar")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Product added",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     )
     * )
     */
    public function addProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $product = Product::create([
            'merchant_id' => $request->user()->id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        return response()->json(['message' => 'Product added', 'product' => $product], 201);
    }

    public function deleteProduct($id)
    {
        $product = Product::where('id', $id)->where('merchant_id', auth()->id())->first();
        if (!$product) return response()->json(['message' => 'Product not found'], 404);
        
        $product->delete();
        return response()->json(['message' => 'Product deleted']);
    }

    /**
     * @OA\Get(
     *     path="/merchant/sales",
     *     summary="Get merchant sales history",
     *     tags={"Merchant"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Sales history",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Transaction"))
     *     )
     * )
     */
    public function salesHistory(Request $request)
    {
        $sales = Transaction::where('user_id', $request->user()->id)
            ->where('type', 'transfer_in')
            ->latest()
            ->get();
            
        return response()->json($sales);
    }
}

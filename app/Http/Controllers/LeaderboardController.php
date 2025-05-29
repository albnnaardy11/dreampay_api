<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Topup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeaderboardController extends Controller
{
    public function showjuragan()
    {
        // 3 user dengan total transaksi terbanyak
        $topTransactions = Transaction::select('user_id', DB::raw('SUM(amount) as total_transaction'))
            ->groupBy('user_id')
            ->orderByDesc('total_transaction')
            ->limit(3)
            ->get();

        // 3 user dengan total topup terbanyak
        $topTopups = Topup::select('user_id', DB::raw('SUM(amount) as total_topup'))
            ->groupBy('user_id')
            ->orderByDesc('total_topup')
            ->limit(3)
            ->get();

        // Load data user lengkap (asumsi relasi sudah ada)
        $topTransactions->load('user:id,name');
        $topTopups->load('user:id,name');

        return response()->json([
            'top_transactions' => $topTransactions,
            'top_topups' => $topTopups,
        ]);
    }
}

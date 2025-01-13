<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function show()
    {
        $wallet = Auth::user()->wallet;
        return view('wallet.show', compact('wallet'));
    }

    public function topup(Request $request)
    {
        $amount = $request->input('amount', 100);

        $wallet = Auth::user()->wallet;
        $wallet->balance += $amount;
        $wallet->save();

        return response()->json([
            'success' => true,
            'newBalance' => number_format($wallet->balance, 0, ',', '.')
        ]);
    }
}


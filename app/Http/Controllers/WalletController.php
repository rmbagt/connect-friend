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
        $validatedData = $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $wallet = Auth::user()->wallet;
        $wallet->balance += $validatedData['amount'];
        $wallet->save();

        return redirect()->back()->with('success', __('Wallet topped up successfully.'));
    }
}


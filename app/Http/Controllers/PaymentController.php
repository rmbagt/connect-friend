<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('payment.show', compact('user'));
    }

    public function process(Request $request)
    {
        $user = Auth::user();
        $amount = $request->input('amount');

        if ($amount < $user->registration_price) {
            $underpaid = $user->registration_price - $amount;
            return redirect()->back()->with('warning', "You are still underpaid Rp " . number_format($underpaid, 0, ',', '.'));
        }

        if ($amount > $user->registration_price) {
            $overpaid = $amount - $user->registration_price;
            return redirect()->back()->with([
                'overpayment' => "Sorry you overpaid Rp " . number_format($overpaid, 0, ',', '.') . ", would you like to add it to your wallet balance?",
                'overpayment_amount' => $overpaid
            ]);
        }

        // Payment successful
        $user->update(['is_active' => true]);
        return redirect()->route('home')->with('success', 'Payment successful. Your account is now active.');
    }

    public function handleOverpayment(Request $request)
    {
        $user = Auth::user();
        $overpaymentAmount = $request->input('overpayment_amount');

        if ($request->input('action') === 'add_to_wallet') {
            $user->wallet->increment('balance', $overpaymentAmount);
            $user->update(['is_active' => true]);
            return redirect()->route('home')->with('success', 'Payment successful. Overpayment added to your wallet.');
        } else {
            return redirect()->route('payment.show')->with('info', 'Please enter the payment amount again.');
        }
    }
}
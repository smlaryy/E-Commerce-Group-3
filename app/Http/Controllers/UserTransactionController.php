<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class UserTransactionController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // kalau ada relasi buyer, pakai buyer->id, kalau tidak, pakai user->id
        $buyerId = optional($user->buyer)->id ?? $user->id;

        $transactions = Transaction::with('transactionDetails.product.store')
            ->where('buyer_id', $buyerId)
            ->latest()
            ->paginate(10);

        return view('transactions.index', compact('transactions'));
    }

    public function show($id)
    {
        $user = Auth::user();

        $buyerId = optional($user->buyer)->id ?? $user->id;

        $transaction = Transaction::with('transactionDetails.product.store')
            ->where('buyer_id', $buyerId)
            ->findOrFail($id);

        return view('transactions.show', compact('transaction'));
    }
}

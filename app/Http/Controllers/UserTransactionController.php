<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class UserTransactionController extends Controller
{
    public function index()
    {
        $buyer = Auth::user()->buyer;

        $transactions = Transaction::with('transactionDetails.product.store')
            ->where('buyer_id', $buyer->id)
            ->latest()
            ->paginate(10);

        return view('transactions.index', compact('transactions'));
    }

    public function show($id)
    {
        $buyer = Auth::user()->buyer;

        $transaction = Transaction::with('transactionDetails.product.store')
            ->where('buyer_id', $buyer->id)
            ->findOrFail($id);

        return view('transactions.show', compact('transaction'));
    }
}

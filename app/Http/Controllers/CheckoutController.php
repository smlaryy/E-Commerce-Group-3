<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = CartItem::with('product.store')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('success', 'Keranjang masih kosong.');
        }

        $buyer = Auth::user()->buyer ?? null;

        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->qty;
        });

        return view('checkout.index', compact('cartItems', 'buyer', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'address'      => 'required|string',
            'city'         => 'required|string',
            'postal_code'  => 'required|string',
            'shipping'     => 'required|string',
            'shipping_type'=> 'required|string',
        ]);

        $user  = Auth::user();
        $buyer = $user->buyer; // kalau memang ada tabel buyers

        // fallback: kalau $buyer null, pakai user_id
        $buyerId = optional($buyer)->id ?? $user->id;


        $cartItems = CartItem::with('product.store')
            ->where('user_id', $user->id)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('success', 'Keranjang masih kosong.');
        }

        $groupedByStore = $cartItems->groupBy(function ($item) {
            return $item->product->store_id;
        });

        $createdTransactions = [];

        foreach ($groupedByStore as $storeId => $items) {
            $subtotal = $items->sum(function ($item) {
                return $item->product->price * $item->qty;
            });

            $shippingCost = 0; 
            $tax          = 0;
            $grandTotal   = $subtotal + $shippingCost + $tax;

            $transaction = Transaction::create([
                'code'           => 'TRX-' . Str::upper(Str::random(8)),
                'buyer_id'       => $buyerId,
                'store_id'       => $storeId,
                'address'        => $request->address,
                'address_id'     => null,
                'city'           => $request->city,
                'postal_code'    => $request->postal_code,
                'shipping'       => $request->shipping,
                'shipping_type'  => $request->shipping_type,
                'shipping_cost'  => $shippingCost,
                'tracking_number'=> null,
                'tax'            => $tax,
                'grand_total'    => $grandTotal,
                'payment_status' => 'pending',
            ]);

            foreach ($items as $cartItem) {
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id'     => $cartItem->product_id,
                    'qty'            => $cartItem->qty,
                    'subtotal'       => $cartItem->product->price * $cartItem->qty,
                ]);

                // kurangi stok
                $cartItem->product->decrement('stock', $cartItem->qty);
            }

            $createdTransactions[] = $transaction;
        }

        // hapus semua item cart user ini
        CartItem::where('user_id', $user->id)->delete();

        // redirect ke riwayat transaksi
        return redirect()
            ->route('transactions.index')
            ->with('success', 'Pesanan berhasil dibuat, silakan cek riwayat transaksi.');
    }
}

<x-app-layout>
    <div class="max-w-5xl mx-auto py-10 px-4">
        <h1 class="text-2xl font-bold mb-4">Detail Transaksi {{ $transaction->code }}</h1>

        <div class="bg-white rounded-xl shadow-md p-4 mb-4">
            <p><strong>Tanggal:</strong> {{ $transaction->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Status Pembayaran:</strong> {{ ucfirst($transaction->payment_status) }}</p>
            <p><strong>Alamat:</strong> {{ $transaction->address }}, {{ $transaction->city }}, {{ $transaction->postal_code }}</p>
            <p><strong>Pengiriman:</strong> {{ $transaction->shipping }} ({{ $transaction->shipping_type }})</p>
        </div>

        <div class="bg-white rounded-xl shadow-md p-4 mb-4">
            <h2 class="text-xl font-semibold mb-3">Produk</h2>

            @foreach($transaction->transactionDetails as $item)
                <div class="flex justify-between border-b py-2">
                    <div>
                        <p class="font-semibold">{{ $item->product->name }}</p>
                        <p class="text-sm text-gray-500">
                            Toko: {{ $item->product->store->name ?? '-' }}
                        </p>
                        <p class="text-sm text-gray-500">
                            Qty: {{ $item->qty }}
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold">
                            Subtotal:
                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            @endforeach

            <div class="flex justify-end mt-4">
                <p class="text-xl font-bold text-orange-600">
                    Grand Total: Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}
                </p>
            </div>
        </div>
    </div>
</x-app-layout>

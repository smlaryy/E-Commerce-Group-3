{{-- resources/views/transactions/show.blade.php --}}
<x-app-layout>
    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 rounded-md bg-green-100 px-4 py-3 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <h1 class="text-2xl font-semibold mb-4">
                Transaksi {{ $transaction->code ?? ('#'.$transaction->id) }}
            </h1>

            {{-- INFO UTAMA --}}
            <div class="bg-white shadow-sm rounded-lg p-4 mb-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                    <div>
                        <p class="text-sm text-gray-600">
                            Tanggal: {{ $transaction->created_at?->format('d-m-Y H:i') }}
                        </p>
                        <p class="mt-1">
                            <span class="text-sm text-gray-600">Total:</span>
                            <span class="font-semibold">
                                Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}
                            </span>
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-600 mb-1">Status Pembayaran:</p>
                        <span class="{{ $transaction->status_badge_class }}">
                            {{ $transaction->status_label }}
                        </span>
                    </div>
                </div>

                <div class="mt-4">
                    <p class="text-sm font-semibold mb-1">Alamat Pengiriman</p>
                    <p class="text-sm text-gray-700">
                        {{ $transaction->address }}<br>
                        {{ $transaction->city }} {{ $transaction->postal_code }}
                    </p>
                </div>
            </div>

            @php
                $subtotalProduk = $transaction->transactionDetails->sum('subtotal');
                $ongkir         = $transaction->shipping_cost ?? 0;
            @endphp

            {{-- 📦 PRODUK + 🧾 RINGKASAN PEMBAYARAN --}}
            <div class="grid md:grid-cols-2 gap-4 mb-6">

                {{-- 📦 PRODUK --}}
                <div class="bg-white shadow-sm rounded-lg p-4">
                    <h2 class="text-lg font-semibold mb-3">Produk</h2>

                    <div class="border-t pt-2 space-y-2 text-sm">
                        @foreach ($transaction->transactionDetails as $detail)
                            <div class="flex justify-between">
                                <div>
                                    <p class="font-medium">
                                        {{ $detail->product->name ?? '-' }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        {{ $detail->qty }} x
                                        Rp {{ number_format($detail->price, 0, ',', '.') }}
                                        @if($detail->product?->store)
                                            · {{ $detail->product->store->name }}
                                        @endif
                                    </p>
                                </div>
                                <p class="font-semibold">
                                    Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                </p>
                            </div>

                            @if(!$loop->last)
                                <hr class="border-dashed">
                            @endif
                        @endforeach
                    </div>
                </div>

                {{-- 🧾 RINGKASAN PEMBAYARAN --}}
                <div class="bg-white shadow-sm rounded-lg p-4">
                    <h2 class="text-lg font-semibold mb-3">Ringkasan Pembayaran</h2>

                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span>Subtotal Produk</span>
                            <span class="font-medium">
                                Rp {{ number_format($subtotalProduk, 0, ',', '.') }}
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span>Ongkir</span>
                            <span class="font-medium">
                                Rp {{ number_format($ongkir, 0, ',', '.') }}
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span>Biaya Lainnya</span>
                            <span class="font-medium">Rp 0</span>
                        </div>

                        <hr class="my-2">

                        <div class="flex justify-between text-base md:text-lg font-semibold text-orange-600">
                            <span>Total Pembayaran</span>
                            <span>
                                Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>

            </div>

            {{-- BAGIAN PEMBAYARAN --}}
            <div class="bg-white shadow-sm rounded-lg p-4">
                @if ($transaction->payment_status === \App\Models\Transaction::STATUS_PENDING)
                    <h2 class="text-lg font-semibold mb-3">Pembayaran</h2>

                    @php
                        $method = $transaction->payment_method;
                    @endphp

                    <div class="space-y-2 text-sm text-gray-700">

                        @if ($method === 'BCA_VA')
                            <p>Metode pembayaran yang dipilih: <strong>BCA Virtual Account</strong></p>
                            <p>Silakan transfer ke rekening berikut:</p>
                            <ul class="list-disc ml-5 mb-2 text-gray-800">
                                <li>
                                    <strong>BCA Virtual Account</strong><br>
                                    Kode VA:
                                    <span class="font-mono text-orange-600">
                                        8888-{{ $transaction->id }}
                                    </span>
                                </li>
                            </ul>
                            <p>Setelah melakukan transfer, klik tombol di bawah untuk konfirmasi bahwa Anda sudah membayar.</p>

                        @elseif ($method === 'BNI_VA')
                            <p>Metode pembayaran yang dipilih: <strong>BNI Virtual Account</strong></p>
                            <p>Silakan transfer ke rekening berikut:</p>
                            <ul class="list-disc ml-5 mb-2 text-gray-800">
                                <li>
                                    <strong>BNI Virtual Account</strong><br>
                                    Kode VA:
                                    <span class="font-mono text-orange-600">
                                        8810-{{ $transaction->id }}
                                    </span>
                                </li>
                            </ul>
                            <p>Setelah melakukan transfer, klik tombol di bawah untuk konfirmasi bahwa Anda sudah membayar.</p>

                        @elseif ($method === 'QRIS')
                            <p>Metode pembayaran yang dipilih: <strong>QRIS</strong>.</p>
                            <p>Silakan scan kode QRIS yang disediakan untuk menyelesaikan pembayaran.</p>
                            {{-- Nanti kalau sudah punya gambar QR, taruh di sini --}}
                            {{-- <img src="{{ asset('images/qris-example.png') }}" class="w-40 h-40 mt-2"> --}}
                            <p class="text-xs text-gray-500 mt-1">
                                Setelah berhasil membayar, klik tombol di bawah untuk konfirmasi bahwa Anda sudah membayar.
                            </p>

                        @else
                            <p>Metode pembayaran: <strong>{{ $method ?? 'Belum ditentukan' }}</strong></p>
                            <p>Ikuti instruksi pembayaran yang dikirim oleh admin.</p>
                        @endif
                    </div>

                    <form action="{{ route('transactions.pay', $transaction->id) }}" method="POST" class="mt-4">
                        @csrf
                        <button
                            class="px-4 py-2 bg-orange-500 hover:bg-orange-600 
                                   text-white rounded-md font-semibold shadow transition"
                        >
                            Saya sudah bayar
                        </button>
                    </form>
                @else
                    <div class="rounded-md bg-green-100 px-4 py-3 text-sm text-green-700">
                        Pembayaran sudah diterima. Terima kasih! 🎉
                    </div>
                @endif

                <div class="mt-4">
                    <a
                        href="{{ route('transactions.index') }}"
                        class="text-sm text-orange-500 hover:text-orange-600"
                    >
                        ← Kembali ke Riwayat Transaksi
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

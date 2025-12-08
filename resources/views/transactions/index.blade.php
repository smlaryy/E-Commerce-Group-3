<x-app-layout>
    <div class="max-w-5xl mx-auto py-10 px-4">
        <h1 class="text-3xl font-bold mb-6">Riwayat Transaksi</h1>

        @if($transactions->count() == 0)
            <p class="text-gray-600">Belum ada transaksi.</p>
        @else
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left">Kode</th>
                            <th class="px-4 py-2 text-left">Tanggal</th>
                            <th class="px-4 py-2 text-right">Total</th>
                            <th class="px-4 py-2 text-left">Status</th>
                            <th class="px-4 py-2 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $trx)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $trx->code }}</td>
                                <td class="px-4 py-2">{{ $trx->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-4 py-2 text-right">
                                    Rp {{ number_format($trx->grand_total, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-2">{{ ucfirst($trx->payment_status) }}</td>
                                <td class="px-4 py-2 text-center">
                                    <a href="{{ route('transactions.show', $trx->id) }}"
                                       class="text-orange-600 hover:underline">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>
</x-app-layout>

<x-app-layout>
<div class="max-w-5xl mx-auto py-10">
    <h1 class="text-3xl font-bold mb-6">Keranjang Belanja</h1>

    @if($cartItems->count() == 0)
        <p class="text-gray-600">Keranjang kamu kosong.</p>
    @else
        <div class="space-y-4">

            @foreach($cartItems as $item)
            <div class="flex items-center justify-between bg-white p-4 rounded-xl shadow-md">

                <div class="flex items-center gap-4">
                    <img src="{{ asset('storage/' . ($item->product->productImages->first()->image ?? 'default.jpg')) }}"
                         class="w-20 h-20 object-cover rounded-lg">

                    <div>
                        <p class="font-semibold">{{ $item->product->name }}</p>
                        <p class="text-orange-600 font-bold">
                            Rp {{ number_format($item->product->price, 0, ',', '.') }}
                        </p>

                        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center mt-2">
                            @csrf
                            <input type="number" name="qty" min="1" value="{{ $item->qty }}"
                                class="w-16 border rounded-lg px-2 py-1">
                            <button class="ml-3 bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg text-sm">
                                Update
                            </button>
                        </form>
                    </div>
                </div>

                <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                    @csrf @method('DELETE')
                    <button class="text-red-600 hover:underline">Hapus</button>
                </form>

            </div>
            @endforeach

        </div>

        <div class="mt-8 p-6 bg-white shadow-lg rounded-xl">
            <h2 class="text-xl font-bold">Total: Rp {{ number_format($total, 0, ',', '.') }}</h2>

            <a href="{{ route('checkout.index') }}"
                class="mt-4 inline-block bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg font-semibold">
                Checkout Sekarang →
            </a>
        </div>
    @endif
</div>
</x-app-layout>

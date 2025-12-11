{{-- resources/views/products/show.blade.php --}}
<x-app-layout>
    <div class="max-w-6xl mx-auto py-10 px-4">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            {{-- FOTO PRODUK --}}
            <div>
                @php
                    $mainImage = $product->productImages->first()
                        ? asset('storage/' . $product->productImages->first()->image)
                        : 'https://via.placeholder.com/500';
                @endphp

                <img src="{{ $mainImage }}"
                     class="w-full h-80 object-cover rounded-2xl shadow-lg"
                     alt="{{ $product->name }}">

                <div class="flex gap-3 mt-4 overflow-x-auto">
                    @foreach($product->productImages as $img)
                        <img src="{{ asset('storage/' . $img->image) }}"
                             class="w-20 h-20 rounded-lg object-cover border hover:scale-105 transition cursor-pointer"
                             alt="">
                    @endforeach
                </div>
            </div>

            {{-- INFO PRODUK --}}
            <div>
                <p class="text-sm text-gray-500 mb-1">
                    Kategori: {{ $product->productCategory->name ?? '-' }}
                </p>

                <h1 class="text-3xl font-bold text-gray-800 mb-3">
                    {{ $product->name }}
                </h1>

                <p class="text-2xl font-bold text-orange-600 mb-4">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </p>

                <p class="text-sm text-gray-500 mb-4">
                    Toko: {{ $product->store->name ?? '-' }}
                </p>

                <p class="text-gray-700 leading-relaxed mb-6">
                    {{ $product->description ?? 'Tidak ada deskripsi produk.' }}
                </p>

                {{-- Tombol tambah ke keranjang --}}
                @auth
                    @if(auth()->user()->role === 'buyer')
                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                    class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg font-semibold shadow">
                                Tambah ke Keranjang
                            </button>
                        </form>
                    @endif
                @else
                    <a href="{{ route('login') }}"
                       class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg font-semibold shadow">
                        Login untuk Belanja
                    </a>
                @endauth
            </div>
        </div>

        {{-- PRODUK TERKAIT --}}
        @if($relatedProducts->count())
            <div class="mt-14">
                <h2 class="text-xl font-bold mb-4">Produk Terkait</h2>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-5">
                    @foreach($relatedProducts as $item)
                        <a href="{{ route('product.show', $item->slug) }}"
                           class="bg-white rounded-xl shadow hover:shadow-lg overflow-hidden transition block">
                            @php
                                $thumb = $item->productImages->first()
                                    ? asset('storage/' . $item->productImages->first()->image)
                                    : 'https://via.placeholder.com/400';
                            @endphp

                            <img src="{{ $thumb }}"
                                 class="w-full h-32 object-cover" alt="{{ $item->name }}">
                            <div class="p-3">
                                <p class="text-xs text-gray-500 mb-1">
                                    {{ $item->store->name ?? '-' }}
                                </p>
                                <p class="text-sm font-semibold text-gray-800 line-clamp-2">
                                    {{ $item->name }}
                                </p>
                                <p class="text-sm font-bold text-orange-600 mt-1">
                                    Rp {{ number_format($item->price, 0, ',', '.') }}
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-app-layout>

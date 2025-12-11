<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Pengaturan Profil
                </h2>
                <p class="text-xs text-gray-500 mt-1">
                    Kelola informasi akun dan keamanan Sembako Mart kamu.
                </p>
            </div>

            @php
                $user = auth()->user();
                $initial = $user ? mb_strtoupper(mb_substr($user->name ?? 'A', 0, 1)) : 'A';
            @endphp

            {{-- mini badge profil di header --}}
            <div class="hidden sm:flex items-center gap-3 bg-white px-3 py-2 rounded-full shadow-sm">
                <div class="flex items-center justify-center w-9 h-9 rounded-full bg-orange-500 text-white font-semibold">
                    {{ $initial }}
                </div>
                <div class="flex flex-col">
                    <span class="text-sm font-semibold text-gray-800">
                        {{ $user->name ?? 'User' }}
                    </span>
                    <span class="text-xs text-gray-500">
                        {{ $user->email }}
                    </span>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Kolom kiri: info singkat --}}
                <div class="space-y-4">
                    <div class="bg-white rounded-xl shadow-sm p-4">
                        <h3 class="text-sm font-semibold text-gray-800 mb-2">Profil Akun</h3>
                        <p class="text-xs text-gray-500 leading-relaxed">
                            Ubah nama dan email akun kamu. Informasi ini akan digunakan di seluruh sistem Sembako Mart.
                        </p>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-4">
                        <h3 class="text-sm font-semibold text-gray-800 mb-2">Keamanan</h3>
                        <p class="text-xs text-gray-500 mb-2">
                            Rutin ganti password untuk menjaga keamanan akunmu.
                        </p>
                        <div class="inline-flex items-center px-2 py-1 rounded-full text-[11px] font-medium bg-green-50 text-green-700 border border-green-200">
                            ● Status: Aman
                        </div>
                    </div>

                    <div class="bg-orange-50 border border-orange-100 rounded-xl p-4">
                        <h3 class="text-sm font-semibold text-orange-700 mb-1">Tips</h3>
                        <p class="text-xs text-orange-600 leading-relaxed">
                            Gunakan email aktif dan password yang berbeda dengan akun lain untuk keamanan maksimal.
                        </p>
                    </div>
                </div>

                {{-- Kolom kanan: form profil + password (+ optional delete) --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Informasi Profil --}}
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="text-base font-semibold text-gray-800">Informasi Profil</h3>
                                <p class="text-xs text-gray-500">
                                    Perbarui nama dan alamat email akun kamu.
                                </p>
                            </div>
                        </div>

                        @include('profile.partials.update-profile-information-form')
                    </div>

                    {{-- Update Password --}}
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="text-base font-semibold text-gray-800">Ubah Password</h3>
                                <p class="text-xs text-gray-500">
                                    Gunakan password yang kuat dan unik.
                                </p>
                            </div>
                        </div>

                        @include('profile.partials.update-password-form')
                    </div>

                    {{-- Hapus Akun (kalau partial-nya memang ada) --}}
                    @if (View::exists('profile.partials.delete-user-form'))
                        <div class="bg-white rounded-xl shadow-sm p-6 border border-red-100">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h3 class="text-base font-semibold text-red-600">Hapus Akun</h3>
                                    <p class="text-xs text-red-500">
                                        Tindakan ini permanen. Semua data terkait akun akan dihapus.
                                    </p>
                                </div>
                            </div>

                            @include('profile.partials.delete-user-form')
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

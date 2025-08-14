<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Selamat Datang Kembali!") }}
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-700">Jumlah Pegawai Terdaftar</h3>
                        <p class="mt-2 text-3xl font-bold text-gray-900">
                            {{ $jumlah_pensiunan }} Orang
                        </p>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-700">Total Potongan Realisasi</h3>
                        <p class="mt-2 text-3xl font-bold text-gray-900">
                            Rp {{ number_format($total_potongan_tahunan, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
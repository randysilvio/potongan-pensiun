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
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <div class="card-title h5">Jumlah Pegawai</div>
                                    <p class="card-text h1">{{ $jumlah_pegawai }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <div class="card-title h5">Total Potongan Tahun Ini</div>
                                    <p class="card-text h1">Rp {{ number_format($total_potongan_tahunan, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
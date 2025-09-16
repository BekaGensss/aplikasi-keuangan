@extends('layouts.main')

@section('title', 'Edit Pengeluaran')

@section('content')
    <div class="space-y-8 p-4 md:p-8">
        <div class="text-center">
            <h1 class="text-3xl font-bold tracking-tight text-gray-800 sm:text-4xl">
                Edit Data Pengeluaran
            </h1>
            <p class="mt-2 text-lg text-gray-500">
                Ubah informasi pengeluaran yang sudah ada.
            </p>
        </div>

        <div class="rounded-2xl bg-white p-6 shadow-xl transition-all duration-300 hover:shadow-2xl">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Ubah Data Pengeluaran</h2>
            <form action="/pengeluaran/{{ $pengeluaran->id }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <input type="text" name="deskripsi" id="deskripsi" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm" value="{{ $pengeluaran->deskripsi }}" required>
                    </div>

                    <div>
                        <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
                        <select name="kategori_id" id="kategori" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm" required>
                            @foreach ($kategori as $item)
                                <option value="{{ $item->id }}" {{ $item->id == $pengeluaran->kategori_id ? 'selected' : '' }}>
                                    {{ $item->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="jumlah" class="block text-sm font-medium text-gray-700">Jumlah (Rp)</label>
                        <input type="number" name="jumlah" id="jumlah" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm" value="{{ $pengeluaran->jumlah }}" required min="0" step="any">
                    </div>

                    <div>
                        <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm" value="{{ $pengeluaran->tanggal }}" required>
                    </div>
                </div>

                <div class="mt-8 flex justify-end space-x-4">
                    <button type="submit" class="inline-flex items-center justify-center rounded-lg border border-transparent bg-gradient-to-r from-red-600 to-rose-600 px-6 py-3 text-base font-medium text-white shadow-sm transition-transform duration-300 hover:scale-105 hover:from-red-700 hover:to-rose-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                        Simpan Perubahan
                    </button>
                    <a href="/pengeluaran" class="inline-flex items-center justify-center rounded-lg border border-transparent bg-gray-400 px-6 py-3 text-base font-medium text-white shadow-sm transition-transform duration-300 hover:scale-105 hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
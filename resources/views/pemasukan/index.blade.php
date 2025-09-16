@extends('layouts.main')

@section('title', 'Daftar Pemasukan')

@section('content')
    <div class="space-y-8 p-4 md:p-8">
        <div class="text-center">
            <h1 class="text-3xl font-bold tracking-tight text-gray-800 sm:text-4xl">
                Catat Pemasukan Anda
            </h1>
            <p class="mt-2 text-lg text-gray-500">
                Lacak setiap pemasukan untuk mengelola keuangan pribadi dengan lebih baik.
            </p>
        </div>

        @if (session('success'))
            <div class="rounded-lg bg-green-50 p-4 shadow-sm" role="alert">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-green-800">{{ session('success') }}</h3>
                    </div>
                </div>
            </div>
        @endif

        <div class="rounded-2xl bg-white p-6 shadow-xl transition-all duration-300 hover:shadow-2xl">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Tambah Pemasukan Baru</h2>
            <form action="/pemasukan/tambah" method="POST">
                @csrf
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <input type="text" name="deskripsi" id="deskripsi" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Contoh: Gaji bulanan" required>
                    </div>

                    <div>
                        <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
                        <select name="kategori_id" id="kategori" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required>
                            @foreach ($kategori as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="jumlah" class="block text-sm font-medium text-gray-700">Jumlah (Rp)</label>
                        <input type="number" name="jumlah" id="jumlah" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Contoh: 500.000" required min="0" step="any">
                    </div>

                    <div>
                        <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required>
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <button type="submit" class="inline-flex items-center justify-center rounded-lg border border-transparent bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-3 text-base font-medium text-white shadow-sm transition-transform duration-300 hover:scale-105 hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Simpan Pemasukan
                    </button>
                </div>
            </form>
        </div>

        <div class="rounded-2xl bg-white p-6 shadow-xl transition-all duration-300 hover:shadow-2xl">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Riwayat Pemasukan</h2>
            <div class="overflow-x-auto rounded-xl border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Tanggal</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Kategori</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Deskripsi</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Jumlah</th>
                            <th scope="col" class="relative px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @foreach ($pemasukan as $item)
                            <tr class="transition-all duration-200 hover:bg-gray-50">
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">{{ $item->tanggal }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">
                                    <span class="inline-flex rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-800">{{ $item->kategori->nama_kategori }}</span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">{{ $item->deskripsi }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-semibold text-green-600">Rp{{ number_format($item->jumlah, 0, ',', '.') }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="/pemasukan/{{ $item->id }}/edit" class="rounded-md bg-yellow-500 px-3 py-1 text-xs text-white transition-colors duration-200 hover:bg-yellow-600">Edit</a>
                                        <form action="/pemasukan/{{ $item->id }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-md bg-red-500 px-3 py-1 text-xs text-white transition-colors duration-200 hover:bg-red-600">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
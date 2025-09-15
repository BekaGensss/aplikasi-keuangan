@extends('layouts.main')
@section('title', 'Daftar Pengeluaran')
@section('content')
    <h1 class="text-2xl font-bold mb-4">Daftar Pengeluaran</h1>
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if (session('warning'))
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('warning') }}</span>
        </div>
    @endif
    <div class="bg-white p-6 rounded-lg shadow mb-8">
        <h2 class="text-xl font-bold mb-4">Tambah Pengeluaran Baru</h2>
        <form action="/pengeluaran/tambah" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div><label for="deskripsi" class="block text-gray-700 font-semibold mb-2">Deskripsi</label><input type="text" name="deskripsi" id="deskripsi" class="w-full p-2 border border-gray-300 rounded-md" required></div>
                <div><label for="kategori" class="block text-gray-700 font-semibold mb-2">Kategori</label><select name="kategori_id" id="kategori" class="w-full p-2 border border-gray-300 rounded-md" required>@foreach ($kategori as $item)<option value="{{ $item->id }}">{{ $item->nama_kategori }}</option>@endforeach</select></div>
                <div><label for="jumlah" class="block text-gray-700 font-semibold mb-2">Jumlah</label><input type="number" name="jumlah" id="jumlah" class="w-full p-2 border border-gray-300 rounded-md" required step="any"></div>
                <div><label for="tanggal" class="block text-gray-700 font-semibold mb-2">Tanggal</label><input type="date" name="tanggal" id="tanggal" class="w-full p-2 border border-gray-300 rounded-md" required></div>
            </div>
            <div class="mt-4"><button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Simpan Pengeluaran</button></div>
        </form>
    </div>
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">Riwayat Pengeluaran</h2>
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b border-gray-200 text-left text-sm font-semibold text-gray-600">Tanggal</th>
                    <th class="py-2 px-4 border-b border-gray-200 text-left text-sm font-semibold text-gray-600">Kategori</th>
                    <th class="py-2 px-4 border-b border-gray-200 text-left text-sm font-semibold text-gray-600">Deskripsi</th>
                    <th class="py-2 px-4 border-b border-gray-200 text-left text-sm font-semibold text-gray-600">Jumlah</th>
                    <th class="py-2 px-4 border-b border-gray-200 text-left text-sm font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pengeluaran as $item)
                    <tr>
                        <td class="py-2 px-4 border-b border-gray-200">{{ $item->tanggal }}</td>
                        <td class="py-2 px-4 border-b border-gray-200">{{ $item->kategori->nama_kategori }}</td>
                        <td class="py-2 px-4 border-b border-gray-200">{{ $item->deskripsi }}</td>
                        <td class="py-2 px-4 border-b border-gray-200">Rp{{ number_format($item->jumlah, 0, ',', '.') }}</td>
                        <td class="py-2 px-4 border-b border-gray-200 flex space-x-2">
                            <a href="/pengeluaran/{{ $item->id }}/edit" class="bg-yellow-500 text-white px-3 py-1 text-xs rounded-md">Edit</a>
                            <form action="/pengeluaran/{{ $item->id }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-3 py-1 text-xs rounded-md">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
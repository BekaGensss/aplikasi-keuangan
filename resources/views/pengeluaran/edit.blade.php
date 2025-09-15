@extends('layouts.main')
@section('title', 'Edit Pengeluaran')
@section('content')
    <h1 class="text-2xl font-bold mb-4">Edit Pengeluaran</h1>
    <div class="bg-white p-6 rounded-lg shadow mb-8">
        <h2 class="text-xl font-bold mb-4">Ubah Data Pengeluaran</h2>
        <form action="/pengeluaran/{{ $pengeluaran->id }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div><label for="deskripsi" class="block text-gray-700 font-semibold mb-2">Deskripsi</label><input type="text" name="deskripsi" id="deskripsi" class="w-full p-2 border border-gray-300 rounded-md" value="{{ $pengeluaran->deskripsi }}" required></div>
                <div><label for="kategori" class="block text-gray-700 font-semibold mb-2">Kategori</label><select name="kategori_id" id="kategori" class="w-full p-2 border border-gray-300 rounded-md" required>@foreach ($kategori as $item)<option value="{{ $item->id }}" {{ $item->id == $pengeluaran->kategori_id ? 'selected' : '' }}>{{ $item->nama_kategori }}</option>@endforeach</select></div>
                <div><label for="jumlah" class="block text-gray-700 font-semibold mb-2">Jumlah</label><input type="number" name="jumlah" id="jumlah" class="w-full p-2 border border-gray-300 rounded-md" value="{{ $pengeluaran->jumlah }}" required min="0" step="any"></div>
                <div><label for="tanggal" class="block text-gray-700 font-semibold mb-2">Tanggal</label><input type="date" name="tanggal" id="tanggal" class="w-full p-2 border border-gray-300 rounded-md" value="{{ $pengeluaran->tanggal }}" required></div>
            </div>
            <div class="mt-4 flex space-x-2"><button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">Simpan Perubahan</button><a href="/pengeluaran" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">Batal</a></div>
        </form>
    </div>
@endsection
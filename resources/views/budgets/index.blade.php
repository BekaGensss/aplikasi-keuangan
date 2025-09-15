@extends('layouts.main')
@section('title', 'Manajemen Anggaran')
@section('content')
    <h1 class="text-2xl font-bold mb-4">Manajemen Anggaran</h1>
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    <div class="bg-white p-6 rounded-lg shadow mb-8">
        <h2 class="text-xl font-bold mb-4">Atur Anggaran Baru</h2>
        <form action="{{ route('budgets.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="kategori_id" class="block text-gray-700 font-semibold mb-2">Kategori</label>
                    <select name="kategori_id" id="kategori_id" class="w-full p-2 border border-gray-300 rounded-md" required>
                        @foreach ($kategori as $item)
                            <option value="{{ $item->id }}">{{ $item->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="amount" class="block text-gray-700 font-semibold mb-2">Jumlah Anggaran</label>
                    <input type="number" name="amount" id="amount" class="w-full p-2 border border-gray-300 rounded-md" required min="0">
                </div>
                <div>
                    <label for="month" class="block text-gray-700 font-semibold mb-2">Bulan</label>
                    <input type="number" name="month" id="month" class="w-full p-2 border border-gray-300 rounded-md" required min="1" max="12" value="{{ now()->month }}">
                </div>
                <div>
                    <label for="year" class="block text-gray-700 font-semibold mb-2">Tahun</label>
                    <input type="number" name="year" id="year" class="w-full p-2 border border-gray-300 rounded-md" required min="2000" value="{{ now()->year }}">
                </div>
            </div>
            <div class="mt-4"><button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Simpan Anggaran</button></div>
        </form>
    </div>
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">Daftar Anggaran</h2>
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b border-gray-200 text-left text-sm font-semibold text-gray-600">Kategori</th>
                    <th class="py-2 px-4 border-b border-gray-200 text-left text-sm font-semibold text-gray-600">Jumlah Anggaran</th>
                    <th class="py-2 px-4 border-b border-gray-200 text-left text-sm font-semibold text-gray-600">Bulan & Tahun</th>
                    <th class="py-2 px-4 border-b border-gray-200 text-left text-sm font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($budgets as $budget)
                    <tr>
                        <td class="py-2 px-4 border-b border-gray-200">{{ $budget->kategori->nama_kategori }}</td>
                        <td class="py-2 px-4 border-b border-gray-200">Rp{{ number_format($budget->amount, 0, ',', '.') }}</td>
                        <td class="py-2 px-4 border-b border-gray-200">{{ \Carbon\Carbon::create($budget->year, $budget->month)->translatedFormat('F Y') }}</td>
                        <td class="py-2 px-4 border-b border-gray-200">
                            <form action="{{ route('budgets.destroy', $budget) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus anggaran ini?')">
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
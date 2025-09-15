@extends('layouts.main')

@section('title', 'Atur Saldo Awal')

@section('content')
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="w-full max-w-md p-8 space-y-6 bg-white rounded-lg shadow-md">
            <h2 class="text-2xl font-bold text-center">Atur Saldo Awal Anda</h2>
            <p class="text-center text-gray-600">Anda harus mengatur saldo awal sebelum bisa menggunakan aplikasi.</p>

            <form action="/saldo-awal/simpan" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="initial_balance" class="block text-sm font-medium text-gray-700">Saldo Awal (Rp)</label>
                        <input type="number" name="initial_balance" id="initial_balance" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required min="0">
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Simpan Saldo Awal
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
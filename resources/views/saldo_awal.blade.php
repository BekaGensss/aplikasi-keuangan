@extends('layouts.main')

@section('title', 'Atur Saldo Awal')

@section('content')
    <div class="flex min-h-screen items-center justify-center p-4 md:p-8">
        <div class="w-full max-w-lg rounded-2xl bg-white p-6 shadow-xl transition-all duration-300 hover:shadow-2xl sm:p-8">
            <div class="space-y-4 text-center">
                <h2 class="text-3xl font-bold tracking-tight text-gray-800">
                    Atur Saldo Awal Anda
                </h2>
                <p class="text-lg text-gray-500">
                    Anda perlu menentukan saldo awal sebelum dapat memulai pencatatan keuangan.
                </p>
            </div>

            <form action="/saldo-awal/simpan" method="POST" class="mt-8">
                @csrf
                <div class="space-y-6">
                    <div>
                        <label for="initial_balance" class="block text-sm font-medium text-gray-700">Jumlah Saldo Awal (Rp)</label>
                        <input type="number" name="initial_balance" id="initial_balance" placeholder="Contoh: 1.500.000" class="mt-1 block w-full rounded-lg border-gray-300 px-4 py-2 shadow-sm transition-colors duration-200 focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required min="0">
                    </div>
                </div>

                <div class="mt-8">
                    <button type="submit" class="inline-flex w-full items-center justify-center rounded-lg border border-transparent bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-3 text-base font-medium text-white shadow-sm transition-transform duration-300 hover:scale-105 hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Simpan Saldo Awal
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
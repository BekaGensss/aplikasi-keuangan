@extends('layouts.main')

@section('title', 'Profil')

@section('content')
    <div class="space-y-8 p-4 md:p-8">
        <div class="text-center">
            <h1 class="text-3xl font-bold tracking-tight text-gray-800 sm:text-4xl">
                Profil Pengguna
            </h1>
            <p class="mt-2 text-lg text-gray-500">
                Kelola informasi akun Anda dan lihat ringkasan keuangan.
            </p>
        </div>

        <div class="rounded-2xl bg-white p-6 shadow-xl transition-all duration-300 hover:shadow-2xl">
            <div class="max-w-3xl mx-auto">
                <section>
                    <header>
                        <h2 class="text-2xl font-semibold text-gray-800 mb-2">
                            Ringkasan Keuangan Anda
                        </h2>
                        <p class="mt-1 text-sm text-gray-500">
                            Berikut adalah ringkasan keuangan total dari seluruh riwayat Anda.
                        </p>
                    </header>
                    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="flex flex-col items-center justify-center p-6 rounded-lg border border-gray-200">
                            <span class="text-lg font-medium text-gray-500">Saldo Total</span>
                            <span class="text-3xl font-bold mt-2 @if($keuangan['saldo_total'] >= 0) text-blue-600 @else text-red-600 @endif">
                                Rp{{ number_format($keuangan['saldo_total'], 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="flex flex-col items-center justify-center p-6 rounded-lg border border-gray-200">
                            <span class="text-lg font-medium text-gray-500">Total Pemasukan</span>
                            <span class="text-3xl font-bold mt-2 text-green-600">
                                Rp{{ number_format($keuangan['total_pemasukan'], 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="flex flex-col items-center justify-center p-6 rounded-lg border border-gray-200">
                            <span class="text-lg font-medium text-gray-500">Total Pengeluaran</span>
                            <span class="text-3xl font-bold mt-2 text-red-600">
                                Rp{{ number_format($keuangan['total_pengeluaran'], 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        
        <div class="rounded-2xl bg-white p-6 shadow-xl transition-all duration-300 hover:shadow-2xl">
            <div class="max-w-3xl mx-auto">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="rounded-2xl bg-white p-6 shadow-xl transition-all duration-300 hover:shadow-2xl">
            <div class="max-w-3xl mx-auto">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="rounded-2xl bg-white p-6 shadow-xl transition-all duration-300 hover:shadow-2xl">
            <div class="max-w-3xl mx-auto">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
@endsection
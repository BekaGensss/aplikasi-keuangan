@extends('layouts.main')

@section('title', 'Profil')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Profil Pengguna</h1>

    <div class="space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Ringkasan Keuangan Anda') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ __("Berikut adalah ringkasan keuangan total dari seluruh riwayat Anda.") }}
                        </p>
                    </header>
                    <div class="mt-6 space-y-4">
                        <div class="flex justify-between items-center bg-gray-100 p-4 rounded-lg">
                            <span class="font-bold text-gray-700">Saldo Total</span>
                            <span class="text-xl font-bold @if($keuangan['saldo_total'] >= 0) text-blue-600 @else text-red-600 @endif">
                                Rp{{ number_format($keuangan['saldo_total'], 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center bg-gray-100 p-4 rounded-lg">
                            <span class="font-bold text-gray-700">Total Pemasukan</span>
                            <span class="text-xl font-bold text-green-600">
                                Rp{{ number_format($keuangan['total_pemasukan'], 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center bg-gray-100 p-4 rounded-lg">
                            <span class="font-bold text-gray-700">Total Pengeluaran</span>
                            <span class="text-xl font-bold text-red-600">
                                Rp{{ number_format($keuangan['total_pengeluaran'], 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
@endsection
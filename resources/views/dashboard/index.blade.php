@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')
    <div class="space-y-8 p-4 md:p-8">
        <div class="text-center">
            <h1 class="text-3xl font-bold tracking-tight text-gray-800 sm:text-4xl">
                Dashboard Keuangan
            </h1>
            <p class="mt-2 text-lg text-gray-500">
                Ringkasan dan analisis data keuangan Anda.
            </p>
        </div>

        @if (is_null($uang_awal))
            <div class="rounded-lg bg-yellow-50 p-4 shadow-sm" role="alert">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M8.257 3.51a1.25 1.25 0 011.5-.008L14.475 7.75A1.25 1.25 0 0114.5 9.429L10.25 18.15a1.25 1.25 0 01-2.008.008L3.525 9.429A1.25 1.25 0 013.5 7.75L8.257 3.51zM10 11.25a.75.75 0 00-1.5 0v3a.75.75 0 001.5 0v-3z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-800">Perhatian!</h3>
                        <p class="mt-1 text-sm text-yellow-700">Saldo awal Anda belum diatur. Silakan <a href="/saldo-awal" class="font-medium underline hover:text-yellow-800">atur saldo awal</a> untuk melihat data keuangan yang akurat.</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="rounded-2xl bg-white p-6 shadow-xl transition-all duration-300 hover:shadow-2xl">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Filter Data</h2>
            <form action="{{ route('dashboard') }}" method="GET" class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 items-center">
                <div>
                    <label for="month" class="sr-only">Bulan</label>
                    <select name="month" id="month" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        @foreach($availableMonths as $key => $monthName)
                            <option value="{{ $key + 1 }}" {{ ($key + 1) == $currentMonth ? 'selected' : '' }}>{{ $monthName }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="year" class="sr-only">Tahun</label>
                    <select name="year" id="year" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        @foreach($availableYears as $year)
                            <option value="{{ $year }}" {{ $year == $currentYear ? 'selected' : '' }}>{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <button type="submit" class="w-full inline-flex items-center justify-center rounded-lg border border-transparent bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-2 text-base font-medium text-white shadow-sm transition-transform duration-300 hover:scale-105 hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Terapkan
                    </button>
                </div>
            </form>
        </div>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-4">
            <div class="rounded-2xl bg-white p-6 shadow-xl text-center transition-all duration-300 hover:shadow-2xl">
                <h2 class="text-lg font-medium text-gray-500">Saldo Total</h2>
                <p class="text-4xl font-extrabold mt-2 tracking-tight @if($saldo_total >= 0) text-blue-600 @else text-red-600 @endif">
                    Rp{{ number_format($saldo_total, 0, ',', '.') }}
                </p>
            </div>
            <div class="rounded-2xl bg-white p-6 shadow-xl text-center transition-all duration-300 hover:shadow-2xl">
                <h2 class="text-lg font-medium text-gray-500">Pemasukan Bulan Ini</h2>
                <p class="text-4xl font-extrabold text-green-600 mt-2 tracking-tight">
                    Rp{{ number_format($pemasukan_bulan_ini, 0, ',', '.') }}
                </p>
            </div>
            <div class="rounded-2xl bg-white p-6 shadow-xl text-center transition-all duration-300 hover:shadow-2xl">
                <h2 class="text-lg font-medium text-gray-500">Pengeluaran Bulan Ini</h2>
                <p class="text-4xl font-extrabold text-red-600 mt-2 tracking-tight">
                    Rp{{ number_format($pengeluaran_bulan_ini, 0, ',', '.') }}
                </p>
            </div>
            <div class="rounded-2xl bg-white p-6 shadow-xl text-center transition-all duration-300 hover:shadow-2xl">
                <h2 class="text-lg font-medium text-gray-500">Saldo Bulan Ini</h2>
                <p class="text-4xl font-extrabold mt-2 tracking-tight @if($saldo_bulan_ini >= 0) text-blue-600 @else text-red-600 @endif">
                    Rp{{ number_format($saldo_bulan_ini, 0, ',', '.') }}
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div class="rounded-2xl bg-white p-6 shadow-xl">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Pengeluaran per Kategori ({{ \Carbon\Carbon::create($currentYear, $currentMonth)->translatedFormat('F Y') }})</h2>
                <div class="w-full h-80 flex items-center justify-center">
                    @if(empty($data_pie))
                        <p class="text-gray-500 italic">Tidak ada data pengeluaran untuk bulan ini.</p>
                    @else
                        <canvas id="pengeluaranChart"></canvas>
                    @endif
                </div>
            </div>
            <div class="rounded-2xl bg-white p-6 shadow-xl">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Aliran Kas 6 Bulan Terakhir</h2>
                <div class="w-full h-80">
                    <canvas id="aliranKasChart"></canvas>
                </div>
            </div>
        </div>

        <div class="mt-8 flex flex-col md:flex-row md:justify-end md:space-x-4 space-y-4 md:space-y-0">
            <a href="{{ route('budgets.index') }}" class="inline-flex items-center justify-center rounded-lg border border-transparent bg-gradient-to-r from-blue-600 to-purple-600 px-8 py-3 text-base font-semibold text-white shadow-sm transition-transform duration-300 hover:scale-105 hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Kelola Anggaran
            </a>
            <a href="{{ route('export.transactions') }}" class="inline-flex items-center justify-center rounded-lg border border-transparent bg-gradient-to-r from-green-500 to-teal-500 px-8 py-3 text-base font-semibold text-white shadow-sm transition-transform duration-300 hover:scale-105 hover:from-green-600 hover:to-teal-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                Ekspor ke CSV
            </a>
        </div>
    </div>

    <script>
        const pengeluaranData = @json($data_pie);
        const pengeluaranLabels = @json($labels_pie);
        const bulanLabels = @json($bulan_array);
        const pemasukanBulananData = @json($pemasukan_per_bulan);
        const pengeluaranBulananData = @json($pengeluaran_per_bulan);

        if (pengeluaranData.length > 0) {
            const ctxPengeluaran = document.getElementById('pengeluaranChart').getContext('2d');
            new Chart(ctxPengeluaran, {
                type: 'pie',
                data: {
                    labels: pengeluaranLabels,
                    datasets: [{
                        label: 'Total Pengeluaran',
                        data: pengeluaranData,
                        backgroundColor: ['#e57373', '#81c784', '#64b5f6', '#ffb74d', '#ba68c8', '#4dd0e1', '#a1887f', '#90a4ae'],
                        hoverOffset: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'top' },
                        tooltip: {
                            callbacks: {
                                label: (tooltipItem) => {
                                    const value = tooltipItem.raw;
                                    const formattedValue = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(value);
                                    return `${tooltipItem.label}: ${formattedValue}`;
                                }
                            }
                        }
                    }
                }
            });
        }

        const ctxAliranKas = document.getElementById('aliranKasChart').getContext('2d');
        new Chart(ctxAliranKas, {
            type: 'bar',
            data: {
                labels: bulanLabels,
                datasets: [{
                    label: 'Pemasukan',
                    data: pemasukanBulananData,
                    backgroundColor: '#4BC0C0', // Hijau-teal
                    borderRadius: 5
                }, {
                    label: 'Pengeluaran',
                    data: pengeluaranBulananData,
                    backgroundColor: '#FF6384', // Merah-pink
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        stacked: false,
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        stacked: false,
                        beginAtZero: true,
                        ticks: {
                            callback: (value) => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(value)
                        },
                        grid: {
                            color: '#e2e8f0'
                        }
                    }
                },
                plugins: {
                    legend: { position: 'top' },
                    tooltip: {
                        callbacks: {
                            label: (context) => {
                                const value = context.parsed.y;
                                const formattedValue = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(value);
                                return `${context.dataset.label}: ${formattedValue}`;
                            }
                        }
                    }
                }
            }
        });
    </script>
@endsection
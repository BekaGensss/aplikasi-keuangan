@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Dashboard Keuangan</h1>
    
    @if (is_null($uang_awal))
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-8" role="alert">
            <p class="font-bold">Perhatian!</p>
            <p>Saldo awal Anda belum diatur. Silakan <a href="/saldo-awal" class="underline hover:text-yellow-800">atur saldo awal</a> untuk melihat data keuangan yang akurat.</p>
        </div>
    @endif

    <div class="bg-white p-6 rounded-lg shadow mb-8">
        <h2 class="text-xl font-bold mb-4">Filter Bulan & Tahun</h2>
        <form action="{{ route('dashboard') }}" method="GET" class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-4">
            <div>
                <label for="month" class="sr-only">Bulan</label>
                <select name="month" id="month" class="w-full p-2 border border-gray-300 rounded-md">
                    @foreach($availableMonths as $key => $monthName)
                        <option value="{{ $key + 1 }}" {{ $key + 1 == $currentMonth ? 'selected' : '' }}>{{ $monthName }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="year" class="sr-only">Tahun</label>
                <select name="year" id="year" class="w-full p-2 border border-gray-300 rounded-md">
                    @foreach($availableYears as $year)
                        <option value="{{ $year }}" {{ $year == $currentYear ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <button type="submit" class="w-full md:w-auto bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Terapkan</button>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white p-6 rounded-lg shadow text-center">
            <h2 class="text-lg font-semibold text-gray-600">Saldo Total</h2>
            <p class="text-3xl font-bold mt-2 @if($saldo_total >= 0) text-blue-500 @else text-red-500 @endif">Rp{{ number_format($saldo_total, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow text-center">
            <h2 class="text-lg font-semibold text-gray-600">Pemasukan Bulan Ini</h2>
            <p class="text-3xl font-bold text-green-500 mt-2">Rp{{ number_format($pemasukan_bulan_ini, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow text-center">
            <h2 class="text-lg font-semibold text-gray-600">Pengeluaran Bulan Ini</h2>
            <p class="text-3xl font-bold text-red-500 mt-2">Rp{{ number_format($pengeluaran_bulan_ini, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow text-center">
            <h2 class="text-lg font-semibold text-gray-600">Saldo Bulan Ini</h2>
            <p class="text-3xl font-bold mt-2 @if($saldo_bulan_ini >= 0) text-blue-500 @else text-red-500 @endif">Rp{{ number_format($saldo_bulan_ini, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-bold mb-4">Pengeluaran per Kategori ({{ \Carbon\Carbon::create($currentYear, $currentMonth)->translatedFormat('F Y') }})</h2>
            <div class="w-full h-80 flex items-center justify-center">
                {{-- Perbaikan: Cek variabel $data_pie, bukan $data --}}
                @if(empty($data_pie))
                    <p class="text-gray-500">Tidak ada data pengeluaran untuk bulan ini.</p>
                @else
                    <canvas id="pengeluaranChart"></canvas>
                @endif
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-bold mb-4">Aliran Kas 6 Bulan Terakhir</h2>
            <div class="w-full h-80">
                <canvas id="aliranKasChart"></canvas>
            </div>
        </div>
    </div>

    <div class="mt-8 flex justify-between items-center">
        <a href="{{ route('export.transactions') }}" class="bg-green-600 text-white px-6 py-3 rounded-md hover:bg-green-700 font-semibold">Ekspor ke CSV</a>
        <a href="{{ route('budgets.index') }}" class="bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 font-semibold">Kelola Anggaran</a>
    </div>

    <script>
        {{-- Perbaikan: Gunakan nama variabel yang sudah diperbarui --}}
        const pengeluaranData = @json($data_pie);
        const pengeluaranLabels = @json($labels_pie);
        const bulanLabels = @json($bulan_array);
        const pemasukanBulananData = @json($pemasukan_per_bulan);
        const pengeluaranBulananData = @json($pengeluaran_per_bulan);

        {{-- Perbaikan: Cek variabel $pengeluaranData --}}
        if (pengeluaranData.length > 0) {
            const ctxPengeluaran = document.getElementById('pengeluaranChart').getContext('2d');
            new Chart(ctxPengeluaran, {
                type: 'pie',
                data: {
                    labels: pengeluaranLabels,
                    datasets: [{
                        label: 'Total Pengeluaran',
                        data: pengeluaranData,
                        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'],
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'top' },
                        tooltip: { callbacks: { label: (tooltipItem) => `${tooltipItem.label}: Rp${tooltipItem.raw.toLocaleString('id-ID')}` } }
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
                    backgroundColor: '#4BC0C0'
                }, {
                    label: 'Pengeluaran',
                    data: pengeluaranBulananData,
                    backgroundColor: '#FF6384'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: { stacked: false },
                    y: {
                        stacked: false,
                        beginAtZero: true,
                        ticks: { callback: (value) => `Rp${value.toLocaleString('id-ID')}` }
                    }
                },
                plugins: {
                    legend: { position: 'top' },
                    tooltip: {
                        callbacks: {
                            label: (context) => `${context.dataset.label}: Rp${context.parsed.y.toLocaleString('id-ID')}`
                        }
                    }
                }
            }
        });
    </script>
@endsection
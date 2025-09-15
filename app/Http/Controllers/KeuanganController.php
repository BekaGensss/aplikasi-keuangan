<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use App\Models\Setting;
use App\Models\Budget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class KeuanganController extends Controller
{
    public function dashboard($month = null, $year = null)
    {
        $currentMonth = $month ? (int) $month : now()->month;
        $currentYear = $year ? (int) $year : now()->year;

        $setting = Setting::where('user_id', Auth::id())->first();
        $uang_awal = $setting ? $setting->initial_balance : 0;
        
        $total_pemasukan_keseluruhan = Pemasukan::where('user_id', Auth::id())->where('tanggal', '<=', Carbon::create($currentYear, $currentMonth)->endOfMonth())->sum('jumlah');
        $total_pengeluaran_keseluruhan = Pengeluaran::where('user_id', Auth::id())->where('tanggal', '<=', Carbon::create($currentYear, $currentMonth)->endOfMonth())->sum('jumlah');
        $saldo_total = $uang_awal + $total_pemasukan_keseluruhan - $total_pengeluaran_keseluruhan;
        
        $pemasukan_bulan_ini = Pemasukan::where('user_id', Auth::id())->whereMonth('tanggal', $currentMonth)->whereYear('tanggal', $currentYear)->sum('jumlah');
        $pengeluaran_bulan_ini = Pengeluaran::where('user_id', Auth::id())->whereMonth('tanggal', $currentMonth)->whereYear('tanggal', $currentYear)->sum('jumlah');
        $saldo_bulan_ini = $pemasukan_bulan_ini - $pengeluaran_bulan_ini;

        // Data untuk Pie Chart (Pengeluaran per Kategori)
        $pengeluaran_per_kategori = Pengeluaran::where('user_id', Auth::id())
            ->whereMonth('tanggal', $currentMonth)
            ->whereYear('tanggal', $currentYear)
            ->select('kategori_id', DB::raw('sum(jumlah) as total_jumlah'))
            ->groupBy('kategori_id')
            ->with('kategori')
            ->get();
        
        $labels_pie = $pengeluaran_per_kategori->pluck('kategori.nama_kategori')->toArray();
        $data_pie = $pengeluaran_per_kategori->pluck('total_jumlah')->toArray();

        // Jika tidak ada data pengeluaran, siapkan data dummy untuk chart agar tidak error
        if (empty($labels_pie)) {
            $labels_pie = ['Tidak ada data'];
            $data_pie = [1];
        }

        // Data untuk Bar/Line Chart (Tren Pemasukan & Pengeluaran 6 Bulan Terakhir)
        $bulan_array = [];
        $pemasukan_per_bulan = [];
        $pengeluaran_per_bulan = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::create($currentYear, $currentMonth)->subMonths($i);
            $bulan_array[] = $date->translatedFormat('M Y');
            
            $pemasukan_per_bulan[] = Pemasukan::where('user_id', Auth::id())->whereMonth('tanggal', $date->month)->whereYear('tanggal', $date->year)->sum('jumlah');
            $pengeluaran_per_bulan[] = Pengeluaran::where('user_id', Auth::id())->whereMonth('tanggal', $date->month)->whereYear('tanggal', $date->year)->sum('jumlah');
        }

        $availableMonths = [];
        for ($i = 1; $i <= 12; $i++) {
            $availableMonths[] = Carbon::create(null, $i, 1)->translatedFormat('F');
        }

        $availableYears = range(2020, date('Y') + 5);

        return view('dashboard.index', compact(
            'pemasukan_bulan_ini', 
            'pengeluaran_bulan_ini', 
            'saldo_bulan_ini', 
            'labels_pie', 
            'data_pie',   
            'uang_awal', 
            'total_pemasukan_keseluruhan', 
            'total_pengeluaran_keseluruhan', 
            'saldo_total',
            'bulan_array',
            'pemasukan_per_bulan', 
            'pengeluaran_per_bulan',
            'currentMonth', 
            'currentYear', 
            'availableMonths', 
            'availableYears'
        ));
    }
    
    public function exportTransactions(): StreamedResponse // Perbaikan: Tipe return value
    {
        $headers = [
            'Content-type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename=riwayat_transaksi.csv',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0'
        ];

        $pemasukan = Pemasukan::where('user_id', Auth::id())->with('kategori')->get();
        $pengeluaran = Pengeluaran::where('user_id', Auth::id())->with('kategori')->get();

        $transactions = collect($pemasukan)->map(function ($item) {
            return [
                'tanggal' => $item->tanggal,
                'jenis' => 'Pemasukan',
                'kategori' => $item->kategori->nama_kategori,
                'deskripsi' => $item->deskripsi,
                'jumlah' => $item->jumlah,
            ];
        })->merge(collect($pengeluaran)->map(function ($item) {
            return [
                'tanggal' => $item->tanggal,
                'jenis' => 'Pengeluaran',
                'kategori' => $item->kategori->nama_kategori,
                'deskripsi' => $item->deskripsi,
                'jumlah' => $item->jumlah,
            ];
        }))->sortBy('tanggal');

        $callback = function() use ($transactions)
        {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Tanggal', 'Jenis', 'Kategori', 'Deskripsi', 'Jumlah']);

            foreach ($transactions as $transaction) {
                fputcsv($file, [
                    $transaction['tanggal'],
                    $transaction['jenis'],
                    $transaction['kategori'],
                    $transaction['deskripsi'],
                    $transaction['jumlah'],
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
    
    public function tampilkanSaldoAwalForm()
    {
        return view('saldo_awal');
    }

    public function simpanSaldoAwal(Request $request)
    {
        $validated = $request->validate([
            'initial_balance' => 'required|numeric',
        ]);
        Setting::updateOrCreate(
            ['user_id' => Auth::id()], 
            ['initial_balance' => $validated['initial_balance']]
        );
        return redirect('/')->with('success', 'Saldo awal berhasil disimpan!');
    }
    
    public function tampilkanPemasukan()
    {
        $pemasukan = Pemasukan::where('user_id', Auth::id())->with('kategori')->latest()->get();
        $kategori = Kategori::where('user_id', Auth::id())->orWhereNull('user_id')->get();
        return view('pemasukan.index', compact('pemasukan', 'kategori'));
    }

    public function tambahPemasukan(Request $request)
    {
        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategori,id',
            'deskripsi' => 'required|string|max:255',
            'jumlah' => 'required|numeric',
            'tanggal' => 'required|date',
        ]);
        $pemasukan = new Pemasukan($validated);
        $pemasukan->user_id = Auth::id();
        $pemasukan->save();
        return redirect('/pemasukan')->with('success', 'Data pemasukan berhasil ditambahkan!');
    }

    public function editPemasukan($id)
    {
        $pemasukan = Pemasukan::where('user_id', Auth::id())->findOrFail($id);
        $kategori = Kategori::where('user_id', Auth::id())->orWhereNull('user_id')->get();
        return view('pemasukan.edit', compact('pemasukan', 'kategori'));
    }

    public function updatePemasukan(Request $request, $id)
    {
        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategori,id',
            'deskripsi' => 'required|string|max:255',
            'jumlah' => 'required|numeric',
            'tanggal' => 'required|date',
        ]);
        $pemasukan = Pemasukan::where('user_id', Auth::id())->findOrFail($id);
        $pemasukan->update($validated);
        return redirect('/pemasukan')->with('success', 'Data pemasukan berhasil diubah!');
    }

    public function hapusPemasukan($id)
    {
        $pemasukan = Pemasukan::where('user_id', Auth::id())->findOrFail($id);
        $pemasukan->delete();
        return redirect('/pemasukan')->with('success', 'Data pemasukan berhasil dihapus!');
    }

    public function tampilkanPengeluaran()
    {
        $pengeluaran = Pengeluaran::where('user_id', Auth::id())->with('kategori')->latest()->get();
        $kategori = Kategori::where('user_id', Auth::id())->orWhereNull('user_id')->get();
        return view('pengeluaran.index', compact('pengeluaran', 'kategori'));
    }

    public function tambahPengeluaran(Request $request)
    {
        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategori,id',
            'deskripsi' => 'required|string|max:255',
            'jumlah' => 'required|numeric',
            'tanggal' => 'required|date',
        ]);
        $pengeluaran = new Pengeluaran($validated);
        $pengeluaran->user_id = Auth::id();
        $pengeluaran->save();

        $tanggal_pengeluaran = Carbon::parse($validated['tanggal']);
        $bulan = $tanggal_pengeluaran->month;
        $tahun = $tanggal_pengeluaran->year;

        $budget = Budget::where('user_id', Auth::id())
                        ->where('kategori_id', $validated['kategori_id'])
                        ->where('month', $bulan)
                        ->where('year', $tahun)
                        ->first();
        
        if ($budget) {
            $total_pengeluaran_kategori = Pengeluaran::where('user_id', Auth::id())
                                                     ->where('kategori_id', $validated['kategori_id'])
                                                     ->whereMonth('tanggal', $bulan)
                                                     ->whereYear('tanggal', $tahun)
                                                     ->sum('jumlah');

            if ($total_pengeluaran_kategori > $budget->amount) {
                return redirect('/pengeluaran')->with('warning', 'Pengeluaran untuk kategori ini telah melebihi batas anggaran!');
            }
        }

        return redirect('/pengeluaran')->with('success', 'Data pengeluaran berhasil ditambahkan!');
    }

    public function editPengeluaran($id)
    {
        $pengeluaran = Pengeluaran::where('user_id', Auth::id())->findOrFail($id);
        $kategori = Kategori::where('user_id', Auth::id())->orWhereNull('user_id')->get();
        return view('pengeluaran.edit', compact('pengeluaran', 'kategori'));
    }

    public function updatePengeluaran(Request $request, $id)
    {
        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategori,id',
            'deskripsi' => 'required|string|max:255',
            'jumlah' => 'required|numeric',
            'tanggal' => 'required|date',
        ]);
        $pengeluaran = Pengeluaran::where('user_id', Auth::id())->findOrFail($id);
        $pengeluaran->update($validated);
        return redirect('/pengeluaran')->with('success', 'Data pengeluaran berhasil diubah!');
    }

    public function hapusPengeluaran($id)
    {
        $pengeluaran = Pengeluaran::where('user_id', Auth::id())->findOrFail($id);
        $pengeluaran->delete();
        return redirect('/pengeluaran')->with('success', 'Data pengeluaran berhasil dihapus!');
    }
}
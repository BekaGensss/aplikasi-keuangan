<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;

// Rute untuk halaman utama (root URL '/')
// Jika pengguna sudah login, arahkan ke dashboard.
// Jika belum, arahkan ke halaman welcome.
Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/dashboard');
    }
    return view('welcome');
});

// Rute untuk Dashboard dengan filter tanggal
Route::get('/dashboard/{month?}/{year?}', [KeuanganController::class, 'dashboard'])->middleware('auth')->name('dashboard');
Route::get('/export/transactions', [KeuanganController::class, 'exportTransactions'])->middleware('auth')->name('export.transactions');

// Rute untuk Mengatur Saldo Awal, dilindungi oleh auth
Route::middleware('auth')->group(function () {
    Route::get('/saldo-awal', [KeuanganController::class, 'tampilkanSaldoAwalForm']);
    Route::post('/saldo-awal/simpan', [KeuanganController::class, 'simpanSaldoAwal']);
});

// Grup rute yang dilindungi middleware 'auth'
Route::middleware('auth')->group(function () {
    // Rute Lengkap untuk Pemasukan (CRUD)
    Route::get('/pemasukan', [KeuanganController::class, 'tampilkanPemasukan']);
    Route::post('/pemasukan/tambah', [KeuanganController::class, 'tambahPemasukan']);
    Route::get('/pemasukan/{id}/edit', [KeuanganController::class, 'editPemasukan']);
    Route::put('/pemasukan/{id}', [KeuanganController::class, 'updatePemasukan']);
    Route::delete('/pemasukan/{id}', [KeuanganController::class, 'hapusPemasukan']);

    // Rute Lengkap untuk Pengeluaran (CRUD)
    Route::get('/pengeluaran', [KeuanganController::class, 'tampilkanPengeluaran']);
    Route::post('/pengeluaran/tambah', [KeuanganController::class, 'tambahPengeluaran']);
    Route::get('/pengeluaran/{id}/edit', [KeuanganController::class, 'editPengeluaran']);
    Route::put('/pengeluaran/{id}', [KeuanganController::class, 'updatePengeluaran']);
    Route::delete('/pengeluaran/{id}', [KeuanganController::class, 'hapusPengeluaran']);

    // Rute untuk Anggaran
    Route::get('/budgets', [BudgetController::class, 'index'])->name('budgets.index');
    Route::post('/budgets', [BudgetController::class, 'store'])->name('budgets.store');
    Route::delete('/budgets/{budget}', [BudgetController::class, 'destroy'])->name('budgets.destroy');
});

// Rute untuk Profil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
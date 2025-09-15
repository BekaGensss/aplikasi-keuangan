<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use App\Models\Setting;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View; // Tambahkan ini

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman edit profil.
     */
    public function edit(Request $request): View
    {
        // Ambil data keuangan untuk ditampilkan di profil
        $setting = Setting::where('user_id', Auth::id())->first();
        $uang_awal = $setting ? $setting->initial_balance : 0;
        
        $total_pemasukan = Pemasukan::where('user_id', Auth::id())->sum('jumlah');
        $total_pengeluaran = Pengeluaran::where('user_id', Auth::id())->sum('jumlah');
        $saldo_total = $uang_awal + $total_pemasukan - $total_pengeluaran;

        $keuangan = [
            'saldo_total' => $saldo_total,
            'total_pemasukan' => $total_pemasukan,
            'total_pengeluaran' => $total_pengeluaran,
        ];

        return view('profile.edit', [
            'user' => $request->user(),
            'keuangan' => $keuangan,
        ]);
    }

    /**
     * Perbarui informasi profil pengguna.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit');
    }

    /**
     * Hapus akun pengguna.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
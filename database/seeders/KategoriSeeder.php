<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Jalankan database seeder.
     */
    public function run(): void
    {
        DB::table('kategori')->insert([
            ['nama_kategori' => 'Gaji', 'tipe' => 'pemasukan'],
            ['nama_kategori' => 'Pendapatan Lain', 'tipe' => 'pemasukan'],
            ['nama_kategori' => 'Makanan', 'tipe' => 'pengeluaran'],
            ['nama_kategori' => 'Transportasi', 'tipe' => 'pengeluaran'],
            ['nama_kategori' => 'Hiburan', 'tipe' => 'pengeluaran'],
            ['nama_kategori' => 'Tagihan', 'tipe' => 'pengeluaran'],
            ['nama_kategori' => 'Belanja', 'tipe' => 'pengeluaran'],
        ]);
    }
}
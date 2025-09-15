<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Kategori;
use App\Models\User;
class BudgetSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        if (!$user) {
            return;
        }

        $makananId = Kategori::where('nama_kategori', 'Makanan')->first()->id;
        $transportasiId = Kategori::where('nama_kategori', 'Transportasi')->first()->id;

        DB::table('budgets')->insert([
            [
                'user_id' => $user->id,
                'kategori_id' => $makananId,
                'amount' => 1000000,
                'month' => now()->month,
                'year' => now()->year,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $user->id,
                'kategori_id' => $transportasiId,
                'amount' => 500000,
                'month' => now()->month,
                'year' => now()->year,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
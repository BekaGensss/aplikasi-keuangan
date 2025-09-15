<?php
namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{
    public function index()
    {
        $budgets = Budget::where('user_id', Auth::id())
                        ->with('kategori')
                        ->orderBy('year', 'desc')
                        ->orderBy('month', 'desc')
                        ->get();
        $kategori = Kategori::where('user_id', Auth::id())
                            ->orWhereNull('user_id')
                            ->where('tipe', 'pengeluaran')
                            ->get();

        return view('budgets.index', compact('budgets', 'kategori'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategori,id',
            'amount' => 'required|numeric|min:0',
            'month' => 'required|numeric|min:1|max:12',
            'year' => 'required|numeric|min:2000',
        ]);

        Budget::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'kategori_id' => $validated['kategori_id'],
                'month' => $validated['month'],
                'year' => $validated['year'],
            ],
            [
                'amount' => $validated['amount']
            ]
        );

        return redirect()->route('budgets.index')->with('success', 'Anggaran berhasil disimpan!');
    }

    public function destroy(Budget $budget)
    {
        if ($budget->user_id !== Auth::id()) {
            abort(403);
        }

        $budget->delete();

        return redirect()->route('budgets.index')->with('success', 'Anggaran berhasil dihapus!');
    }
}
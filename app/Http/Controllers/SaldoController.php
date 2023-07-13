<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Saldo;
use Illuminate\Http\Request;

class SaldoController extends Controller
{
    public function index()
    {
        $saldo = Saldo::all();
        return view('saldo.index', [
            'saldo' => $saldo
        ]);
    }



    public function konfirmasiSaldo($id)
    {
        $saldo = Saldo::findOrFail($id);
        $user = User::findOrFail($saldo->users_id);

        // Update saldo pengguna
        $user->saldo += $saldo->saldo;
        $user->save();

        // Ubah status saldo menjadi "success"
        $saldo->status = 'success';
        $saldo->save();

        // Redirect atau tampilkan pesan sukses
        return redirect()->back()->with('success', 'Saldo berhasil dikonfirmasi.');
    }

    public function tolakSaldo($id)
    {
        $saldo = Saldo::findOrFail($id);

        // Ubah status saldo menjadi "gagal"
        $saldo->status = 'gagal';
        $saldo->save();

        // Redirect atau tampilkan pesan sukses
        return redirect()->back()->with('success', 'Saldo berhasil ditolak.');
    }
}

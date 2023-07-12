<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Saldo;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;


class SaldoApiController extends Controller
{
    public function topup(Request $request)
    {
        $request->validate([
            'saldo' => 'required',
            'image' => 'required',
            'status' => 'required',
        ]);

        // Simpan order
        $order = Saldo::create([
            'users_id' => Auth::user()->id,
            'saldo' => $request->saldo,
            'image' => $request->image,
            'status' => $request->status,
        ]);

        return ResponseFormatter::success($order, 'Transaksi berhasil');
    }

    public function getTopupStatusByUser(Request $request)
    {
        $user_id = $request->user()->id;

        // Cari top-up saldo berdasarkan user ID
        $topup = Saldo::where('users_id', $user_id)->latest()->first();

        if ($topup && $topup->status === 'PENDING') {
            $status = 'PENDING';
        } else {
            $status = 'SUKSES';
        }

        return response()->json([
            'status' => $status
        ]);
    }
}

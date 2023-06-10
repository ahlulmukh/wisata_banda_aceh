<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Support\Facades\Storage;

class ProductApiController extends Controller
{
    public function tickets()
    {
        $tickets = Ticket::with('category')->get();
        try {
            if ($tickets) {
                foreach ($tickets as $item) {
                    $item->image = url(Storage::url($item->image));
                }
                return ResponseFormatter::success($tickets, 'Data semua produk berhasil diambil');
            } else {
                return ResponseFormatter::error('null', 'Tidak ada produk', 404);
            }
        } catch (\Throwable $th) {
            return ResponseFormatter::error($th);
        }
    }

    public function ticket($id)
    {
        $tickets = Ticket::with('category')->find($id);
        if ($tickets) {
            $tickets->image = url(Storage::url($tickets->image));
            return ResponseFormatter::success($tickets, 'Data produk berhasil diambil');
        } else if (empty($tickets)) {
            return ResponseFormatter::error([
                'message' => 'Produk tidak ditemukan',
            ], 'Not Found');
        }
    }

    public function search($name)
    {
        $result = Ticket::where('name', 'LIKE', '%' . $name . '%')->get();
        if (count($result)) {
            foreach ($result as $item) {
                $item->image = url(Storage::url($item->image));
            }
            return ResponseFormatter::success($result, 'Data ditemukan');
        } else {
            return ResponseFormatter::success($result, 'Data tidak ditemukan', 404);
        }
    }

    public function limits()
    {
        $tickets = Ticket::take(6)->with('category')->get();
        try {
            if ($tickets) {
                foreach ($tickets as $item) {
                    $item->image = url(Storage::url($item->image));
                }
                return ResponseFormatter::success(
                    $tickets,
                    'Data list produk berhasil diambil'
                );
            }
        } catch (\Throwable $th) {
            return ResponseFormatter::error($th);
        }
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Models\Cart;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\Product;
use App\Models\OrderItem;
use Barryvdh\DomPDF\Facade;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use function PHPUnit\Framework\isEmpty;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class OrderApiController extends Controller
{
    public function orderMarket($id)
    {
        $pesanan = Order::with('user', 'orderItem.product')->where('store_id', $id)->get();
        if (count($pesanan) <= 0)  return response()->json([
            'message' =>  'Belum ada pesanan'
        ]);

        return ResponseFormatter::success($pesanan, 'List order berhasil ditampil');
    }

    public function orderUser($id)
    {
        $pesanan = Order::with('orderItem.ticket')
            ->where('users_id', $id)->get();
        foreach ($pesanan as $item) {
            $item->qrcode_url = $item->qrcode_url ? url(Storage::url($item->qrcode_url)) : null;
        }

        if (count($pesanan) <= 0)  return response()->json([
            'message' =>  'Belum ada pesanan'
        ]);

        return ResponseFormatter::success($pesanan, 'List order berhasil ditampil');
    }

    public function detailTransaction()
    {
        $item = Cart::where('users_id', Auth::user()->id)->get();
        return response()->json($item, 200);
    }

    public function statusOrder(Request $request, $id)
    {
        $data = $request->validate([
            'status' => 'required|string'
        ]);
        $order = Order::findOrFail($id);
        $data = $request->all();
        $order->update($data);
        return ResponseFormatter::success($order, 'Order berhasil diubah');
    }

    public function allOrder()
    {
        $order = Order::with('orderItem')->get();
        return response()->json($order, 200);
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'nama' => 'required',
            'status' => 'required',
            'total_price' => 'required',
            'name_ticket' => 'required',
            'quantities' => 'required',
        ]);
        // Simpan order
        $order = Order::create([
            'users_id' => Auth::user()->id,
            'nama' => $request->nama,
            'status' => $request->status,
            'total_price' => $request->total_price,
            'name_ticket' => $request->name_ticket,
            'quantities' => $request->quantities,
            'ticket_id' => 1,
        ]);

        $html = View::make('struk_template', ['order' => $order])->render();
        $pdf = PDF::loadHTML($html);
        $pdf->save(public_path('struks/' . $order->id . '.pdf'));

        // Generate QR code
        $qrcodeData = [
            'order_id' => $order->id,
            'total_price' => $order->total_price,
            'user_id' => Auth::user()->id,
            'expiry_date' => now()->addDay()->toDateString() // Tambahkan 1 hari ke tanggal sekarang
        ];
        $qrcodeUrl = $this->generateQRCode(json_encode($qrcodeData));

        // Simpan URL QR code ke order
        $order->qrcode_url = $qrcodeUrl;
        $struckUrl = url('struks/' . $order->id . '.pdf');
        $order->struk_url = $struckUrl;
        $order->save();

        return ResponseFormatter::success($order, 'Transaksi berhasil');
    }

    public function verifyPayment(Request $request)
    {
        $data = $request->input('data'); // Data hasil pemindaian QR code
        $decodedData = json_decode($data, true); // Mendekode data JSON dari QR code

        $order = Order::findOrFail($decodedData['order_id']);

        // Cek apakah pesanan sudah dibayar sebelumnya
        if ($order->status === 'SUCCESS') {
            return response()->json(['error' => 'Pesanan ini sudah dibayar sebelumnya.'], 400);
        }

        if ($order->total_price != $decodedData['total_price'] || $order->users_id != $decodedData['user_id']) {
            return response()->json(['error' => 'Verifikasi pembayaran gagal. Data tidak valid.'], 400);
        }

        // Mengurangi saldo pengguna
        $user = User::findOrFail($decodedData['user_id']);
        $newSaldo = $user->saldo - $order->total_price;

        if ($newSaldo < 0) {
            return response()->json(['error' => 'Saldo pengguna tidak mencukupi.'], 400);
        }

        $user->saldo = $newSaldo;
        $user->save();

        $order->fill(['status' => 'SUCCESS'])->save();

        return response()->json(['message' => 'Pembayaran berhasil diverifikasi', 'order' => $order], 200);
    }


    private function generateQRCode($data)
    {
        $qrcode = QrCode::format('png')->size(400)->generate($data);
        $qrcodePath = 'assets/qrcodes/' . time() . '.png'; // Menentukan path penyimpanan QR code
        Storage::disk('public')->put($qrcodePath, $qrcode); // Menyimpan QR code ke storage

        $url = Storage::url($qrcodePath);
        $url = str_replace('storage/', '', $url); // Menghilangkan "storage/" dari URL path

        return $url; // Mengembalikan URL QR code yang dapat diakses secara publik tanpa "storage/"
    }
}

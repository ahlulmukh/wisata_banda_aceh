<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequest;
use App\Models\Store;
use App\Models\User;
use Exception;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MarketApiController extends Controller
{
    public function markets()
    {
        $markets = Store::all();
        foreach ($markets as $market) {
            if ($market->image != null) {
                $market->image = Storage::url($market->image);
            } else {
                url($market->image);
            }
        }
        return ResponseFormatter::success($markets, 'Data semua toko berhasil diambil');
    }

    public function fetch($id)
    {
        $market = Store::with('tickets')->find($id);
        if ($market->image != null) {
            $market->image = url(Storage::url($market->image));
        } else {
            url($market->image);
        }
        foreach ($market->products as $product) {
            $product->image = url(Storage::url($product->image));
        }
        if (empty($market)) {
            return ResponseFormatter::error([
                'message' => 'Toko tidak ditemukan',
            ], 'Not Found');
        }
        return ResponseFormatter::success($market, 'Data Toko berhasil diambil');
    }

    public function createMarket(Request $request)
    {
        $request->validate([
            'users_id' => 'required|exists:users,id|unique:store,users_id',
            'name_store' => 'required|string|max:255',
            'village' => 'required|string|max:255',
            'address' => 'required|string',
            'description' => 'required|string',
            'account_name' => 'required|string|max:255',
            'account_number' => 'required',
            'verification_store' => 'nullable',
            'image' => 'required|image|mimes:png,jpg,jpeg',
        ]);
        $market = Store::create([
            'users_id' => $request->users_id,
            'name_store' => $request->name_store,
            'village' => $request->village,
            'address' => $request->address,
            'description' => $request->description,
            'account_name' => $request->account_name,
            'account_number' => $request->account_number,
            'image' => $request->hasFile('image') ?  $request->file('image')->store('assets/market', 'public') : null,
        ]);
        return ResponseFormatter::success($market, 'Toko Berhasil dibuat');
    }

    public function limitsMarket()
    {
        $markets = Store::take(6)->get();
        try {
            if ($markets) {
                foreach ($markets as $market) {
                    if ($market->image != null) {
                        $market->image = url(Storage::url($market->image));
                    } else {
                        url($market->image);
                    }
                }
                return ResponseFormatter::success($markets, 'Data list toko berhasil diambil');
            }
        } catch (\Throwable $th) {
            return ResponseFormatter::error($th);
        }
    }

    public function updateMarket(Request $request, $id)
    {
        $market = Store::find($id);
        if (!$market) {
            return response()->json(['message' => 'Id not found'], 404);
        }
        $data = Validator::make($request->all(), [
            'users_id' => 'exists:users,id',
            'name_store' => 'nullable|string|max:255',
            'village' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'description' => 'nullable|string',
            'account_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string',
            'verification_store' => 'nullable',
            'image' => 'nullable|image|mimes:png,jpg,jpeg',
        ]);

        if ($data->fails()) {
            return response()->json(['success' => false, 'message' => $data->errors()], 400);
        }
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('assets/market', 'public');
            $market['image'] = $path;
        }
        $market->update($request->except('image'));
        return ResponseFormatter::success($market, 'Toko Berhasil diubah');
    }
}

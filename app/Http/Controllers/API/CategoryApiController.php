<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\CategoryTicket;
use Illuminate\Support\Facades\Storage;

class CategoryApiController extends Controller
{
    public function categories()
    {
        $categories = CategoryTicket::all();
        return ResponseFormatter::success($categories, 'Data semua kategori berhasil diambil');
    }

    public function category($id)
    {
        $category = CategoryTicket::with('tickets')->find($id);
        foreach ($category->tickets as $ticket) {
            $ticket->image = url(Storage::url($ticket->image));
        }
        return ResponseFormatter::success($category, 'Data kategori berhasil diambil');
    }
}

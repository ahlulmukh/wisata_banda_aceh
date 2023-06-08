<?php

namespace App\Models;

use App\Models\CategoryTicket;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'ticket';

    protected $fillable = [
        'categories_id',
        'name',
        'lokasi',
        'description',
        'price',
        'image',
    ];

    public function category()
    {
        return $this->belongsTo(CategoryTicket::class, 'categories_id', 'id');
    }

    public function cart()
    {
        return $this->hasOne(Cart::class, 'ticket_id', 'id');
    }
}

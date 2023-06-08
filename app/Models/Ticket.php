<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

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
        return $this->belongsTo(Categoryticket::class, 'categories_id', 'id');
    }

    public function cart()
    {
        return $this->hasOne(Cart::class, 'ticket_id', 'id');
    }
}

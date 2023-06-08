<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'product';

    protected $fillable = [
        'store_id',
        'categories_id',
        'name',
        'weight',
        'stock',
        'price',
        'image',
        'description'
    ];

    public function category()
    {
        return $this->belongsTo(CategoryProduct::class, 'categories_id', 'id');
    }

    public function cart()
    {
        return $this->hasOne(Cart::class, 'product_id', 'id');
    }
}

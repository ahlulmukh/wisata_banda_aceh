<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Saldo extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'saldo';

    protected $fillable = [
        'saldo',
        'users_id',
        'image',
        'created_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;

    protected $fillable = [
        'carrito_id',
        'user_id',
        'comentario'
    ];

    public function carrito()
    {
        return $this->belongsTo(Carrito::class, 'carrito_id', 'ID');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleCarrito extends Model
{
    protected $table = 'DETALLE_CARRITO';
    public $timestamps = false;
    protected $primaryKey = null;
    public $incrementing = false;

    protected $fillable = [
        'CARRITO', 'PRODUCTO', 'PRECIO', 'CANTIDAD'
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'PRODUCTO', 'ID');
    }

    public function carrito()
    {
        return $this->belongsTo(Carrito::class, 'CARRITO', 'ID');
    }
}

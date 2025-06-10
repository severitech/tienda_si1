<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    protected $table = 'DETALLE_VENTA';

    protected $fillable = [
        'VENTA',
        'PRODUCTO',
        'PRECIO',
        'CANTIDAD'
    ];

    public function venta()
    {
        return $this->belongsTo(Venta::class, 'VENTA');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'PRODUCTO', 'ID');
    }


}

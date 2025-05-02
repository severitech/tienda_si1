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
}

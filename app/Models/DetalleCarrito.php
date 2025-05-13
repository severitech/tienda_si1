<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleCarrito extends Model
{
    protected $table = 'DETALLE_CARRITO';
    public $timestamps = false; // solo tienes `updated_at`

    public $incrementing = false; // <--- porque tu clave primaria es compuesta

    protected $fillable = [
        'CARRITO',
        'PRODUCTO',
        'PRECIO',
        'CANTIDAD',
    ];

    //RELACION CARRITO
    public function carrito()
    {
        return $this->belongsTo(Carrito::class, 'CARRITO', 'ID');
    } 

    // Relación con Producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'PRODUCTO', 'ID');
    }
}

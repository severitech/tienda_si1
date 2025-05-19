<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleCompra extends Model
{
    protected $table = 'DETALLE_COMPRA';
    public $timestamps = false; // solo tienes `updated_at`

    public $incrementing = false; // <--- porque tu clave primaria es compuesta

    protected $fillable = [
        'COMPRA',
        'PRODUCTO',
        'PRECIO',
        'CANTIDAD',
    ];
    
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'PRODUCTO', 'ID');
    }
    
    /*public function compra()
    {
        return $this->belongsTo(Compra::class, 'PRODUCTO', 'ID');
    }*/
}

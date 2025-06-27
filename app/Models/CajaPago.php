<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CajaPago extends Model
{
    protected $table = 'CAJA_PAGO';
    public $timestamps = false;

    public $incrementing = false;
    protected $primaryKey = null;
    protected $fillable = [
        'CAJA',
        'METODO_PAGO',
        'MONTO',
    ];


    //RELACION CARRITO
    public function caja()
    {
        return $this->belongsTo(Caja::class, 'CAJA', 'ID');
    }

    // Relación con Producto
    public function metodoPago()
    {
        return $this->belongsTo(MetodoPago::class, 'METODO_PAGO', 'METODO_PAGO');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CajaPagos extends Model
{
    protected $table = 'CAJA_PAGO';
    public $timestamps = false; // solo tienes `updated_at`

    public $incrementing = false; // <--- porque tu clave primaria es compuesta
    protected $primaryKey = null; // No hay columna id

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

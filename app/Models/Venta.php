<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'VENTA';
    public $timestamps = true;
    protected $fillable = [
        'TOTAL',
        'USUARIO',
        'CLIENTE',
        'ESTADO',
        'CAJA',
        'METODO_PAGO',
    ];
    public function caja()
    {
        return $this->belongsTo(Caja::class, 'CAJA');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'USUARIO');
    }

    public function cliente()
    {
        return $this->belongsTo(User::class, 'CLIENTE');
    }

    public function metodoPago()
    {
        return $this->belongsTo(MetodoPago::class, 'METODO_PAGO', 'METODO_PAGO');
    }
}

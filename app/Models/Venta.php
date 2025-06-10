<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class venta extends Model
{
    protected $table = 'VENTA';
    public $timestamps = true;
    protected $fillable = [
        'TOTAL',
        'USUARIO',
        'CLIENTE',
        'METODO_PAGO',
    ];
    public function Venta()
    {
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

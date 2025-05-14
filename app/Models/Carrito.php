<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    protected $table = 'CARRITO';
    protected $primaryKey = 'ID';
    public $timestamps = true;

    protected $fillable = [
        'DIRECCION',
        'ESTADO',
        'CLIENTE',
        'METODO_PAGO',
        'TOTAL',
    ];



    // Relación con el cliente (Usuario)
    public function cliente()
    {
        return $this->belongsTo(User::class, 'CLIENTE', 'ID');
    }

    // Relación con el método de pago
    public function metodoPago()
    {
        return $this->belongsTo(MetodoPago::class, 'METODO_PAGO', 'METODO_PAGO');
    }
}

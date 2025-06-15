<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $table = 'COMPRA';
    protected $primaryKey = 'ID';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'TOTAL',
        'DESCRIPCION',
        'PROVEEDOR',
        'CLIENTE',
        'METODO_PAGO',
    ];


    public function usuario()
    {
        return $this->belongsTo(User::class, 'USUARIO');
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'PROVEEDOR');
    }

    public function metodoPago()
    {
        return $this->belongsTo(MetodoPago::class, 'METODO_PAGO', 'METODO_PAGO');
    }

    public function cliente()
    {
        return $this->belongsTo(User::class, 'CLIENTE');
    }
}

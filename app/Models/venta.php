<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class venta extends Model
{
    protected $table = 'VENTA';

    protected $fillable = [
       'TOTAL',
        'USUARIO',
        'CLIENTE',
        'METODO_PAGO',
    ];
    public function Venta() {}
}

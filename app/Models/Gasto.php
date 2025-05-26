<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gasto extends Model
{
    protected $primaryKey = 'ID';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $table = 'GASTOS';

    protected $fillable = [
        'DESCRIPCION',
        'MONTO',
        'CANTIDAD',
        'USUARIO',
        'METODO_PAGO'
    ];
}

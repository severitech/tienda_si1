<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetodoPagos extends Model
{
    protected $table = 'METODO_PAGO';
    protected $primaryKey = 'METODO_PAGO';
    public $incrementing = false; // Porque no es un ID numérico
    protected $keyType = 'string';

    protected $fillable = ['METODO_PAGO', 'descripcion'];

    public function ventas()
    {
        return $this->hasMany(Venta::class, 'METODO_PAGO', 'METODO_PAGO');
    }
}

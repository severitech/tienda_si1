<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetodoPago extends Model
{
    protected $table = 'METODO_PAGO';
    protected $primaryKey = 'METODO_PAGO';
    public $incrementing = false; // Porque tu PK es un string
    protected $keyType = 'string';

    protected $fillable = ['METODO_PAGO'];
}

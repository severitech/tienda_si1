<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MetodoPago extends Model
{
    use HasFactory;

    protected $table = 'METODO_PAGO';

    protected $primaryKey = 'METODO_PAGO';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = ['METODO_PAGO'];
}


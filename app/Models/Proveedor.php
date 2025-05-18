<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'PROVEEDOR';
    protected $primaryKey = 'ID';
    public $timestamps = true;

    protected $fillable = [
        'NOMBRE',
        'TELEFONO',
    ];
}

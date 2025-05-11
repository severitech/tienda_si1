<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    protected $table = 'CARRITO';
    protected $primaryKey = 'ID';
    public $timestamps = true;

    protected $fillable = [
        'DIRECCION', 'ESTADO', 'CLIENTE', 'METODO_PAGO'
    ];

    public function detalles()
    {
        return $this->hasMany(DetalleCarrito::class, 'CARRITO', 'ID');
    }
    public function cliente(){
        return $this->belongsTo(User::class,'CLIENTE','id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'PRODUCTO';
    protected $primaryKey = 'ID';
    public $timestamps = true;

    protected $fillable = [
        'CODIGO',
        'NOMBRE',
        'IMAGEN',
        'PRECIO',
        'CANTIDAD',
        'COSTO_UNITARIO',
        'COSTO_PROMEDIO',
        'ESTADO',
        'CATEGORIA'
    ];
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'CATEGORIA', 'CATEGORIA');
    }
    public function detalleCarritos()
    {
        return $this->hasMany(DetalleCarrito::class);
    }

    public function detalleCompra()
    {
        return $this->hasMany(DetalleCompra::class);
    }
    public function detalleVenta()
    {
        return $this->hasMany(DetalleVenta::class, 'PRODUCTO', 'ID');
    }

}
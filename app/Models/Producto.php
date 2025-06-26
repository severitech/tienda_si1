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
    

    
    public function descuentos()
    {
        return $this->belongsToMany(Descuento::class, 'descuento_producto');
    }

    public function obtenerDescuentoActivo()
    {
        return $this->descuentos()
            ->where('esta_activo', true)
            ->where('inicia_en', '<=', now())
            ->where('termina_en', '>=', now())
            ->first();
    }

    public function obtenerPrecioFinal()
    {
        $descuento = $this->obtenerDescuentoActivo();

        if (!$descuento) {
            return $this->PRECIO;
        }

        if ($descuento->tipo === 'porcentaje') {
            $montoDescuento = $this->PRECIO * ($descuento->valor / 100);
            return $this->PRECIO - $montoDescuento;
        }

        if ($descuento->tipo === 'fijo') {
            return max(0, $this->PRECIO - $descuento->valor);
        }

        return $this->PRECIO;
    }

}
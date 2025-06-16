<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Descuento extends Model
{
    protected $table = 'descuentos';

    // Lista de columnas que se pueden llenar desde el formulario
    protected $fillable = [
        'nombre',
        'descripcion',
        'tipo',
        'valor',
        'inicia_en',
        'termina_en',
        'esta_activo'
    ];

    protected $casts = [
        'inicia_en' => 'datetime',
        'termina_en' => 'datetime',
        'esta_activo' => 'boolean',
    ];

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'descuento_producto');
    }
}
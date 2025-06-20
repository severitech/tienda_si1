<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Descuento extends Model
{
    use HasFactory;
    protected $table = 'descuento';

    // Lista de columnas que se pueden llenar desde el formulario
    protected $fillable = [
        'nombre',
        'descripcion',
        'tipo',
        'valor', 'condicion_n', 
        'regalo_m', 'activo', 'fecha_inicio', 'fecha_fin'
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
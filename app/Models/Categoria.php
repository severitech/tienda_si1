<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'CATEGORIA'; // 👈 esto le dice a Laravel qué tabla usar
         // Nombre real de la tabla en tu base de datos
    protected $primaryKey = 'CATEGORIA';  // Nombre de la columna clave primaria real

    public $incrementing = false;         // Porque probablemente no es autoincremental
    public $timestamps = false; 
    public function productos()
    {
        return $this->hasMany(Producto::class, 'CATEGORIA', 'CATEGORIA');
    }
}


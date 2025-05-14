<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'CATEGORIA';         // 👈 Nombre exacto de la tabla
    protected $primaryKey = 'CATEGORIA';    // 👈 Clave primaria
    public $incrementing = false;           // 👈 Porque es string, no numérico
    public $keyType = 'string';             // 👈 Laravel espera esto para claves no numéricas
    public $timestamps = true;   
    protected $fillable = ['CATEGORIA'];           // 👈 Usa timestamps (porque los incluiste en la tabla)

    public function productos()
    {
        return $this->hasMany(Producto::class, 'CATEGORIA', 'CATEGORIA');
    }
}



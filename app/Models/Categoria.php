<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'CATEGORIA'; // 👈 esto le dice a Laravel qué tabla usar

    public function productos()
    {
        return $this->hasMany(Producto::class, 'CATEGORIA', 'CATEGORIA');
    }
}


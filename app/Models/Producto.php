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
        'ESTADO',
        'CATEGORIA'
    ];
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'CATEGORIA', 'CATEGORIA');
    }


}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    protected $table = 'CAJA';
    protected $primaryKey = 'ID';
    public $timestamps = true;

    protected $fillable = [
        'DESCRIPCION',
        'ESTADO',
        'USUARIO',
    ];
    public function usuario()
    {
        return $this->belongsTo(User::class, 'USUARIO');
    }
}

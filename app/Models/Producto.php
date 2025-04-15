<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'PRODUCTO';
    protected $primaryKey = 'ID';
    public $timestamps = true;
}

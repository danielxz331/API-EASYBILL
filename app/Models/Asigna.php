<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asigna extends Model
{
    use HasFactory;

    protected $table = 'asigna';

    public function producto()
{
    return $this->belongsTo(Producto::class, 'id_producto');
}
}

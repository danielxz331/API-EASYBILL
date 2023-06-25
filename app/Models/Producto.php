<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Asigna;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'producto';

    public function asigna() 
    {
        return $this->hasMany(Asigna::class, 'id_producto'); 
    }
}

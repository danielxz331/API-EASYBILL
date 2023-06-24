<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Asigna;

class Venta extends Model
{
    use HasFactory;

    protected $table = 'venta';

    public function asigna() // el nombre de la función define el nombre de la relación
    {
        return $this->hasMany(Asigna::class, 'id_venta'); // asumiendo que la relación es uno a muchos
    }
}

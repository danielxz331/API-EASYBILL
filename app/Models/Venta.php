<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Asigna;
use App\Models\User;

class Venta extends Model
{
    use HasFactory;

    protected $table = 'venta';

    public function asigna() 
    {
        return $this->hasMany(Asigna::class, 'id_venta'); 
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}

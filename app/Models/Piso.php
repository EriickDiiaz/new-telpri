<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Piso extends Model
{
    use HasFactory;

    /**
     * Obtener la localidad que pertenece al piso. 
     */
    public function localidad()
    {
        return $this->belongsTo(Localidad::class);
    }
}

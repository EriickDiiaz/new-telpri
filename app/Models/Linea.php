<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Linea extends Model
{
    use HasFactory;

    protected $casts = [
        'acceso' => 'array',
    ];

    /**
     * Obtener la LOCALIDAD a la que pertenece la linea. 
     */
    public function localidad()
    {
        return $this->belongsTo(Localidad::class);
    }
    /**
     * Obtener el PISO al que pertenece la linea. 
     */
    public function piso()
    {
        return $this->belongsTo(Piso::class, 'piso_id');
    }

    /**
     * Obtener el CAMPO al que pertenece la linea. 
     */
    public function campo()
    {
        return $this->belongsTo(Campo::class);
    }

    public function historial()
{
    return $this->hasMany(Historial::class);
}
}

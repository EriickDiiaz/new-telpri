<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historial extends Model
{
    protected $table = 'historial';

    protected $fillable = [
        'linea_id',
        'usuario_id',
        'campo',
        'valor_anterior',
        'valor_nuevo',
    ];

    public function linea()
    {
        return $this->belongsTo(Linea::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

}

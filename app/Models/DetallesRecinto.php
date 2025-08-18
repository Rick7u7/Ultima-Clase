<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallesRecinto extends Model
{
    use HasFactory;

    protected $table = 'detalles_recinto';

    protected $fillable = [
        'ubicacion',
        'tipo_superficie',
        'capacidad_espectadores',
        'graderias',
        'vestidores',
        'banos_publico',
        'estacionamiento',
    ];
}

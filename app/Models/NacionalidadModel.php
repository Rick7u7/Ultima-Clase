<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NacionalidadModel extends Model
{
    use HasFactory;

    protected $table = 'nacionalidad';

    protected $fillable = [
        'nombre',
        'pais_origen',
        'activo'
    ];
}
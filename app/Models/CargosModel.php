<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CargosModel extends Model
{
    use HasFactory;

    protected $table = 'cargos';

    protected $fillable = [
        'nombre',
        'activo',
    ];
}
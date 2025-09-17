<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosicionModel extends Model
{
    use HasFactory;

    protected $table = 'posiciones';

    protected $fillable = [
        'abreviatura',
        'nombre',
        'activo',
    ];
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OficiosModel extends Model
{
    use HasFactory;

    protected $table = 'oficios';

    protected $fillable = [
        'nombre',
        'activo',
    ];
}
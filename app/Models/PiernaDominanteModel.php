<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PiernaDominanteModel extends Model
{
    use HasFactory;

    protected $table = 'pierna_dominante';

    protected $fillable = [
        'nombre',
        'activo',
    ];
}
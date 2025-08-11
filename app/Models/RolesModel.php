<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolesModel extends Model
{
    use HasFactory;

    protected $table = 'roles';

    protected $fillable = [
        'nombre',
        'activo',
    ];
    
    public function usuarios()
    {
        return $this->hasMany(User::class, 'rol_id'); // Ajusta 'rol_id' si tu columna se llama distinto
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonaModel extends Model
{
    use HasFactory;

    protected $table = 'persona';

    protected $fillable = [
        'user_id',
        'edad',
        'correo',
        'genero_id',
        'telefono',
        'direccion',
        'nacionalidad'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function entrenador()
    {
        return $this->hasOne(EntrenadorModel::class, 'persona_id');
    }
    
    public function genero()
    {
        return $this->belongsTo(GeneroModel::class, 'genero_id');
    }    
}

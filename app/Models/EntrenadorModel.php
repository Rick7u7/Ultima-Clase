<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntrenadorModel extends Model
{
    use HasFactory;

    protected $table = 'entrenador';

    protected $fillable = [
        'persona_id',
        'nivel',
        'activo'
    ];
    
    public function persona()
    {
        return $this->belongsTo(PersonaModel::class, 'persona_id');
    }
}

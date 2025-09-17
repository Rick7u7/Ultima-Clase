<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JugadoresModel extends Model
{
    protected $table = 'jugadores';

    protected $fillable = [
        'persona_id',
        'pierna_dominante_id',
        'posicionesId',
        'camisetasId',
        'activo',
    ];

    // Relación M:N con posiciones
    public function posiciones()
    {
        return $this->belongsToMany(
            PosicionModel::class,
            'jugador_posicion',
            'jugadorId',
            'posicionId',
            'pierna_dominante_id'
        );
    }

    /**
     * Relación con PiernaDominante: Un jugador tiene una pierna dominante.
     */
    public function piernaDominante()
    {
        return $this->belongsTo(PiernaDominanteModel::class, 'pierna_dominante_id');
    }

    public function posicion()
    {
        return $this->belongsTo(PosicionModel::class, 'posicionesId');
    }

    public function camisetas()
    {
        return $this->belongsTo(CamisetasModel::class, 'camisetasId');
    }

    public function persona()
    {
        return $this->belongsTo(PersonaModel::class, 'persona_id');
    }
}
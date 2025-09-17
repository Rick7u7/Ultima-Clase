<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaldoModel extends Model
{
    use HasFactory;

    protected $table = 'saldo';

    protected $fillable = [
        'persona_id',
        'monto',
        'estado', // 'atrasado', 'pendiente', 'pagado'
    ];

    /**
     * Relación inversa: un saldo puede estar asociado a una persona.
     */
    public function persona()
    {
        return $this->belongsTo(PersonaModel::class, 'persona_id');
    }
}

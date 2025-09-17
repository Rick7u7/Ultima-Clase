<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon; // ← ESTA LÍNEA ES CLAVE

class SaldoModel extends Model
{
    use HasFactory;

    protected $table = 'saldo';

    protected $fillable = [
        'persona_id',
        'monto',
        'estado', // 'atrasado', 'pendiente', 'pagado'
        'mes',
        'año'
    ];

    /**
     * Relación inversa: un saldo puede estar asociado a una persona.
     */
    public function persona()
    {
        return $this->belongsTo(PersonaModel::class, 'persona_id');
    }

    /**
     * Devuelve el nombre del mes en formato legible.
     */
    public function nombreMes(): string
    {
        return Carbon::create()->month($this->mes)->translatedFormat('F');
    }
}


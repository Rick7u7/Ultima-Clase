<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PersonaModel extends Model
{
    use HasFactory;

    protected $table = 'persona';

    protected $fillable = [
        'user_id',
        'edad',
        'correo',
        'telefono',
        'direccion',
        'comunaId',
        'nacionalidadId',
        'oficiosId',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comuna()
    {
        return $this->belongsTo(ComunasModel::class, 'comunaId');
    }

    public function nacionalidad()
    {
        return $this->belongsTo(NacionalidadModel::class, 'nacionalidadId');
    }

    public function oficio()
    {
        return $this->belongsTo(OficiosModel::class, 'oficiosId');
    }
    
    public function jugadores()
    {
        return $this->hasOne(JugadoresModel::class, 'persona_id');
    }
    
    public function entrenador()
    {
        return $this->hasOne(EntrenadorModel::class, 'persona_id');
    }
    
    public function saldo()
    {
        return $this->hasOne(SaldoModel::class, 'persona_id');
    }
}

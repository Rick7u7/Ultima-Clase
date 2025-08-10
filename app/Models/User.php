<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'lastname',
        'rut',
        'password',
        'rol_id', // ← este es el correcto
    ];    

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function rut()
    {
        return 'rut';
    }

    /**
     * Relación con el modelo RolesModel
     */
    public function rol()
    {
        return $this->belongsTo(RolesModel::class, 'rol_id');
    }

    /**
     * Asignar rol 'common' automáticamente si no se especifica
     */
    protected static function booted()
    {
        static::creating(function ($user) {
            if (empty($user->rol)) {
                $commonRole = RolesModel::where('nombre', 'common')->first();

                if (!$commonRole) {
                    throw new \Exception('El rol "common" no existe en la base de datos.');
                }

                $user->rol_id = $commonRole->id;
            }
        });
    }
}

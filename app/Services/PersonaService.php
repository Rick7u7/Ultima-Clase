<?php

namespace App\Services;

use App\Models\User;
use App\Models\PersonaModel;

class PersonaService
{
    public function crearConUsuario(array $data): PersonaModel
    {
        $user = User::create([
            'name' => $data['nombre'],
            'lastname' => $data['apellido'],
            'rut' => $data['rut'],
            'password' => bcrypt(substr($data['apellido'], 0, 1) . $data['nombre']),
        ]);

        return PersonaModel::create([
            'user_id' => $user->id,
            'edad' => $data['edad'],
            'correo' => $data['correo'],
            'genero_id' => $data['genero_id'],
            'telefono' => $data['telefono'],
            'direccion' => $data['direccion'],
            'nacionalidad' => $data['nacionalidad'] ?? 'Chile',
        ]);
    }
}

<?php

namespace App\Services;

use App\Models\User;
use App\Models\PersonaModel;
use App\Models\SaldoModel;
use Carbon\Carbon;

class PersonaService
{
    public function crearConUsuario(array $data): PersonaModel
    {
        // 🧑 Crear usuario base
        $user = User::create([
            'name' => $data['nombre'],
            'lastname' => $data['apellido'],
            'rut' => $data['rut'],
            'password' => bcrypt(substr($data['apellido'], 0, 1) . $data['nombre']),
            'cargoId' => $data['cargoId'],
            'generoId' => $data['generoId'],
            'fechaNacimiento' => $data['fechaNacimiento'],
        ]);

        // 📅 Calcular edad desde fechaNacimiento
        $edad = Carbon::parse($data['fechaNacimiento'])->age;

        // 👤 Crear persona asociada al usuario
        $persona = PersonaModel::create([
            'user_id' => $user->id,
            'correo' => $data['correo'],
            'telefono' => $data['telefono'],
            'direccion' => $data['direccion'],
            'comunaId' => $data['comunaId'],
            'nacionalidadId' => $data['nacionalidadId'],
            'edad' => $edad,
        ]);

        // 💰 Crear saldo vinculado a la persona
        $persona->saldo()->create([
            'monto' => 0,
            'estado' => 'pendiente',
        ]);

        return $persona;
    }
}


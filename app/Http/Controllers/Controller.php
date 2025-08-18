<?php

namespace App\Http\Controllers;

abstract class Controller
{
    // Mensajes personalizados para esta validación
    public $messages = [
        'username.unique' => 'Este nombre de usuario (email) ya está en uso. Por favor, elige otro.',
        'username.required' => 'El usuario es obligatorio.',
        'username.min' => 'El correo electrónico debe ser mínimo de 8 caracteres.',
        'username.max' => 'El correo electrónico debe ser máximo de 50 caracteres.',
        'username.email' => 'El correo electrónico debe ser un email.',
        // Puedes añadir más mensajes específicos si lo necesitas, por ejemplo:
        // 'name.required' => 'El campo Nombre es obligatorio.',
        'password.required' => 'La contraseña es requerida.',
        'password.confirmed' => 'Las contraseñas no coinciden.',
        'pass_actual.required' => 'La contraseña actual es requerida.',
        'roles_nombre.required' => 'El <strong>Nombre</strong> es requerido.',
        'roles_icono.required' => 'El <strong>Icono</strong> es requerido.',
        //Mensajes para los Generos
        'nombre.required' => 'El nombre del género es obligatorio.',
        'nombre.string' => 'El nombre debe ser texto.',
        'nombre.min' => 'El nombre debe tener al menos 3 caracteres.',
        'nombre.max' => 'El nombre no puede superar los 50 caracteres.',
        'icono.required' => 'El icono es obligatorio.',
        'icono.string' => 'El icono debe ser texto (emoji, URL o descripción).',
        //Mensajes para los detalles
        'ubicacion.required' => 'La ubicación es obligatoria.',
        'ubicacion.string' => 'La ubicación debe ser una cadena de texto.',
        'ubicacion.max' => 'La ubicación no puede tener más de 100 caracteres.',
        'ubicacion.min' => 'La ubicación debe tener al menos 3 caracteres.',

        'tipo_superficie.required' => 'El tipo de superficie es obligatorio.',
        'tipo_superficie.string' => 'El tipo de superficie debe ser una cadena de texto.',
        'tipo_superficie.max' => 'El tipo de superficie no puede tener más de 50 caracteres.',

        'capacidad_espectadores.required' => 'La capacidad de espectadores es obligatoria.',
        'capacidad_espectadores.integer' => 'La capacidad debe ser un número entero.',
        'capacidad_espectadores.min' => 'La capacidad no puede ser negativa.',

        'graderias.integer' => 'Las graderías deben ser un número entero.',
        'graderias.min' => 'Las graderías no pueden ser negativas.',

        'vestidores.integer' => 'Los vestidores deben ser un número entero.',
        'vestidores.min' => 'Los vestidores no pueden ser negativos.',

        'banos_publico.integer' => 'Los baños para el público deben ser un número entero.',
        'banos_publico.min' => 'Los baños no pueden ser negativos.',

        'estacionamiento.integer' => 'El estacionamiento debe ser un número entero.',
        'estacionamiento.min' => 'El estacionamiento no puede ser negativo.',
    ];
}

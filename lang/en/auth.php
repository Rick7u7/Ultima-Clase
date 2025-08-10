<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */
    'unique' => 'El :attribute ya ha sido registrado.', // Este es el mensaje por defecto para 'unique'

    // ...

    'attributes' => [
        'username' => 'nombre de usuario', // Añade esta línea
        'email' => 'correo electrónico', // Si usas email también
        'password' => 'contraseña',
        'name' => 'nombre',
        // ... otros atributos que quieras personalizar
    ],

    'failed' => 'These credentials do not match our records.',
    'password' => 'The provided password is incorrect.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',

];

<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        //User::factory()->create([
        //   'name' => 'Test User',
        //    'email' => 'test@example.com',
        //]);
        /**DB::table('users')->insert([
            [
                'rut' => '12345678-9',
                'name' => 'Sebastián',
                'lastname' => 'Cabezas',
                'password' => Hash::make('holaMundo'),
                'fechaNacimiento' => '1987-06-08',
                'generoId' => 2,
                'cargoId' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);*/
        DB::table('roles')->insert([
            [
                'nombre' => 'Admin',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            /**[
                'nombre' => 'Common',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],*/
        ]);
        DB::table('cargos')->insert([
            [
                'nombre' => 'Entrenador',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Jugador',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
        DB::table('genero')->insert([
            [
                'icono' => 'ti tabler-gender-female',
                'nombre' => 'Femenino',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'icono' => 'ti tabler-gender-male',
                'nombre' => 'Masculino',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
        //oficios: hector
        DB::table('oficios')->insert([
            [
                'nombre' => 'Carpintero',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Programador',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Gasfiter',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Doctor',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Abogado',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Contador Auditor',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Enfermero',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Electrico',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Soldador',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Ingeniero Comercial',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Temporero',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
        //posiciones: ethan
        DB::table('posiciones')->insert([
            [
                'abreviatura' => 'POR',
                'nombre' => 'Portero',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'abreviatura' => 'LD',
                'nombre' => 'Lateral Derecho',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'abreviatura' => 'LI',
                'nombre' => 'Lateral Izquierdo',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'abreviatura' => 'CAD',
                'nombre' => 'Carrilero Derecho',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'abreviatura' => 'CAI',
                'nombre' => 'Carrilero Izquierdo',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'abreviatura' => 'DFC',
                'nombre' => 'Defensa Central',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'abreviatura' => 'MCD',
                'nombre' => 'Mediocentro Defensivo',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'abreviatura' => 'MC',
                'nombre' => 'Mediocentro',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'abreviatura' => 'MCO',
                'nombre' => 'Mediocentro Ofensivo',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'abreviatura' => 'MD',
                'nombre' => 'Medio Derecho',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'abreviatura' => 'MI',
                'nombre' => 'Medio Izquierdo',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'abreviatura' => 'ED',
                'nombre' => 'Extremo Derecho',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'abreviatura' => 'EI',
                'nombre' => 'Extremo Izquierdo',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'abreviatura' => 'DC',
                'nombre' => 'Delantero Centro',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'abreviatura' => 'SD',
                'nombre' => 'Segundo Delantero',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]

        ]);
        //premios: Luciano
        /**DB::table('premios')->insert([
            [
                'nombre' => 'Set Parrillero Artesanal',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Parrilla a Carbón',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Botella 750ml Jack Daniels',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Copa de Plata',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Medallas doradas',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Premio Mvp de la Final',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Zapatillas Nike Mercurial',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
        //categorias: robert
        DB::table('categoria')->insert([
            [
                'nombre' => 'Senior (Professional)',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Senior (Amateur)',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Sub-20',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Sub-23',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Junior (5-7 años)',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Junior (8-9 años)',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Junior (10-11 años)',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Junior (12-13 años)',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Junior (14-15 años)',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Junior (16-18 años)',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
        //Medios de pago: Miguel
        DB::table('medios_pagos')->insert([
            [
                'nombre' => 'Efectivo',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Transferencia',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Paypal',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'WebPayDebito',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'WebPayCredito',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'MercadoPago',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Cheque',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);*/
        //Comunas: Santos
        DB::table('comunas')->insert([
            [
                'nombre' => 'Arica',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Camarones',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Putre',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'San Bernardo',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
        //Pierna Buena: Vicente
        DB::table('pierna_dominante')->insert([
            [
                'nombre' => 'Derecha',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Izquierda',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
        //Hora Inicio: Jean Piere
        /**DB::table('hora_inicio')->insert([
            [
                'nombre' => '18:00',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => '18:30',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => '19:00',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => '19:30',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => '20:00',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => '20:30',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
        //Hora Término: Gerard
        DB::table('hora_fin')->insert([
            [
                'nombre' => '19:00',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => '19:30',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => '20:00',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => '20:30',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => '21:00',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => '21:30',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
        //Medios de Contacto: Justin
        DB::table('medio_contacto')->insert([
            [
                'nombre' => 'Email',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Telefono',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'WhatsApp',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Instagram',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Facebook',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Twitter',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
        //Aside: Justin
        DB::table('aside')->insert([
            [
                'nombre' => 'Roles',
                'icono' => 'ti tabler-settings',
                'ruta' => 'backoffice.roles.index',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'cargos',
                'icono' => 'ti tabler-settings',
                'ruta' => 'backoffice.cargos.index',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'recintos',
                'icono' => 'ti-icon-map-pin',
                'ruta' => 'backoffice.recintos.index',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'camisetas',
                'icono' => 'ti-icon-shirt',
                'ruta' => 'backoffice.camisetas.index',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'comunas',
                'icono' => 'ti-icon-building',
                'ruta' => 'backoffice.comunas.index',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'horainicio',
                'icono' => 'ti-icon-clock-hour-3',
                'ruta' => 'backoffice.horainicio.index',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'horafin',
                'icono' => 'ti-icon-clock-hour-3',
                'ruta' => 'backoffice.horafin.index',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'mediospagoa',
                'icono' => 'ti-icon-credit-card-pay',
                'ruta' => 'backoffice.mediospagos.index',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'premios',
                'icono' => 'ti-icon-trophy',
                'ruta' => 'backoffice.premios.index',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'posicion',
                'icono' => 'ti tabler-settings',
                'ruta' => 'backoffice.posicion.index',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'diassemana',
                'icono' => '$ti-icon-calendar;',
                'ruta' => 'backoffice.diassemana.index',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'campeonato',
                'icono' => 'ti tabler-settings',
                'ruta' => 'backoffice.campeonato.index',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'nacionalidad',
                'icono' => 'ti tabler-settings',
                'ruta' => 'backoffice.nacionalidad.index',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'oficios',
                'icono' => 'ti tabler-settings',
                'ruta' => 'backoffice.oficios.index',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'categoria',
                'icono' => 'ti tabler-settings',
                'ruta' => 'backoffice.categoria.index',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'genero',
                'icono' => 'ti tabler-settings',
                'ruta' => 'backoffice.genero.index',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'piernadominante',
                'icono' => 'ti tabler-settings',
                'ruta' => 'backoffice.piernadominante.index',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'mediocontacto',
                'icono' => 'ti tabler-settings',
                'ruta' => 'backoffice.mediocontacto.index',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
        //Recintos: Javiera
        DB::table('recintos')->insert([
            [
                'nombre' => 'Bongo Club',
                'activo' => true,
                'ubicacion' => 'América #670',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Cancha 13',
                'activo' => true,
                'ubicacion' => 'La Florida, cerca de Av. La Florida',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'F5 Santiago',
                'activo' => true,
                'ubicacion' => 'Huechuraba, Ciudad Empresarial',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
        //Dorsales: Camisetas: Paula*/
        DB::table('camisetas')->insert([
            [
                'nombre' => '1',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => '2',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => '3',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => '4',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => '5',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => '6',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => '7',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => '8',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => '9',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => '10',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => '11',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => '12',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => '13',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => '14',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => '15',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => '16',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => '17',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => '18',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => '19',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => '20',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        //Campeonato: Cristian

        /**DB::table('campeonato')->insert([
            [
                'nombre' => 'Champions',
                'descripcion' => 'Suerte en este campeonato competitivo',
                'fecha_inicio' => '30-08-2025',
                'fecha_fin' => '06-09-2025',
                'ubicacion' => 'Calle 123',
                'comuna' => 'San miguel',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Liga',
                'descripcion' => 'Suerte para esta liga competitiva',
                'fecha_inicio' => '13-09-2025',
                'fecha_fin' => '20-09-2025',
                'ubicacion' => 'Calle 123',
                'comuna' => 'La cisterna',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Torneo de la suerte',
                'descripcion' => 'Suerte en este torneo competitivo',
                'fecha_inicio' => '27-09-2025',
                'fecha_fin' => '04-10-2025',
                'ubicacion' => 'Calle 123',
                'comuna' => 'El bosque',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
        //Dias de la semana: Indira
        DB::table('dias_semana')->insert([
            [
                'nombre' => 'Lunes',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Martes',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Miercoles',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Jueves',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Viernes',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);*/
        //Nacionalidades: Manuel
        DB::table('nacionalidad')->insert([
            [
                'nombre' => 'Chilena',
                'pais_origen' => 'Chile',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Venezolana',
                'pais_origen' => 'Venezuela',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Colombiana',
                'pais_origen' => 'Colombia',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Peruana',
                'pais_origen' => 'Perú',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Haitiano',
                'pais_origen' => 'Haití',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            
        ]);
    }
}
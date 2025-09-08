<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\EntrenadorModel;
use App\Models\GeneroModel;
use Illuminate\Support\Facades\DB;
use App\Services\PersonaService;

class EntrenadorController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('/')->withErrors('Debe iniciar sesión.');
        }

        $user = Auth::user();
        $lista = EntrenadorModel::with('persona.user', 'persona.genero')->get();
        $generos = GeneroModel::all();
        $opcionesGenero = $generos->isNotEmpty()
            ? $generos->map(fn($g) => ['value' => $g->id, 'label' => $g->nombre])->toArray()
            : [
                ['value' => 0, 'label' => 'Sin géneros disponibles'],
            ];
        $niveles = [
            ['value' => '1', 'label' => 'Principiante'],
            ['value' => '2', 'label' => 'Intermedio'],
            ['value' => '3', 'label' => 'Avanzado'],
        ];
        $datos = [
            'textos' => [
                'titulo' => 'Iniciar Sesión | Sonkei FC',
                'logo' => '/assets/imgs/logo_sonkei_v2.webp',
                'nombre' => 'Sonkei FC',
                'formulario' => [
                    'titulo' => 'Bienvenido a Sonkei FC ⚽️',
                    'instruccion' => 'Ingrese Credenciales'
                ],
            ],
            'mantenedor' => [
                'titulo' => 'Entrenadores',
                'instruccion' => 'Listado de los Entrenadores.',
                'routes' => [
                    'new'    => 'backoffice.entrenador.store',
                    'update' => 'backoffice.entrenador.update',
                    'delete' => 'backoffice.entrenador.destroy',
                    'up'     => 'backoffice.entrenador.up',
                    'down'   => 'backoffice.entrenador.down',
                ],
                'fields' => [
                    [
                        'label' => 'RUT',
                        'name' => 'rut',
                        'required' => true,
                        'control' => [
                            'element' => 'input',
                            'type' => 'text',
                            'classList' => ['form-control', 'mb-4'],
                            'placeholder' => '12.345.678-9'
                        ],
                    ],
                    [
                        'label' => 'Nombre',
                        'name' => 'nombre',
                        'required' => true,
                        'control' => [
                            'element' => 'input',
                            'type' => 'text',
                            'classList' => ['form-control', 'mb-4'],
                            'min' => 3,
                            'max' => 50,
                            'placeholder' => 'Nombre del entrenador'
                        ],
                    ],
                    [
                        'label' => 'Apellido',
                        'name' => 'apellido',
                        'required' => true,
                        'control' => [
                            'element' => 'input',
                            'type' => 'text',
                            'classList' => ['form-control', 'mb-4'],
                            'min' => 2,
                            'max' => 50,
                            'placeholder' => 'Apellido del entrenador'
                        ],
                    ],
                    [
                        'label' => 'Edad',
                        'name' => 'edad',
                        'required' => true,
                        'control' => [
                            'element' => 'input',
                            'type' => 'number',
                            'min' => 0,
                            'max' => null,
                            'classList' => ['form-control', 'mb-4'],
                            'placeholder' => null,
                        ],
                    ],
                    [
                        'label' => 'Género',
                        'name' => 'genero_id',
                        'required' => true,
                        'control' => [
                            'element' => 'select',
                            'classList' => ['form-select', 'mb-4'],
                            'options' => $opcionesGenero,
                            'placeholder' => 'Seleccione género'
                        ],
                    ],
                    [
                        'label' => 'Telefono',
                        'name' => 'telefono',
                        'required' => true,
                        'control' => [
                            'element' => 'input',
                            'type' => 'number',
                            'min' => 0,
                            'max' => null,
                            'classList' => ['form-control', 'mb-4'],
                            'placeholder' => '+12345678',
                        ],
                    ],
                    [
                        'label' => 'Correo',
                        'name' => 'correo',
                        'required' => true,
                        'control' => [
                            'element' => 'input',
                            'type' => 'email',
                            'classList' => ['form-control', 'mb-4'],
                            'min' => 3,
                            'max' => 50,
                            'placeholder' => 'example@example.com'
                        ],
                    ],
                    [
                        'label' => 'Direccion',
                        'name' => 'direccion',
                        'required' => true,
                        'control' => [
                            'element' => 'input',
                            'type' => 'text',
                            'classList' => ['form-control', 'mb-4'],
                            'min' => 3,
                            'max' => 100,
                            'placeholder' => null,
                        ],
                    ],
                    [
                        'label' => 'Nacionalidad',
                        'name' => 'nacionalidad',
                        'required' => false,
                        'control' => [
                            'element' => 'input',
                            'type' => 'text',
                            'classList' => ['form-control', 'mb-4'],
                            'placeholder' => 'Chile'
                        ],
                    ],                                       
                    [
                        'label' => 'Nivel',
                        'name' => 'nivel',
                        'required' => true,
                        'control' => [
                            'element' => 'select',
                            'classList' => ['form-select', 'mb-4'],
                            'options' => $niveles,
                            'placeholder' => 'Seleccione el nivel'
                        ],
                    ],
                ],
                'access' => [
                    'editableIn' => [
                        'new' => true,
                        'edit' => true,
                        'show' => false,
                        'up' => false,
                        'down' => false,
                        'delete' => false
                    ],
                    'readIn' => [
                        'new' => true,
                        'edit' => true,
                        'show' => true,
                        'up' => true,
                        'down' => true,
                        'delete' => true
                    ]
                ],
            ],
            'dev' => [
                'nombre' => 'Instituto Profesional San Sebastián',
                'url' => 'https://www.ipss.cl',
                'logo' => 'https://ipss.cl/wp-content/uploads/2025/04/cropped-LogoIPSS_sello50anos_webipss.png'
            ]
        ];

        return view('backoffice/entrenador/index', compact('datos', 'user', 'lista'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('/')->withErrors('Debe iniciar sesión.');
        }

        $request->validate([
            'nombre'       => ['required', 'string', 'min:3', 'max:50'],
            'apellido'     => ['required', 'string', 'min:2', 'max:50'],
            'rut'          => ['required', 'string', 'unique:users,rut'],
            'edad'         => ['nullable', 'integer', 'min:0'],
            'genero_id'    => ['nullable', 'exists:genero,id'],
            'telefono'     => ['nullable', 'string', 'min:3'],
            'correo'       => ['required', 'email', 'unique:persona,correo'],
            'direccion'    => ['required', 'string', 'min:3', 'max:100'],
            'nacionalidad' => ['nullable', 'string', 'max:50'],
            'nivel'        => ['required'],
        ], $this->messages);

        // Si no se seleccionó género, usar el ID de "undefined"
        $generoId = $request->input('genero_id');
        if (empty($generoId)) {
            $generoId = DB::table('genero')->where('nombre', 'undefined')->value('id');
        }

        // Preparar datos para el servicio
        $data = $request->only([
            'nombre', 'apellido', 'rut', 'edad', 'telefono',
            'correo', 'direccion', 'nacionalidad', 'nivel'
        ]);
        $data['genero_id'] = $generoId;

        // Crear persona y usuario mediante el servicio
        $personaService = app(PersonaService::class);
        $persona = $personaService->crearConUsuario($data);

        // Crear entrenador vinculado a la persona
        EntrenadorModel::create([
            'persona_id' => $persona->id,
            'nivel'      => $data['nivel'],
            'activo'     => true,
        ]);

        return redirect()->back()->with('success', 'Entrenador creado exitosamente.');
    }

    public function update(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('/')->withErrors('Debe iniciar sesión.');
        }

        $request->validate([
            'nombre' => ['required', 'string', 'min:3', 'max:50'],
            'edad' => ['nullable', 'integer', 'min:0'],
            'genero_id' => ['required'],
            'telefono' => ['nullable', 'string', 'min:0'],
            'correo' => ['required', 'email'],
            'nivel' => ['required'],
        ], $this->messages);

        $entrenador = EntrenadorModel::findOrFail($id);
        $entrenador->update([
            'nombre' => $request->nombre,
            'edad' => $request->edad,
            'genero_id' => $request->genero_id,
            'telefono' => $request->telefono,
            'correo' => $request->correo,
            'nivel' => $request->nivel,
        ]);

        return redirect()->back()->with('success', 'Entrenador actualizado exitosamente.');
    }

    public function down(Request $request, $_id)
    {
        if (!Auth::check()) {
            // Verifica si el usuario NO está autenticado
            return redirect()->route('/')->withErrors('Debe iniciar sesión.');
        }
        $user = Auth::user();

        $buscado = EntrenadorModel::find($_id);

        if ($buscado->activo == 1) {
            $buscado->activo = 0;
            $buscado->save();
            return redirect()->back()->with('success', ':) Entrenador desactivado exitosamente.');
        }
        return redirect()->back()->withErrors('No se realizaron Cambios.');
    }
    public function up(Request $request, $_id)
    {
        if (!Auth::check()) {
            // Verifica si el usuario NO está autenticado
            return redirect()->route('/')->withErrors('Debe iniciar sesión.');
        }
        $user = Auth::user();

        $buscado = EntrenadorModel::find($_id);

        if ($buscado->activo == 0) {
            $buscado->activo = 1;
            $buscado->save();
            return redirect()->back()->with('success', ':) Entrenador activado exitosamente.');
        }
        return redirect()->back()->withErrors('No se realizaron Cambios.');
    }
}

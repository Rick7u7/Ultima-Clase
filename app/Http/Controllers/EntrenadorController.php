<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\EntrenadorModel;
use App\Models\GeneroModel;
use App\Models\CargosModel;
use App\Models\ComunasModel;
use App\Models\NacionalidadModel;
use Illuminate\Support\Facades\DB;
use App\Services\PersonaService;
use Illuminate\Validation\Rule;

class EntrenadorController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('/')->withErrors('Debe iniciar sesión.');
        }

        $user = Auth::user();
        $lista = EntrenadorModel::with('persona.user.genero')->get();
        $generos = GeneroModel::all();
        $cargos = CargosModel::all();
        $comunas = ComunasModel::all();
        $nacionalidades = NacionalidadModel::all();
        $opcionesGenero = $generos->map(fn($g) => [
            'value' => $g->id,
            'label' => $g->nombre
        ])->toArray();
        $opcionesComuna = $comunas->map(fn($g) => [
            'value' => $g->id,
            'label' => $g->nombre
        ])->toArray();
        $opcionesNacionalidad = $nacionalidades->map(fn($g) => [
            'value' => $g->id,
            'label' => $g->nombre
        ])->toArray();
        $niveles = [
            ['value' => '1', 'label' => 'Principiante'],
            ['value' => '2', 'label' => 'Intermedio'],
            ['value' => '3', 'label' => 'Avanzado'],
        ];
        $certificaciones = [
            ['value' => '1', 'label' => 'UEFA C'],
            ['value' => '2', 'label' => 'UEFA B'],
            ['value' => '3', 'label' => 'UEFA A'],
            ['value' => '4', 'label' => 'UEFA Pro'],
            ['value' => '5', 'label' => 'CONMEBOL C'],
            ['value' => '6', 'label' => 'CONMEBOL B'],
            ['value' => '7', 'label' => 'CONMEBOL A'],
            ['value' => '8', 'label' => 'CONMEBOL Pro'],
        ];
        $certificacionesMap = collect($certificaciones)
            ->pluck('label', 'value')
            ->mapWithKeys(fn($label, $value) => [(string) $value => $label])
            ->toArray();
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
                        'label' => 'Fecha de Nacimiento',
                        'name' => 'fechaNacimiento',
                        'required' => true,
                        'control' => [
                            'element' => 'input',
                            'type' => 'date',
                            'min' => null,
                            'max' => null,
                            'classList' => ['form-control', 'mb-4'],
                            'placeholder' => null,
                        ]
                    ],
                    [
                        'label' => 'Género',
                        'name' => 'generoId',
                        'required' => true,
                        'control' => [
                            'element' => 'select',
                            'classList' => ['form-select', 'mb-4'],
                            'options' => $opcionesGenero,
                            'disabled' => $generos->isEmpty(), // ← desactiva el select si no hay géneros
                            'placeholder' => $generos->isEmpty() ? 'Sin registros' : 'Seleccione género'
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
                        'label' => 'Comuna',
                        'name' => 'comunaId',
                        'required' => true,
                        'control' => [
                            'element' => 'select',
                            'classList' => ['form-select', 'mb-4'],
                            'options' => $opcionesComuna,
                            'disabled' => $comunas->isEmpty(),
                            'placeholder' => $comunas->isEmpty() ? 'Sin registros' : 'Seleccione Comuna'
                        ],
                    ],  
                    [
                        'label' => 'Nacionalidad',
                        'name' => 'nacionalidadId',
                        'required' => true,
                        'control' => [
                            'element' => 'select',
                            'classList' => ['form-select', 'mb-4'],
                            'options' => $opcionesNacionalidad,
                            'disabled' => $cargos->isEmpty(), // ← desactiva el select si no hay cargos
                            'placeholder' => $cargos->isEmpty() ? 'Sin registros' : 'Seleccione cargo'
                        ],
                    ],  
                    [
                        'label' => 'Certificaciones',
                        'name' => 'certificacion[]', // 👈 importante: [] para recibir array
                        'required' => true,
                        'control' => [
                            'element' => 'select',
                            'classList' => ['form-select', 'mb-4'],
                            'options' => $certificaciones, // ej: [['value' => 'UEFA A', 'label' => 'UEFA A'], ...]
                            'placeholder' => 'Seleccione los niveles',
                            'attributes' => ['multiple' => true] // 👈 marcamos que es multiple
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
            'certificacionesMap' => $certificacionesMap,
            'dev' => [
                'nombre' => 'Instituto Profesional San Sebastián',
                'url' => 'https://www.ipss.cl',
                'logo' => 'https://ipss.cl/wp-content/uploads/2025/04/cropped-LogoIPSS_sello50anos_webipss.png'
            ]
        ];
        return view('backoffice.entrenador.index', [
            'datos' => $datos,
            'certificacionesMap' => $certificacionesMap,
            'lista' => $lista,
            'user' => $user,
        ]);        
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('/')->withErrors('Debe iniciar sesión.');
        }

        // Certificaciones disponibles
        $certificaciones = [
            ['value' => '1', 'label' => 'UEFA C'],
            ['value' => '2', 'label' => 'UEFA B'],
            ['value' => '3', 'label' => 'UEFA A'],
            ['value' => '4', 'label' => 'UEFA Pro'],
            ['value' => '5', 'label' => 'CONMEBOL C'],
            ['value' => '6', 'label' => 'CONMEBOL B'],
            ['value' => '7', 'label' => 'CONMEBOL A'],
            ['value' => '8', 'label' => 'CONMEBOL Pro'],
        ];
        $certificacionValues = array_column($certificaciones, 'value');

        // Validación estándar
        $request->validate([
            'nombre'          => ['required', 'string', 'min:3', 'max:50'],
            'apellido'        => ['required', 'string', 'min:2', 'max:50'],
            'rut'             => ['required', 'string', 'unique:users,rut'],
            'generoId'        => ['required', Rule::exists('genero', 'id')],
            'fechaNacimiento' => ['required', 'date'],
            'telefono'        => ['required', 'string', 'min:3'],
            'correo'          => ['required', 'email', 'unique:persona,correo'],
            'direccion'       => ['required', 'string', 'min:3', 'max:100'],
            'comunaId'       => ['required', Rule::exists('comunas', 'id')],
            'nacionalidadId' => ['required', Rule::exists('nacionalidad', 'id')],
            'nivel'           => ['required'],
            'certificacion'   => ['required', 'array'],
            'certificacion.*' => ['string', Rule::in($certificacionValues)],
        ], $this->messages);

        // 🔒 Forzar cargo como "Entrenador"
        $cargoEntrenadorId = DB::table('cargos')
            ->where('nombre', 'Entrenador')
            ->value('id');

        if (!$cargoEntrenadorId) {
            return redirect()->back()->withErrors([
                'cargoId' => 'No se encontró el cargo "Entrenador" en la base de datos.'
            ]);
        }

        // Preparar datos para el servicio
        $data = $request->only([
            'nombre', 'apellido', 'rut', 'fechaNacimiento', 'telefono',
            'correo', 'direccion', 'nivel', 'certificacion'
        ]);
        $data['comunaId'] = $request->comunaId;
        $data['nacionalidadId'] = $request->nacionalidadId;
        $data['cargoId'] = $cargoEntrenadorId; // 👈 Asignado directamente
        $data['generoId'] = $request->generoId;

        // Crear persona y usuario mediante el servicio
        $personaService = app(PersonaService::class);
        $persona = $personaService->crearConUsuario($data);

        // Crear entrenador vinculado a la persona
        EntrenadorModel::create([
            'persona_id'    => $persona->id,
            'nivel'         => $data['nivel'],
            'certificacion' => $data['certificacion'], // se guarda como JSON
            'activo'        => true,
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
            'telefono' => ['required', 'string', 'min:0'],
            'correo' => ['required', 'email'],
            'nivel' => ['required'],
            'certificacion' => ['required'],
        ], $this->messages);

        $entrenador = EntrenadorModel::findOrFail($id);
        $entrenador->update([
            'nombre' => $request->nombre,
            'telefono' => $request->telefono,
            'correo' => $request->correo,
            'nivel' => $request->nivel,
            'certificacion' => $request->certificacion,
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

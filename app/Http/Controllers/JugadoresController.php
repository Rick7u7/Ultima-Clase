<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\JugadoresModel;
use App\Models\GeneroModel;
use App\Models\ComunasModel;
use App\Models\OficiosModel;
use App\Models\MedioContactoModel;
use App\Models\PosicionModel;
use App\Models\PiernaDominanteModel;
use App\Models\CargosModel;
use App\Models\NacionalidadModel;
use App\Models\CamisetasModel;
use Illuminate\Support\Facades\DB;
use App\Services\PersonaService;
use Illuminate\Validation\Rule;
use Carbon\Carbon;


class JugadoresController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('/')->withErrors('Debe iniciar sesión.');
        }

        $user = Auth::user();

        $lista = JugadoresModel::with([
            'persona.user.genero',
            'persona.saldos',
            'persona.oficio',
            'persona.nacionalidad',
            'piernaDominante',
            'posicion',
            'camisetas'
        ])->get();

        $generos = GeneroModel::all();
        $comunas = ComunasModel::all();
        $nacionalidades = NacionalidadModel::all();
        $oficios = OficiosModel::all();
        $posiciones = PosicionModel::all();
        $piernas = PiernaDominanteModel::all();
        $camisetas = CamisetasModel::all();

        $opcionesGenero = $generos->map(fn($g) => ['value' => $g->id, 'label' => $g->nombre])->toArray();
        $opcionesComuna = $comunas->map(fn($c) => ['value' => $c->id, 'label' => $c->nombre])->toArray();
        $opcionesNacionalidad = $nacionalidades->map(fn($n) => ['value' => $n->id, 'label' => $n->nombre])->toArray();
        $opcionesOficio = $oficios->map(fn($o) => ['value' => $o->id, 'label' => $o->nombre])->toArray();
        $opcionesPosicion = $posiciones->map(fn($p) => ['value' => $p->id, 'label' => $p->nombre])->toArray();
        $opcionesPierna = $piernas->map(fn($p) => ['value' => $p->id, 'label' => $p->nombre])->toArray();
        $opcionesCamiseta = $camisetas->map(fn($c) => ['value' => $c->id, 'label' => $c->nombre])->toArray();

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
                'titulo' => 'Jugadores',
                'instruccion' => 'Listado de los Jugadores.',
                'routes' => [
                    'new'    => 'backoffice.jugadores.new',
                    'update' => 'backoffice.jugadores.update',
                    'delete' => 'backoffice.jugadores.destroy',
                    'up'     => 'backoffice.jugadores.up',
                    'down'   => 'backoffice.jugadores.down',
                ],
                'fields' => [
                    ['label' => 'RUT', 'name' => 'rut', 'required' => true, 'control' => [
                        'element' => 'input', 'type' => 'text', 'classList' => ['form-control', 'mb-4'], 'placeholder' => '12.345.678-9']],
                    ['label' => 'Nombre', 'name' => 'nombre', 'required' => true, 'control' => [
                        'element' => 'input', 'type' => 'text', 'classList' => ['form-control', 'mb-4'], 'placeholder' => 'Nombre del jugador']],
                    ['label' => 'Apellido', 'name' => 'apellido', 'required' => true, 'control' => [
                        'element' => 'input', 'type' => 'text', 'classList' => ['form-control', 'mb-4'], 'placeholder' => 'Apellido del jugador']],
                    ['label' => 'Fecha de Nacimiento', 'name' => 'fechaNacimiento', 'required' => true, 'control' => [
                        'element' => 'input', 'type' => 'date', 'classList' => ['form-control', 'mb-4']]],
                    ['label' => 'Género', 'name' => 'generoId', 'required' => true, 'control' => [
                        'element' => 'select', 'classList' => ['form-select', 'mb-4'], 'options' => $opcionesGenero]],
                    ['label' => 'Teléfono', 'name' => 'telefono', 'required' => true, 'control' => [
                        'element' => 'input', 'type' => 'text', 'classList' => ['form-control', 'mb-4'], 'placeholder' => '+56912345678']],
                    ['label' => 'Correo', 'name' => 'correo', 'required' => true, 'control' => [
                        'element' => 'input', 'type' => 'email', 'classList' => ['form-control', 'mb-4'], 'placeholder' => 'jugador@sonkei.cl']],
                    ['label' => 'Dirección', 'name' => 'direccion', 'required' => true, 'control' => [
                        'element' => 'input', 'type' => 'text', 'classList' => ['form-control', 'mb-4'], 'placeholder' => 'Ej: Calle Fútbol 123']],
                    ['label' => 'Comuna', 'name' => 'comunaId', 'required' => true, 'control' => [
                        'element' => 'select', 'classList' => ['form-select', 'mb-4'], 'options' => $opcionesComuna]],
                    ['label' => 'Nacionalidad', 'name' => 'nacionalidadId', 'required' => true, 'control' => [
                        'element' => 'select', 'classList' => ['form-select', 'mb-4'], 'options' => $opcionesNacionalidad]],
                    ['label' => 'Oficio', 'name' => 'oficiosId', 'required' => true, 'control' => [
                        'element' => 'select', 'classList' => ['form-select', 'mb-4'], 'options' => $opcionesOficio]],
                    ['label' => 'Pierna Dominante', 'name' => 'pierna_dominante_id', 'required' => true, 'control' => [
                        'element' => 'select', 'classList' => ['form-select', 'mb-4'], 'options' => $opcionesPierna]],
                    ['label' => 'Posición', 'name' => 'posicionesId', 'required' => true, 'control' => [
                        'element' => 'select', 'classList' => ['form-select', 'mb-4'], 'options' => $opcionesPosicion]],
                    ['label' => 'Camiseta', 'name' => 'camisetasId', 'required' => true, 'control' => [
                        'element' => 'select', 'classList' => ['form-select', 'mb-4'], 'options' => $opcionesCamiseta]],
                ],
                'access' => [
                    'editableIn' => ['new' => true, 'edit' => true, 'show' => false, 'up' => false, 'down' => false, 'delete' => false],
                    'readIn' => ['new' => true, 'edit' => true, 'show' => true, 'up' => true, 'down' => true, 'delete' => true]
                ]
            ],
            'dev' => [
                'nombre' => 'Instituto Profesional San Sebastián',
                'url' => 'https://www.ipss.cl',
                'logo' => 'https://ipss.cl/wp-content/uploads/2025/04/cropped-LogoIPSS_sello50anos_webipss.png'
            ]
        ];

        return view('backoffice/jugadores/index', compact('datos', 'user', 'lista'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('/')->withErrors('Debe iniciar sesión.');
        }

        // Validación completa
        $validated = $request->validate([
            'nombre'               => ['required', 'string', 'min:3', 'max:50'],
            'apellido'             => ['required', 'string', 'min:2', 'max:50'],
            'rut'                  => ['required', 'string', 'unique:users,rut'],
            'generoId'             => ['required', Rule::exists('genero', 'id')],
            'fechaNacimiento'      => ['required', 'date'],
            'telefono'             => ['required', 'string', 'min:3'],
            'correo'               => ['required', 'email', 'unique:persona,correo'],
            'direccion'            => ['required', 'string', 'min:3', 'max:100'],
            'comunaId'             => ['required', Rule::exists('comunas', 'id')],
            'nacionalidadId'       => ['required', Rule::exists('nacionalidad', 'id')],
            'oficiosId'            => ['required', Rule::exists('oficios', 'id')],
            'posicionesId'         => ['required', Rule::exists('posiciones', 'id')],
            'pierna_dominante_id'  => ['required', Rule::exists('pierna_dominante', 'id')],
            'camisetasId'          => ['required', Rule::exists('camisetas', 'id')],
        ], $this->messages);

        // 🔒 Forzar cargo como "Jugador"
        $cargoJugadorId = DB::table('cargos')
            ->where('nombre', 'Jugador')
            ->value('id');

        if (!$cargoJugadorId) {
            return redirect()->back()->withErrors([
                'cargoId' => 'No se encontró el cargo "Jugador" en la base de datos.'
            ]);
        }

        // Preparar datos para el servicio
        $data = $request->only([
            'nombre', 'apellido', 'rut', 'fechaNacimiento', 'telefono',
            'correo', 'direccion', 'comunaId', 'nacionalidadId'
        ]);
        $data['cargoId'] = $cargoJugadorId;
        $data['generoId'] = $validated['generoId'];

        // Crear persona y usuario mediante el servicio
        $personaService = app(PersonaService::class);
        $persona = $personaService->crearConUsuario($data);

        // Crear jugador vinculado a la persona
        JugadoresModel::create([
            'persona_id'           => $persona->id,
            'pierna_dominante_id'  => $validated['pierna_dominante_id'],
            'posicionesId'         => $validated['posicionesId'],
            'camisetasId'          => $validated['camisetasId'],
            'activo'               => true,
        ]);

        return redirect()->back()->with('success', 'Jugador creado exitosamente.');
    }

    public function update(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('/')->withErrors('Debe iniciar sesión.');
        }

        $request->validate([
            'nombre' => ['required', 'string', 'min:3', 'max:50'],
            // 'edad' => ['required', 'integer', 'min:0'],
            'generoId' => ['required'],
            //'telefono' => ['required', 'string', 'min:0'],
            //'correo' => ['required', 'email'],
        ], $this->messages);

        $jugador = JugadoresModel::findOrFail($id);
        $jugador->update([
            'nombre' => $request->nombre,
            'edad' => $request->edad,
            'generoId' => $request->genero_id,
            //'telefono' => $request->telefono,
            //'correo' => $request->correo,
            //'nivel' => $request->nivel,
        ]);

        return redirect()->back()->with('success', 'Jugador actualizado exitosamente.');
    }

    public function down(Request $request, $_id)
    {
        if (!Auth::check()) {
            return redirect()->route('/')->withErrors('Debe iniciar sesión.');
        }

        $jugador = JugadoresModel::with('persona.user')->find($_id);

        if (!$jugador || !$jugador->persona || !$jugador->persona->user) {
            return redirect()->back()->withErrors('Jugador o usuario no encontrado.');
        }

        // Cambiar el estado en la tabla users
        if ($jugador->persona->user->activo == 1) {
            $jugador->persona->user->activo = 0;
            $jugador->persona->user->save();

            // También cambiar el estado del jugador
            $jugador->activo = 0;
            $jugador->save();

            return redirect()->back()->with('success', 'Jugador desactivado exitosamente.');
        }

        return redirect()->back()->withErrors('No se realizaron cambios.');
    }


    public function up(Request $request, $_id)
    {
        if (!Auth::check()) {
            return redirect()->route('/')->withErrors('Debe iniciar sesión.');
        }

        $jugador = JugadoresModel::with('persona.user')->find($_id);

        if (!$jugador || !$jugador->persona || !$jugador->persona->user) {
            return redirect()->back()->withErrors('Jugador o usuario no encontrado.');
        }

        // Cambiar el estado en la tabla users
        if ($jugador->persona->user->activo == 0) {
            $jugador->persona->user->activo = 1;
            $jugador->persona->user->save();

            // También cambiar el estado del jugador
            $jugador->activo = 1;
            $jugador->save();

            return redirect()->back()->with('success', 'Jugador activado exitosamente.');
        }

        return redirect()->back()->withErrors('No se realizaron cambios.');
    }


    // fin de desactivar y activar
}
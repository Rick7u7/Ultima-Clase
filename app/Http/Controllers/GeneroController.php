<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\GeneroModel;

class GeneroController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('/')->withErrors('Debe iniciar sesión.');
        }

        $user = Auth::user();
        $lista = GeneroModel::all();

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
                'titulo' => 'Géneros',
                'instruccion' => 'Dime tu género.',
                'routes' => [
                    'new'    => 'backoffice.genero.store',
                    'update' => 'backoffice.genero.update',
                    'delete' => 'backoffice.genero.destroy',
                    'up'     => 'backoffice.genero.up',
                    'down'   => 'backoffice.genero.down',
                ],
                'fields' => [
                    [
                        'label' => 'Icono',
                        'name' => 'icono',
                        'required' => true,
                        'control' => [
                            'element' => 'input',
                            'type' => 'text',
                            'classList' => ['form-control', 'mb-4'],
                            'min' => 3,
                            'max' => 50,
                            'placeholder' => 'Ej: ♂, ♀, Otro'
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
                            'placeholder' => 'Ej: Masculino, Femenino, Otro'
                        ],
                    ],
                ],
                'access' => [   // 👈 ahora está al mismo nivel
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

        return view('backoffice/genero/index', compact('datos', 'user', 'lista'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('/')->withErrors('Debe iniciar sesión.');
        }

        $request->validate([
            'nombre' => ['required', 'string', 'min:3', 'max:50'],
            'icono' => ['required', 'string'],
        ], $this->messages);

        GeneroModel::create([
            'nombre' => $request->nombre,
            'icono' => $request->icono,
        ]);

        return redirect()->back()->with('success', 'Género creado exitosamente.');
    }

    public function update(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('/')->withErrors('Debe iniciar sesión.');
        }

        $request->validate([
            'nombre' => ['required', 'string', 'min:3', 'max:50'],
            'icono' => ['required', 'string'],
        ], $this->messages);

        $genero = GeneroModel::findOrFail($id);
        $genero->update([
            'nombre' => $request->nombre,
            'icono' => $request->icono,
        ]);

        return redirect()->back()->with('success', 'Género actualizado exitosamente.');
    }

    public function down(Request $request, $_id)
    {
        if (!Auth::check()) {
            // Verifica si el usuario NO está autenticado
            return redirect()->route('/')->withErrors('Debe iniciar sesión.');
        }
        $user = Auth::user();

        $buscado = GeneroModel::find($_id);

        if ($buscado->activo == 1) {
            $buscado->activo = 0;
            $buscado->save();
            return redirect()->back()->with('success', ':) Genero apagado exitosamente.');
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

        $buscado = GeneroModel::find($_id);

        if ($buscado->activo == 0) {
            $buscado->activo = 1;
            $buscado->save();
            return redirect()->back()->with('success', ':) Genero encendido exitosamente.');
        }
        return redirect()->back()->withErrors('No se realizaron Cambios.');
    }

    public function destroy($id)
    {
        if (!Auth::check()) {
            return redirect()->route('/')->withErrors('Debe iniciar sesión.');
        }

        $genero = GeneroModel::findOrFail($id);
        $genero->delete();

        return redirect()->back()->with('success', 'Género eliminado exitosamente.');
    }
}

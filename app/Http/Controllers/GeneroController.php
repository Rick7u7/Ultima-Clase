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
                    'new' => 'backoffice.genero.store',
                    'update' => 'backoffice.genero.update',
                    'delete' => 'backoffice.genero.destroy',
                ],
                'fields' => [
                    [
                        'label' => 'Icono',
                        'name' => 'icono',
                        'required' => true,
                        'control' => [
                            'element' => 'select',
                            'options' => ['♂', '♀', 'Otro']
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
                ]
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

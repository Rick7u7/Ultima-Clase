<?php

namespace App\Http\Controllers;

use App\Models\DetallesRecinto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DetallesRecintoController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('/')->withErrors('Debe iniciar sesión.');
        }

        $user = Auth::user();
        $lista = DetallesRecinto::all();

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
                'titulo' => 'Detalles del Recinto',
                'instruccion' => 'Aquí se gestionan las características del recinto.',
                'routes' => [
                    'new' => 'backoffice.detallesrecinto.store',
                    'update' => 'backoffice.detallesrecinto.update',
                    'delete' => 'backoffice.detallesrecinto.destroy',
                ],
                'fields' => [
                    [
                        'label' => 'Ubicación',
                        'name' => 'ubicacion',
                        'required' => true,
                        'control' => [
                            'element' => 'input',
                            'type' => 'text',
                            'classList' => ['form-control', 'mb-4'],
                            'min' => 3,
                            'max' => 100,
                            'placeholder' => 'Ej: Santiago Centro'
                        ],
                    ],
                    [
                        'label' => 'Tipo de superficie',
                        'name' => 'tipo_superficie',
                        'required' => true,
                        'control' => [
                            'element' => 'select',
                            'options' => ['Césped natural', 'Césped sintético', 'Mixto']
                        ],
                    ],
                    [
                        'label' => 'Capacidad de espectadores',
                        'name' => 'capacidad_espectadores',
                        'required' => true,
                        'control' => [
                            'element' => 'input',
                            'type' => 'number',
                            'min' => 0,
                            'classList' => ['form-control', 'mb-4']
                        ],
                    ],
                    [
                        'label' => 'Graderías',
                        'name' => 'graderias',
                        'required' => false,
                        'control' => [
                            'element' => 'input',
                            'type' => 'number',
                            'min' => 0,
                        ],
                    ],
                    [
                        'label' => 'Vestidores',
                        'name' => 'vestidores',
                        'required' => false,
                        'control' => [
                            'element' => 'input',
                            'type' => 'number',
                            'min' => 0,
                        ],
                    ],
                    [
                        'label' => 'Baños público',
                        'name' => 'banos_publico',
                        'required' => false,
                        'control' => [
                            'element' => 'input',
                            'type' => 'number',
                            'min' => 0,
                        ],
                    ],
                    [
                        'label' => 'Estacionamiento',
                        'name' => 'estacionamiento',
                        'required' => false,
                        'control' => [
                            'element' => 'input',
                            'type' => 'number',
                            'min' => 0,
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

        return view('backoffice/DetallesRecinto/index', compact('datos', 'user', 'lista'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('/')->withErrors('Debe iniciar sesión.');
        }

        $request->validate([
            'ubicacion' => ['required', 'string', 'max:100', 'min:3'],
            'tipo_superficie' => ['required', 'string', 'max:50'],
            'capacidad_espectadores' => ['required', 'integer', 'min:0'],
            'graderias' => ['nullable', 'integer', 'min:0'],
            'vestidores' => ['nullable', 'integer', 'min:0'],
            'banos_publico' => ['nullable', 'integer', 'min:0'],
            'estacionamiento' => ['nullable', 'integer', 'min:0'],
        ], $this->messages);        

        DetallesRecinto::create($request->all());

        return redirect()->back()->with('success', 'Detalles del recinto creados exitosamente.');
    }

    public function update(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('/')->withErrors('Debe iniciar sesión.');
        }

        $detalles = DetallesRecinto::findOrFail($id);

        $request->validate([
            'ubicacion' => ['required', 'string', 'max:100', 'min:3'],
            'tipo_superficie' => ['required', 'string', 'max:50'],
            'capacidad_espectadores' => ['required', 'integer', 'min:0'],
            'graderias' => ['nullable', 'integer', 'min:0'],
            'vestidores' => ['nullable', 'integer', 'min:0'],
            'banos_publico' => ['nullable', 'integer', 'min:0'],
            'estacionamiento' => ['nullable', 'integer', 'min:0'],
        ], $this->messages);        

        $detalles->update($request->all());

        return redirect()->back()->with('success', 'Detalles del recinto actualizados exitosamente.');
    }

    public function destroy($id)
    {
        if (!Auth::check()) {
            return redirect()->route('/')->withErrors('Debe iniciar sesión.');
        }

        $detalles = DetallesRecinto::findOrFail($id);
        $detalles->delete();

        return redirect()->back()->with('success', 'Detalles del recinto eliminados exitosamente.');
    }
}

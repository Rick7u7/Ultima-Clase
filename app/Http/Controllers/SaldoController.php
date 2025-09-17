<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SaldoModel;
use App\Models\PersonaModel;

class SaldoController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('/')->withErrors('Debe iniciar sesión.');
        }

        $user = Auth::user();
        $lista = \App\Models\PersonaModel::with(['user', 'saldos'])->get();

        $datos = [
            'textos' => [
                'titulo' => 'Iniciar Sesión | Sonkei FC',
                'logo' => '/assets/imgs/logo_sonkei_v2.webp',
                'nombre' => 'Sonkei FC',
                'formulario' => [
                    'titulo' => 'Bienvenido a Sonkei FC 💰',
                    'instruccion' => 'Gestión de saldos'
                ],
            ],
            'mantenedor' => [
                'titulo' => 'Saldos',
                'instruccion' => 'Registra el estado financiero.',
                'routes' => [
                    'new'    => 'backoffice.saldos.store',
                    'update' => 'backoffice.saldos.update',
                    'delete' => 'backoffice.saldos.destroy',
                    'up'     => 'backoffice.saldos.up',
                    'down'   => 'backoffice.saldos.down',
                ],
                'fields' => [
                    [
                        'label' => '',
                        'name' => 'persona_id',
                        'type' => 'hidden',
                        'value' => '',
                        'control' => [
                            'element' => 'input',
                            'type' => 'hidden',
                            'classList' => [], // sin clases visibles
                        ]
                    ],
                    [
                        'label' => 'Monto',
                        'name' => 'monto',
                        'required' => true,
                        'control' => [
                            'element' => 'input',
                            'type' => 'number',
                            'step' => '0.01',
                            'classList' => ['form-control', 'mb-4'],
                            'placeholder' => 'Ej: 15000.00'
                        ],
                    ],
                    [
                        'label' => 'Mes',
                        'name' => 'mes',
                        'required' => true,
                        'control' => [
                            'element' => 'input',
                            'type' => 'number',
                            'min' => 0,
                            'max' => 12,
                            'classList' => ['form-control', 'mb-4'],
                            'placeholder' => '01',
                        ],
                    ],
                    [
                        'label' => 'Año',
                        'name' => 'año',
                        'required' => true,
                        'control' => [
                            'element' => 'input',
                            'type' => 'number',
                            'classList' => ['form-control', 'mb-4'],
                            'attributes' => [
                                'min' => 0,
                                'max' => 4,
                                'placeholder' => 'Ingrese el año',
                            ],
                        ],
                    ],   
                    [
                        'label' => 'Estado',
                        'name' => 'estado',
                        'required' => true,
                        'control' => [
                            'element' => 'select',
                            'classList' => ['form-control', 'mb-4'],
                            'options' => [
                                ['value' => 'pendiente', 'label' => 'Pendiente'],
                                ['value' => 'pagado', 'label' => 'Pagado'],
                            ]
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

        return view('backoffice/saldo/index', compact('datos', 'user', 'lista'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('/')->withErrors('Debe iniciar sesión.');
        }

        $request->validate([
            'persona_id' => ['required', 'exists:persona,id'],
            'monto' => ['required', 'numeric', 'min:0'],
            'mes' => ['required', 'integer', 'between:1,12'],
            'año' => ['required', 'integer', 'min:2000'],
        ]);

        $mes = $request->mes;
        $año = $request->año;

        // Determinar estado automáticamente
        $estado = ($año < now()->year || ($año == now()->year && $mes < now()->month))
            ? 'atrasado'
            : 'pendiente';

        // Evitar duplicados por persona/mes/año
        $existe = SaldoModel::where('persona_id', $request->persona_id)
            ->where('mes', $mes)
            ->where('año', $año)
            ->exists();

        if ($existe) {
            return back()->with('error', 'Ya existe un saldo para ese jugador en ese mes.');
        }

        SaldoModel::create([
            'persona_id' => $request->persona_id,
            'monto' => $request->monto,
            'estado' => $estado,
            'mes' => $mes,
            'año' => $año,
        ]);

        return redirect()->back()->with('success', 'Saldo registrado correctamente.');
    }


    public function update(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('/')->withErrors('Debe iniciar sesión.');
        }

        $request->validate([
            'monto' => ['required', 'numeric', 'min:0'],
            'estado' => ['required', 'in:pendiente,atrasado,pagado'],
            'mes' => ['required', 'integer', 'between:1,12'],
            'año' => ['required', 'integer', 'min:2000'],
        ]);

        $saldos = SaldoModel::findOrFail($id);

        // Verificar si el nuevo mes/año ya existe para esta persona (excepto este mismo saldo)
        $existe = SaldoModel::where('persona_id', $saldos->persona_id)
            ->where('mes', $request->mes)
            ->where('año', $request->año)
            ->where('id', '!=', $saldos->id)
            ->exists();

        if ($existe) {
            return back()->with('error', 'Ya existe otro saldo para ese jugador en ese mes.');
        }

        $saldos->update([
            'monto' => $request->monto,
            'estado' => $request->estado,
            'mes' => $request->mes,
            'año' => $request->año,
        ]);

        return redirect()->back()->with('success', 'Saldo actualizado correctamente.');
    }

}

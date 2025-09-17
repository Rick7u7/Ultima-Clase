<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SaldoModel;

class SaldoController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('/')->withErrors('Debe iniciar sesión.');
        }

        $user = Auth::user();
        $lista = SaldoModel::with('persona.user')->get();

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
                    'new'    => 'backoffice.saldo.store',
                    'update' => 'backoffice.saldo.update',
                    'delete' => 'backoffice.saldo.destroy',
                    'up'     => 'backoffice.saldo.up',
                    'down'   => 'backoffice.saldo.down',
                ],
                'fields' => [
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
                        'label' => 'Estado',
                        'name' => 'estado',
                        'required' => true,
                        'control' => [
                            'element' => 'select',
                            'classList' => ['form-control', 'mb-4'],
                            'options' => [
                                ['value' => 'pendiente', 'label' => 'Pendiente'],
                                ['value' => 'atrasado', 'label' => 'Atrasado'],
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

    public function update(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('/')->withErrors('Debe iniciar sesión.');
        }

        $request->validate([
            'monto' => ['required', 'numeric', 'min:0'],
            'estado' => ['required', 'in:pendiente,atrasado,pagado'],
        ]);

        $saldo = SaldoModel::findOrFail($id);

        $saldo->update([
            'monto' => $request->monto,
            'estado' => $request->estado,
        ]);

        return redirect()->back()->with('success', 'Saldo actualizado correctamente.');
    }
}

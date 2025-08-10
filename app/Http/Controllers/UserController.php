<?php

namespace App\Http\Controllers;

use App\Models\User;  // Importar el modelo User
use Illuminate\Auth\Events\Registered;  // Opcional, si usas el evento Registered
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;  // Importar la fachada Hash
use Illuminate\Validation\Rules\Password;  // Importar la clase Password

class UserController extends Controller
{
    public function showFormRegistro()
    {
        if (Auth::check()) {
            // Verifica si el el usuario ya está autenticado
            return redirect()->route('/')->with('success', 'Tiene una sesión iniciada, ciérrela para crear una nueva.');
        }

        $datos = [
            'textos' => [
                'titulo' => 'Registrar | Sonkei FC',
                'logo' => '/assets/imgs/logo_sonkei_v2.webp',
                'nombre' => 'Sonkei FC',
                'formulario' => [
                    'titulo' => 'Registro Sonkei FC ⚽️',
                    'instruccion' => 'Ingrese sus datos para registrarse en el sistema'
                ],
            ],
            'dev' => [
                'nombre' => 'Instituto Profesional San Sebastián',
                'url' => 'https://www.ipss.cl',
                'logo' => 'https://ipss.cl/wp-content/uploads/2025/04/cropped-LogoIPSS_sello50anos_webipss.png'
            ]
        ];
        
        return view('backoffice/users/registro', $datos);
    }

    public function guardarNuevo(Request $request)
    {
        // 1. revisar los datos que llegan del formulario
        // dd($request->all());

        // 2. Validación de los datos del formulario
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'rut' => ['required', 'min:9', 'max:10', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Password::defaults()],
        ], $this->messages);

        // 3. Creación del nuevo usuario en la base de datos
        $user = User::create([
            'name' => $request->name,
            'lastname' => $request->lastname,
            'rut' => $request->rut,
            'password' => Hash::make($request->password),
        ]);

        // Opcional: Disparar el evento Registered si necesitas enviar correos de verificación, etc.
        // event(new Registered($user));

        // 4. Redirigir a la página de login con un mensaje de éxito
        return redirect()->route('/')->with('success', 'Usuario creado, debe iniciar sesión.');
    }

    public function showFormLogin()
    {
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
            'dev' => [
                'nombre' => 'Instituto Profesional San Sebastián',
                'url' => 'https://www.ipss.cl',
                'logo' => 'https://ipss.cl/wp-content/uploads/2025/04/cropped-LogoIPSS_sello50anos_webipss.png'
            ]
        ];

        
        if (Auth::check()) {
            // Si el usuario ya está autenticado, redirígelo a la página principal
            // o a su dashboard.
            return redirect()->route('/')->with('success', 'Tiene una sesión iniciada, ciérrela para iniciar una nueva.');
        }
        

        return view('backoffice/users/login', $datos);
    }

    public function login(Request $request)
    {
        // Paso 1: Ver qué llega en la solicitud del formulario
        // dd($request->all());

        $credentials = $request->validate([
            'rut' => ['required'],
            'password' => ['required'],
        ]);

        //dd($credentials);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            return redirect()->route('/')->with('success', "Bienvenido {$user->name}, tiene una sesión iniciada exitosamente.");
        }

        return back()->withErrors([
            'username' => 'Las credenciales no coinciden con nuestros registros.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('/')->with('success', 'Sesión cerrada exitosamente.');
    }

    public function showPerfil(){
        if (!Auth::check()) {
            // Verifica si el el usuario ya está autenticado
            return redirect()->route('/')->withErrors('Error: No tiene una sesión iniciada.');
        }

        $user = Auth::user();

        $datos = [
            'textos' => [
                'titulo' => 'Mantenedor Usuarios | Sonkei FC',
                'logo' => '/assets/imgs/logo_sonkei_v2.webp',
                'nombre' => 'Sonkei FC',
                'formulario' => [
                    'titulo' => 'Registro Sonkei FC ⚽️',
                    'instruccion' => 'Ingrese sus datos para registrarse en el sistema'
                ],
            ],
            'dev' => [
                'nombre' => 'Instituto Profesional San Sebastián',
                'url' => 'https://www.ipss.cl',
                'logo' => 'https://ipss.cl/wp-content/uploads/2025/04/cropped-LogoIPSS_sello50anos_webipss.png'
            ],
            'user' => $user
        ];

        return view('backoffice/users/profile', [
            'datos' => $datos,
            'user' => $user
        ]);


    }
    
    public function showContacto(){
        if (!Auth::check()) {
            // Verifica si el el usuario ya está autenticado
            return redirect()->route('/')->withErrors('Error: No tiene una sesión iniciada.');
        }

        $user = Auth::user();

        $datos = [
            'textos' => [
                'titulo' => 'Mantenedor Usuarios | Sonkei FC',
                'logo' => '/assets/imgs/logo_sonkei_v2.webp',
                'nombre' => 'Sonkei FC',
                'formulario' => [
                    'titulo' => 'Registro Sonkei FC ⚽️',
                    'instruccion' => 'Ingrese sus datos para registrarse en el sistema'
                ],
            ],
            'dev' => [
                'nombre' => 'Instituto Profesional San Sebastián',
                'url' => 'https://www.ipss.cl',
                'logo' => 'https://ipss.cl/wp-content/uploads/2025/04/cropped-LogoIPSS_sello50anos_webipss.png'
            ],
            'user' => $user
        ];

        return view('backoffice/users/contact', $datos);


    }
    
    public function showSeguridad(){
        if (!Auth::check()) {
            // Verifica si el el usuario ya está autenticado
            return redirect()->route('/')->withErrors('Error: No tiene una sesión iniciada.');
        }

        $user = Auth::user();

        $datos = [
            'textos' => [
                'titulo' => 'Mantenedor Usuarios | Sonkei FC',
                'logo' => '/assets/imgs/logo_sonkei_v2.webp',
                'nombre' => 'Sonkei FC',
                'formulario' => [
                    'titulo' => 'Registro Sonkei FC ⚽️',
                    'instruccion' => 'Ingrese sus datos para registrarse en el sistema'
                ],
            ],
            'dev' => [
                'nombre' => 'Instituto Profesional San Sebastián',
                'url' => 'https://www.ipss.cl',
                'logo' => 'https://ipss.cl/wp-content/uploads/2025/04/cropped-LogoIPSS_sello50anos_webipss.png'
            ],
            'user' => $user
        ];

        return view('backoffice/users/security', $datos);


    }

    public function cambiarClave(Request $_request){
        if (!Auth::check()) {
            // Verifica si el el usuario ya está autenticado
            return redirect()->route('/')->withErrors('Error: No tiene una sesión iniciada.');
        }

        $user = Auth::user();

        $_request->validate([
            'pass_actual' => ['required'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ], $this->messages);

        if (Hash::check($_request->pass_actual, $user->password)) {
            $user->password = Hash::make($_request->password);
            $user->save();
            return redirect()->route('backoffice.user.security')->with('success', 'Contraseña cambiada exitosamente.');
        } else {
            return redirect()->route('backoffice.user.security')->withErrors('Error: Contraseña actual incorrecta.');
        }


    }

    public function listUsers(){
        if (!Auth::check()) {
            return redirect()->route('/')->withErrors('Debe iniciar sesión.');
        }

        $user = Auth::user();

        $usuarios = User::with('rol')->get(); // ← Incluye relación con rol

        $datos = [
            'textos' => [
                'titulo' => 'Mantenedor Usuarios | Sonkei FC',
                'logo' => '/assets/imgs/logo_sonkei_v2.webp',
                'nombre' => 'Sonkei FC',
                'formulario' => [
                    'titulo' => 'Registro Sonkei FC ⚽️',
                    'instruccion' => 'Ingrese sus datos para registrarse en el sistema'
                ],
            ],
            'dev' => [
                'nombre' => 'Instituto Profesional San Sebastián',
                'url' => 'https://www.ipss.cl',
                'logo' => 'https://ipss.cl/wp-content/uploads/2025/04/cropped-LogoIPSS_sello50anos_webipss.png'
            ],
            'user' => $user
        ];

        return view('backoffice/users/list', [
            'datos' => $datos,
            'user' => $user,
            'users' => $usuarios // ← Aquí pasas la lista de usuarios
        ]);
    }
}

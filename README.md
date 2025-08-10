# Instituto Profesional San Sebastián
# Docente: Sebastián Cabezas Ríos

## Desarrollo Web I - Framework Laravel 12

### Instalación

#### Studio Firebase de Google

1. Ingresa a https://studio.firebase.google.com
2. Crea un nuevo proyecto Laravel

### En Windows

1. Instala XAMPP
2. Instala composer desde [getcomposer.org/download](https://getcomposer.org/download/)
3. Ingresa a un directorio y ejecuta el siguiente comando (reemplaza nombre-proyecto con el nombre de tu aplicación):
```bash
composer create-project laravel/laravel nombre-proyecto
```
4. Ingresa a tu proyecto (reemplaza nombre-proyecto con el nombre de tu aplicación)
```bash
cd nombre-proyecto
```
5. Ejecuta el proyecto:
```bash
php artisan serve
```

### Configuración del Proyecto

#### 1. Crearemos un Controlador para usuario (UserController.php)
En este controlador dejaremos todo lo realacionado a los usuarios del sistema, login, logout, listar, crear, editar, encender y apagar. Todas serán funciones, además tenemos que crear unas funciones propias para llamar a cada vista relacionada con la actividad a realizar.

```bash
php artisan make:controller UserController
```

##### 1.a showFormRegistro() en UserController.php

Nos permitirá acceder a la vista de registro, debemos colocar la misma organización de carpetas y archivo que tendremos cuando creemos la vista (es lo que va entre paréntesis). Como segundo parámetro van los datos a la vista.

Tendremos una variable $datos que nos permitirá pasar datos a la vista, inicialmente dejaremos una instrucción.

```php
use Illuminate\Support\Facades\Auth;
```

```php
public function showFormRegistro()
{
    if (Auth::check()) {
        // Verifica si el el usuario ya está autenticado
        return redirect()->route('/')->with('success', 'Tiene una sesión iniciada, ciérrela para crear una nueva.');
    }

    $datos = [
        'instruccion' => 'Registre Credenciales del nuevo usuario'
    ];
    return view('backoffice/users/registro', $datos);
}
```

##### 1.b Modificamos el controlador base (Controller.php)

Se deben validar los datos. Para personalizar el mensaje, entonces modificaremos el controlador extendido (Controller.php) para que contenga los mensajes.

El archivo Controller.php quedará de la siguiente manera:

```php
namespace App\Http\Controllers;

abstract class Controller
{
    // Mensajes personalizados para esta validación
    public $messages = [
        'username.unique' => 'Este nombre de usuario (email) ya está en uso. Por favor, elige otro.',
        // Puedes añadir más mensajes específicos si lo necesitas, por ejemplo:
        // 'name.required' => 'El campo Nombre es obligatorio.',
        // 'password.confirmed' => 'Las contraseñas no coinciden.',
    ];
}
```
##### 1.c guardarNuevo en UserController.php

1. Validamos los datos
2. Creamos el usuario con la función del modelo Create
3. Se redirige a la ruta definida

```php
use App\Models\User;  // Importar el modelo User
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;  // Importar la fachada Hash
use Illuminate\Validation\Rules\Password;  // Importar la clase Password
```
```php
public function guardarNuevo(Request $request)
{
    // 1. Validación de los datos del formulario
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'username' => ['required', 'string', 'lowercase', 'max:255', 'unique:' . User::class],
        'password' => ['required', 'confirmed', Password::defaults()],
    ], $this->messages);

    // 2. Creación del nuevo usuario en la base de datos
    $user = User::create([
        'name' => $request->name,
        'username' => $request->username,
        'password' => Hash::make($request->password),
    ]);

    // Opcional: Disparar el evento Registered si necesitas enviar correos de verificación, etc.
    // event(new Registered($user));

    // 3. Redirigir a la página de login con un mensaje de éxito
    return redirect()->route('/')->with('success', 'Usuario creado, debe iniciar sesión.');
}
```
##### 1.d showFormLogin en UserController.php

```php
public function showFormLogin()
{
    $datos = [
        'instruccion' => 'Ingrese Credenciales'
    ];

    if (Auth::check()) {
        // Si el usuario ya está autenticado, redirígelo a la página principal o dashboard
        return redirect()->route('/')->with('success', 'Tiene una sesión iniciada, ciérrela para iniciar una nueva.');
    }

    return view('backoffice/users/login', $datos);
}
```
##### 1.e login en UserController.php

Es la acción de loguear. Buscará el usuario en la base de datos y si cumple con las credenciales, entonces podrá ingresar. Si no lo encuentra, entonces nos muestra un error.

```php
public function login(Request $request)
{
    $credentials = $request->validate([
        'username' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        $user = Auth::user();

        return redirect()->route('/')->with('success', "Bienvenido {$user->name}, tiene una sesión iniciada exitosamente.");
    }

    return back()->withErrors([
        'username' => 'Las credenciales no coinciden con nuestros registros.',
    ])->onlyInput('username');
}
```

##### 1.f logout en UserController.php

Es la acción de desloguear. Cerrará la sesión eliminando el token actual.

```php
public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('/')->with('success', 'Sesión cerrada exitosamente.');
}
```

#### 2. Modificaremos el Modelo del Usuario

En el archivo app/Models/User.php

Modificamos:

```php
protected $fillable = [
    'name',
    'username',
    'password',
];
```
Agregamos a la clase:
```php
public function username()
{
    return 'username';
}
```

#### 3. Modificaremos el archivo de migraciones del usuario

En el archivo database/migrations/0001_01_01_000000_create_users_table.php

Modificamos en el método up:

```php
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('username')->unique();
    $table->timestamp('email_verified_at')->nullable();
    $table->string('password');
    $table->rememberToken();
    $table->timestamps();
});

Schema::create('password_reset_tokens', function (Blueprint $table) {
    $table->string('username')->primary();
    $table->string('token');
    $table->timestamp('created_at')->nullable();
});
```

#### 4. Crearemos las vistas del proyecto

Estos archivos son los que el usuario interactúa.

##### 4.a Vista index.php para la landing page

Creará la carpeta landing, donde dejaremos todos los archivos relacionados a la landing page.

```bash
php artisan make:view landing/index
```

Código del archivo index.blade.php

```php
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
</head>

<body class="container">
    <h1 class="text-primary">Landing Page</h1>
    <h3>Esta es una landing page...</h3>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @guest
        <a href="{{ route('user.form.show.login') }}" class="me-2">
            <button class="btn btn-primary">Iniciar Sesión</button>
        </a>
        <a href="{{ route('user.form.show.registro') }}">
            <button class="btn btn-primary">Crear Usuario</button>
        </a>
    @endguest
    {{-- Muestra este botón SI SÍ hay sesión iniciada (está "autenticado") --}}
    @auth
        <p>Hola, {{ Auth::user()->name }}!</p>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-danger">Cerrar Sesión</button>
        </form>
    @endauth

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
    </script>
</body>

</html>
```

##### 4.b Vista registro.php para la registrar usuarios

Creará la carpeta backoffice/users, donde dejaremos todos los archivos relacionados al usuario en el backoffice.

```bash
php artisan make:view backoffice/users/registro
```

Código del archivo registro.blade.php

```php
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
</head>
<body class="container">
    <h1 class="text-primary">{{ $instruccion }}</h1>
    @if ($errors->any())
        <div class="alert alert-danger"> {{-- O usa tus clases CSS para estilo (ej. text-red-500, bg-red-100) --}}
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('user.form.registro') }}" method="POST">
        @csrf
        <input type="text" class="mb-2 form-control" name="name" placeholder="Nombre" autofocus value="Sebastian">
        <input type="email" class="mb-2 form-control" name="username" placeholder="EMail" value="scabezas@ciisa.cl">
        <input type="password" class="mb-2 form-control" name="password" placeholder="Contraseña" value="holaMundo">
        <input type="password" class="mb-2 form-control" name="password_confirmation" placeholder="Repite la contraseña" value="holaMundo">
        <button type="submit" class="mb-2 btn btn-primary">Registrar nuevo usuario</button>
    </form>
    <a href="/">Volver a la raiz</a>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
    </script>
</body>
</html>
```

##### 4.c Vista login.php para el ingreso de los usuarios

Creará en la carpeta backoffice/users el archivo login.

```bash
php artisan make:view backoffice/users/login
```

Código del archivo login.blade.php

```php
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
</head>
<body class="container">
    <h3>{{ $instruccion }}</h3>
    @if (session('success'))
        <div class="alert alert-success mb-4">
            <ul>{{ session('success') }}</ul>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger"> {{-- O usa tus clases CSS para estilo (ej. text-red-500, bg-red-100) --}}
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form class="text-center" action="{{ route('user.form.login') }}" method="POST">
        @csrf
        <input type="email" class="mb-2 form-control" name="username" placeholder="Username" autofocus value="scabezas@ciisa.cl">
        <input type="password" class="mb-2 form-control" name="password" placeholder="******" value="holaMundo">
        <button type="submit" class="mb-2 btn btn-primary">Login</button>
    </form>
    <a href="/">Volver a la raiz</a>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
    </script>
</body>
</html>
```

#### 5. Rutas

El archivo routes/web.php contiene la información de acceso a las rutas que tendrá nuestra web. Podrá contener métodos get (para mostrar información) y post (para ingresar/modificar información).

El contenido del archivo es el siguiente:

```php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('landing/index');
})->name('/');

Route::get('/backoffice/login', [UserController::class, 'showFormLogin'])->name('user.form.show.login');
Route::post('/backoffice/login', [UserController::class, 'login'])->name('user.form.login');

Route::get('/backoffice/create-user', [UserController::class, 'showFormRegistro'])->name('user.form.show.registro');
Route::post('/backoffice/create-user', [UserController::class, 'guardarNuevo'])->name('user.form.registro');

Route::post('/backoffice/logout', [UserController::class, 'logout'])->name('logout');
```

### Configuración Extra en Studio Firebase

#### 1. Variable de entorno en archivo .env de la raiz del proyecto

Reemplazamos APP_URL=http://localhost por la url que nos entrega firebase studio

```env
APP_URL=https://9000-firebase-ipss-dwi-25-2-clases-1751379241939.cluster-etsqrqvqyvd4erxx7qq32imrjk.cloudworkstations.dev
```

### 2. ServiceProvider.php

Modificamos el archivo app/Providers/AppServiceProvider.php
la función boot debe quedar de esta manera:
```php
use Illuminate\Support\Facades\URL;
```
```php
public function boot(): void
{
    if (config('app.env') === 'local'){
        URL::forceRootUrl(config('app.url'));
        URL::forceScheme('https');
    }
}
```
### Configuración Base de datos

#### 1. Eliminar el archivo en database/database.sqlite

#### 2. Migrar la base de datos para que se cree

```bash
php artisan migrate
```

#### 2.1 En Windows

Volver a levantar Laravel

```bash
php artisan serve
```

#### Studio Firebase

Recargar la página de la URL del proyecto.


# Después de Clonar el repo

Instalar las dependencias de composer

```bash
composer install
```

Copiar el entorno

```bash
cp .env.example .env
```

Generar la llave

```bash
php artisan key:generate
```

Reemplazar la URL del entorno por la que nos entrega Firebase

https://9000-firebase-dwi-25-2-clases-1752585818839.cluster-qhrn7lb3szcfcud6uanedbkjnm.cloudworkstations.dev

Migrar la base de datos

```bash
php artisan migrate
```
Preguntará si queremos crear la base de datos sqlite, respondemos YES

----

# Incorporar Vuexy como template

## 1. Crear la carpeta vuexy en public

```bash
mkdir public/vuexy
```

## 2. Subir las carpetas comprimidas en vuexy

2.1 assets.zip
2.2 dist.zip
2.3 fonts.zip

## 3. En la consola descomprimir los archivos

```bash
unzip assets.zip
```
```bash
unzip dist.zip
```
```bash
unzip fonts.zip
```

## 4. Borrar los archivos .zip

```bash
rm assets.zip
```
```bash
rm dist.zip
```
```bash
rm fonts.zip
```
```bash
rm -rf __MACOSX
```

## Si ya tienen clonado el repositorio:

```bash
git pull
```
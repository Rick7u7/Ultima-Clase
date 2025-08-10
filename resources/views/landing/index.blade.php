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
    @include('backoffice/_partials/messages')
    @guest
        <a href="{{ route('user.form.show.login') }}" class="me-2">
            <button class="btn btn-primary">Iniciar Sesión</button>
        </a>
        <a href="{{ route('user.form.show.registro') }}">
            <button class="btn btn-primary">Crear Usuario</button>
        </a>
    @endguest
    {{-- Muestra este botón SI hay sesión iniciada (está "autenticado") --}}
    @auth
        <p>Hola, {{ Auth::user()->name }}!</p>
        <p><a href="{{ route('backoffice.dashboard')}}">Dashboard</a></p>
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

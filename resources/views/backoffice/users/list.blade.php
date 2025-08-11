@extends('backoffice._partials.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">👥 Lista de Usuarios</h4>

        <div class="card">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Nombre Completo</th>
                            <th>RUT</th>
                            <th>Rol</th>
                            <th>Activo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    @foreach ($users as $usuario)
                        <tr>
                            <td>{{ $usuario->name }} {{ $usuario->lastname }}</td>
                            <td>{{ $usuario->rut }}</td>
                            <td>{{ $usuario->rol->nombre ?? 'Sin rol' }}</td>
                            <td>
                                @if ($usuario->activo)
                                    <span class="badge bg-success">Activo</span>
                                @else
                                    <span class="badge bg-danger">Inactivo</span>
                                @endif
                            </td>
                            <td>
                                <a href="#" class="btn btn-sm btn-primary">Editar</a>
                                <a href="#" class="btn btn-sm btn-danger">Eliminar</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

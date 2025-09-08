@extends('backoffice._partials.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="mb-1">{{ $datos['mantenedor']['titulo'] }}</h4>
    <p class="mb-6">{{ $datos['mantenedor']['instruccion'] }}</p>

    @include('backoffice._partials.messages')

    <!-- Botón para agregar detalles -->
    <div class="d-flex justify-content-start mb-3">
        <button data-bs-target="#addRoleModal" data-bs-toggle="modal"
            class="btn btn-primary">
            + Agregar Detalles
        </button>
    </div>

    <!-- Tabla de Detalles del Recinto -->
<div class="card">
    <div class="card-datatable table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Ubicación</th>
                    <th>Tipo Superficie</th>
                    <th>Capacidad</th>
                    <th>Graderías</th>
                    <th>Vestidores</th>
                    <th>Baños</th>
                    <th>Estacionamiento</th>
                    <th>Estado</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @if ($lista->isEmpty())
                    <tr>
                        <td colspan="10" class="text-center">Sin Registros</td>
                    </tr>
                @else
                    @foreach ($lista as $item)
                        <tr>
                            <td class="text-center">{{ $item->id }}</td>
                            <td class="text-center">{{ $item->ubicacion }}</td>
                            <td class="text-center">{{ $item->tipo_superficie }}</td>
                            <td class="text-center">{{ $item->capacidad_espectadores }}</td>
                            <td class="text-center">{{ $item->graderias }}</td>
                            <td class="text-center">{{ $item->vestidores }}</td>
                            <td class="text-center">{{ $item->banos_publico }}</td>
                            <td class="text-center">{{ $item->estacionamiento }}</td>
                            <td class="text-center">
                                @if ($item->activo == 1)
                                    <span class="badge bg-success">Activo</span>
                                @else
                                    <span class="badge bg-danger">Desactivado</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($item->activo == 1)
                                    <!-- Botón desactivar -->
                                    <form action="{{ route($datos['mantenedor']['routes']['down'], $item->id) }}" 
                                          method="POST" class="d-inline-block">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="this.disabled=true; this.innerHTML='<i class=\'ti ti-loader spin\'></i>'; this.form.submit();">
                                            <i class="icon-base ti tabler-arrow-down"></i>
                                        </button>
                                    </form>
                                @else
                                    <!-- Botón activar -->
                                    <form action="{{ route($datos['mantenedor']['routes']['up'], $item->id) }}" 
                                          method="POST" class="d-inline-block">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-primary"
                                            onclick="this.disabled=true; this.innerHTML='<i class=\'ti ti-loader spin\'></i>'; this.form.submit();">
                                            <i class="icon-base ti tabler-arrow-up"></i>
                                        </button>
                                    </form>
                                @endif

                                <!-- Botón eliminar -->
                                <form action="{{ route($datos['mantenedor']['routes']['delete'], $item->id) }}" 
                                      method="POST" class="d-inline-block"
                                      onsubmit="return confirm('¿Está seguro de eliminar este detalle del recinto?')">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
<!--/ Tabla de Detalles del Recinto -->


    <!-- Modal para agregar detalles -->
    @component('backoffice._partials.modal', [
        'titulo' => $datos['mantenedor']['titulo'],
        'instruccion' => $datos['mantenedor']['instruccion'],
        'accion' => 'new',
        'ruta' => $datos['mantenedor']['routes']['new'],
        'campos' => $datos['mantenedor']['fields'],
    ])
    @endcomponent
</div>
@endsection

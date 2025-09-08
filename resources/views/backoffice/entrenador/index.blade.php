@extends('backoffice._partials.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="mb-1">{{ $datos['mantenedor']['titulo'] }}</h4>
    <p class="mb-6">{{ $datos['mantenedor']['instruccion'] }}</p>

    @include('backoffice._partials.messages')

    <!-- Botón para agregar género -->
    <div class="d-flex justify-content-start mb-3">
        <button data-bs-target="#addRoleModal" data-bs-toggle="modal"
            class="btn btn-primary">
            + Agregar Datos
        </button>
    </div>

    <!-- Tabla de Entrenadores -->
    <div class="card">
        <div class="card-datatable table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nombre del Entrenador</th>
                        <th>Edad</th>
                        <th>Genero</th>
                        <th>telefono</th>
                        <th>correo</th>
                        <th>direccion</th>
                        <th>Nivel</th>
                        <th>Estado</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($lista->isEmpty())
                        <tr>
                            <td colspan="5" class="text-center">Sin Registros</td>
                        </tr>
                    @else
                        @foreach ($lista as $item)
                            <tr>
                            <td class="text-center">{{ $item->id }}</td>
                            <td class="text-center">
                                {{ $item->persona?->user?->name }} {{ $item->persona?->user?->lastname }}
                            </td>
                            <td class="text-center">{{ $item->persona?->edad ?? '—' }}</td>
                            <td class="text-center">{{ $item->persona?->genero?->nombre ?? 'Sin género' }}</td>
                            <td class="text-center">{{ $item->persona?->telefono ?? '—' }}</td>
                            <td class="text-center">{{ $item->persona?->correo ?? '—' }}</td>
                            <td class="text-center">{{ $item->persona?->direccion ?? '—' }}</td>
                            <td class="text-center">
                                @switch($item->nivel)
                                    @case(1)
                                        Principiante
                                        @break
                                    @case(2)
                                        Intermedio
                                        @break
                                    @case(3)
                                        Avanzado
                                        @break
                                    @default
                                        —
                                @endswitch
                            </td>
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
</td>

                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <!--/ Tabla de Entrenadores -->

    <!-- Modal para agregar entrenadores -->
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

@push('scripts')
<script>
    const rutaCrear = "{{ route('backoffice.entrenador.store') }}";

    document.addEventListener('DOMContentLoaded', function () {
        const editButtons = document.querySelectorAll('.btn-edit-entrenador');
        const form = document.getElementById('form-detalles');
        const methodContainer = document.getElementById('method-edit');
        const submitBtn = document.getElementById('btn-submit-detalle');

        editButtons.forEach(button => {
            button.addEventListener('click', function () {
                form.querySelector('[name="entrenador"]').value = this.dataset.entrenador;
                form.querySelector('[name="nombre"]').value = this.dataset.nombre;

                form.action = `/backoffice/entrenador/${this.dataset.id}`;
                methodContainer.innerHTML = '<input type="hidden" name="_method" value="PUT">';
                submitBtn.textContent = 'Actualizar';
            });
        });

        document.querySelector('[data-bs-target="#addRoleModal"]').addEventListener('click', function () {
            form.reset();
            form.action = rutaCrear;
            methodContainer.innerHTML = '';
            submitBtn.textContent = 'Guardar';
        });
    });
</script>
@endpush

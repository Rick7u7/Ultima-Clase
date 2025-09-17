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
                    <th>ID</th> <!-- ID del entrenador -->
                    <th>Nombre</th> <!-- name + lastname -->
                    <th>RUT</th> <!-- rut del usuario -->
                    <th>Fecha de Nacimiento</th> <!-- fechaNacimiento -->
                    <th>Edad</th> <!-- edad del entrenador -->
                    <th>Género</th> <!-- genero.nombre -->
                    <th>Cargo</th> <!-- cargoId (puede mapearse a nombre si tenés relación) -->
                    <th>Teléfono</th> <!-- telefono desde Persona -->
                    <th>Correo</th> <!-- correo desde Persona -->
                    <th>Dirección</th> <!-- dirección desde Persona -->
                    <th>Nacionalidad</th> <!-- nacionalidad desde Persona -->
                    <th>Certificaciones</th> <!-- Certificaciones de Entrenador -->
                    <th>Nivel</th> <!-- nivel desde Entrenador -->
                    <th>Estado</th> <!-- activo desde Entrenador -->
                    <th class="text-center">Acciones</th> <!-- activar/desactivar -->
                </tr>
            </thead>
            <tbody>
                @forelse ($lista as $item)
                    <tr>
                        <td class="text-center">{{ $item->id }}</td>
                        <td class="text-center">
                            {{ $item->persona->user->name ?? '—' }} {{ $item->persona->user->lastname ?? '' }}
                        </td>
                        <td class="text-center">{{ $item->persona->user->rut ?? '—' }}</td>
                        <td class="text-center">{{ $item->persona->user->fechaNacimiento ?? '—' }}</td>
                        <td class="text-center">{{ $item->persona->edad }}</td>
                        <td class="text-center">{{ $item->persona->user->genero?->nombre ?? 'Sin género' }}</td>
                        <td class="text-center">{{ $item->persona->user->cargo?->nombre ?? $item->persona->user->cargoId ?? '—' }}</td>
                        <td class="text-center">{{ $item->persona->telefono ?? '—' }}</td>
                        <td class="text-center">{{ $item->persona->correo ?? '—' }}</td>
                        <td class="text-center">
                            {{ $item->persona->direccion ?? '—' }} {{ $item->persona->comuna?->nombre ?? '—' }}
                        </td>
                        <td class="text-center">{{ $item->persona->nacionalidad?->nombre ?? '—' }}</td>
                        <td class="text-center">
                            @if(is_array($item->certificacion) && count($item->certificacion))
                                @foreach($item->certificacion as $codigo)
                                    <span class="badge bg-primary me-1">
                                        {{ $certificacionesMap[(string) $codigo] ?? '—' }}
                                    </span>
                                @endforeach
                            @else
                                <span class="text-muted">Sin certificaciones</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @switch($item->nivel)
                                @case(1) Principiante @break
                                @case(2) Intermedio @break
                                @case(3) Avanzado @break
                                @default —
                            @endswitch
                        </td>
                        <td class="text-center">
                            <span class="badge {{ $item->activo ? 'bg-success' : 'bg-danger' }}">
                                {{ $item->activo ? 'Activo' : 'Desactivado' }}
                            </span>
                        </td>
                        <td class="text-center">
                            <form action="{{ route($datos['mantenedor']['routes'][$item->activo ? 'down' : 'up'], $item->id) }}" 
                                method="POST" class="d-inline-block">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $item->activo ? 'btn-danger' : 'btn-primary' }}"
                                    onclick="this.disabled=true; this.innerHTML='<i class=\'ti ti-loader spin\'></i>'; this.form.submit();">
                                    <i class="icon-base ti {{ $item->activo ? 'tabler-arrow-down' : 'tabler-arrow-up' }}"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="14" class="text-center">Sin Registros</td>
                    </tr>
                @endforelse
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

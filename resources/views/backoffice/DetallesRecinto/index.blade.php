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

    <!-- Tabla de detalles -->
    <div class="card">
        <div class="card-datatable p-3">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Ubicación</th>
                        <th>Tipo Superficie</th>
                        <th>Capacidad</th>
                        <th>Graderías</th>
                        <th>Vestidores</th>
                        <th>Baños</th>
                        <th>Estacionamiento</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lista as $detalle)
                        <tr>
                            <td>{{ $detalle->ubicacion }}</td>
                            <td>{{ $detalle->tipo_superficie }}</td>
                            <td>{{ $detalle->capacidad_espectadores }}</td>
                            <td>{{ $detalle->graderias }}</td>
                            <td>{{ $detalle->vestidores }}</td>
                            <td>{{ $detalle->banos_publico }}</td>
                            <td>{{ $detalle->estacionamiento }}</td>
                            <td>
                                <button type="button" 
                                    class="btn btn-warning btn-sm btn-edit-detalle" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#addRoleModal"
                                    data-id="{{ $detalle->id }}"
                                    data-ubicacion="{{ $detalle->ubicacion }}"
                                    data-tipo_superficie="{{ $detalle->tipo_superficie }}"
                                    data-capacidad="{{ $detalle->capacidad_espectadores }}"
                                    data-graderias="{{ $detalle->graderias }}"
                                    data-vestidores="{{ $detalle->vestidores }}"
                                    data-banos="{{ $detalle->banos_publico }}"
                                    data-estacionamiento="{{ $detalle->estacionamiento }}">
                                    Editar
                                </button>
                                <form action="{{ route('backoffice.detallesrecinto.destroy', $detalle->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal para agregar/editar detalles -->
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
    const rutaCrear = "{{ route('backoffice.detallesrecinto.store') }}";

    document.addEventListener('DOMContentLoaded', function () {
        const editButtons = document.querySelectorAll('.btn-edit-detalle');
        const form = document.getElementById('form-detalles');
        const methodContainer = document.getElementById('method-edit');
        const submitBtn = document.getElementById('btn-submit-detalle');

        editButtons.forEach(button => {
            button.addEventListener('click', function () {
                form.querySelector('[name="ubicacion"]').value = this.dataset.ubicacion;
                form.querySelector('[name="tipo_superficie"]').value = this.dataset.tipo_superficie;
                form.querySelector('[name="capacidad_espectadores"]').value = this.dataset.capacidad;
                form.querySelector('[name="graderias"]').value = this.dataset.graderias;
                form.querySelector('[name="vestidores"]').value = this.dataset.vestidores;
                form.querySelector('[name="banos_publico"]').value = this.dataset.banos;
                form.querySelector('[name="estacionamiento"]').value = this.dataset.estacionamiento;

                // Ruta de actualización con método PUT
                form.action = `/backoffice/detalles-recinto/${this.dataset.id}`;
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

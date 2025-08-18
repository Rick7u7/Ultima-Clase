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
            + Agregar Género
        </button>
    </div>

    <!-- Tabla de géneros -->
    <div class="card">
        <div class="card-datatable p-3">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Icono</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lista as $genero)
                        <tr>
                            <td>{{ $genero->icono }}</td>
                            <td>{{ $genero->nombre }}</td>
                            <td>
                                <button type="button" 
                                    class="btn btn-warning btn-sm btn-edit-genero" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#addRoleModal"
                                    data-id="{{ $genero->id }}"
                                    data-nombre="{{ $genero->nombre }}"
                                    data-icono="{{ $genero->icono }}">
                                    Editar
                                </button>
                                <form action="{{ route('backoffice.genero.destroy', $genero->id) }}" method="POST" style="display:inline;">
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

    <!-- Modal para agregar/editar género -->
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
    const rutaCrear = "{{ route('backoffice.genero.store') }}";

    document.addEventListener('DOMContentLoaded', function () {
        const editButtons = document.querySelectorAll('.btn-edit-genero');
        const form = document.getElementById('form-detalles'); // sigue siendo el mismo ID
        const methodContainer = document.getElementById('method-edit');
        const submitBtn = document.getElementById('btn-submit-detalle');

        editButtons.forEach(button => {
            button.addEventListener('click', function () {
                form.querySelector('[name="icono"]').value = this.dataset.icono;
                form.querySelector('[name="nombre"]').value = this.dataset.nombre;

                form.action = `/backoffice/genero/${this.dataset.id}`;
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

@extends('backoffice._partials.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="mb-1">{{ $datos['mantenedor']['titulo'] }}</h4>
    <p class="mb-6">{{ $datos['mantenedor']['instruccion'] }}</p>

    @include('backoffice._partials.messages')

    <!-- Tabla de Saldos por Jugador -->
    <div class="card">
        <div class="card-datatable table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nombre Completo</th>
                        <th>Saldo</th>
                        <th>Estado</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($lista as $jugador)
                    @php
                        $usuario = $jugador->persona->user;
                        $cargoNombre = optional($usuario->cargo)->nombre;
                        $saldo = optional($jugador->persona->saldo);
                        $estado = $saldo->estado ?? 'sin saldo';
                        $monto = $saldo->monto ?? 0;
                    @endphp

                    @if ($cargoNombre !== 'Jugador')
                        @continue
                    @endif

                    <tr>
                        <td class="text-center">{{ $usuario->id }}</td>
                        <td>{{ $usuario->name }} {{ $usuario->lastname }}</td>
                        <td class="text-center">${{ number_format($monto, 0, ',', '.') }}</td>
                        <td class="text-center">
                            @switch($estado)
                                @case('pagado')
                                    <span class="badge bg-success">Pagado</span>
                                    @break
                                @case('pendiente')
                                    <span class="badge bg-warning text-dark">Pendiente</span>
                                    @break
                                @case('atrasado')
                                    <span class="badge bg-danger">Atrasado</span>
                                    @break
                                @default
                                    <span class="badge bg-secondary">Sin saldo</span>
                            @endswitch
                        </td>
                        <td class="text-center">
                            @if ($saldo)
                            <button 
                                type="button" 
                                class="btn btn-sm btn-primary btn-editar-saldo" 
                                data-bs-toggle="modal" 
                                data-bs-target="#addRoleModal"
                                data-id="{{ $saldo->id }}"
                                data-monto="{{ $saldo->monto }}"
                                data-estado="{{ $saldo->estado }}"
                            >
                                Editar
                            </button>
                            @else
                                <span class="text-muted">Sin saldo</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Sin jugadores registrados</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal único para editar saldo -->
    @component('backoffice._partials.modal', [
        'titulo' => $datos['mantenedor']['titulo'],
        'instruccion' => $datos['mantenedor']['instruccion'],
        'accion' => 'update',
        'ruta' => '/__placeholder__',
        'campos' => collect($datos['mantenedor']['fields'])->map(function ($campo) {
            $campo['value'] = '';
            return $campo;
        })->toArray()
    ])
    @endcomponent
</div>

<!-- Script para rellenar el modal dinámicamente -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const botones = document.querySelectorAll('.btn-editar-saldo');
    const form = document.querySelector('#addRoleModal form');
    const campoMonto = document.getElementById('monto');
    const campoEstado = document.getElementById('estado');

    botones.forEach(boton => {
        boton.addEventListener('click', function () {
            const id = this.dataset.id;
            const monto = this.dataset.monto;
            const estado = this.dataset.estado;

            if (campoMonto) campoMonto.value = monto;
            if (campoEstado) campoEstado.value = estado;

            // Reemplazar la URL falsa por la real
            form.action = `/backoffice/saldo/${id}`;
        });
    });
});
</script>
@endsection

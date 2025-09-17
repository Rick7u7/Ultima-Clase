@extends('backoffice._partials.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="mb-1">{{ $datos['mantenedor']['titulo'] }}</h4>
    <p class="mb-6">{{ $datos['mantenedor']['instruccion'] }}</p>

    @include('backoffice._partials.messages')

    <!-- Tabla de jugadores con saldos desplegables -->
    <div class="card">
        <div class="card-datatable table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nombre Completo</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($lista as $persona)
                    @php
                        $usuario = $persona->user;
                        $cargoNombre = optional($usuario->cargo)->nombre;
                    @endphp

                    @if ($cargoNombre !== 'Jugador')
                        @continue
                    @endif

                    <tr data-bs-toggle="collapse" data-bs-target="#saldos-{{ $persona->id }}" class="cursor-pointer">
                        <td class="text-center">{{ $usuario->id }}</td>
                        <td>{{ $usuario->name }} {{ $usuario->lastname }}</td>
                        <td class="text-center">
                            <button 
                                type="button" 
                                class="btn btn-sm btn-success btn-crear-saldos" 
                                data-bs-toggle="modal" 
                                data-bs-target="#addRoleModal"
                                data-persona="{{ $persona->id }}"
                            >
                                Nuevo saldo
                            </button>
                        </td>
                    </tr>

                    <tr class="collapse bg-light" id="saldos-{{ $persona->id }}">
                        <td colspan="3">
                            <table class="table table-sm mb-0">
                                <thead>
                                    <tr>
                                        <th>Mes</th>
                                        <th>Año</th>
                                        <th>Monto</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($persona->saldos as $saldo)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::create()->month($saldo->mes)->translatedFormat('F') }}</td>
                                            <td>{{ $saldo->año }}</td>
                                            <td>${{ number_format($saldo->monto, 0, ',', '.') }}</td>
                                            <td>
                                                <span class="badge 
                                                    @switch($saldo->estado)
                                                        @case('pagado') bg-success @break
                                                        @case('pendiente') bg-warning text-dark @break
                                                        @case('atrasado') bg-danger @break
                                                        @default bg-secondary
                                                    @endswitch">
                                                    {{ ucfirst($saldo->estado) }}
                                                </span>
                                            </td>
                                            <td>
                                                <button 
                                                    type="button" 
                                                    class="btn btn-sm btn-primary btn-editar-saldos" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#addRoleModal"
                                                    data-id="{{ $saldo->id }}"
                                                    data-monto="{{ $saldo->monto }}"
                                                    data-estado="{{ $saldo->estado }}"
                                                    data-mes="{{ $saldo->mes }}"
                                                    data-año="{{ $saldo->año }}"
                                                >
                                                    Editar
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="5">Sin saldos registrados.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-center">Sin jugadores registrados</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal único para crear/editar saldo -->
    @component('backoffice._partials.modal', [
        'titulo' => $datos['mantenedor']['titulo'],
        'instruccion' => $datos['mantenedor']['instruccion'],
        'accion' => null,
        'ruta' => 'backoffice.saldos.new',
        'campos' => array_merge([
            ['name' => 'persona_id', 'type' => 'hidden', 'value' => '']
        ], collect($datos['mantenedor']['fields'])->map(function ($campo) {
            $campo['value'] = '';
            return $campo;
        })->toArray())
    ])
    @endcomponent
</div>

<!-- Script para controlar el modal dinámicamente -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('#addRoleModal form');
    const campoMonto = document.getElementById('monto');
    const campoEstado = document.getElementById('estado');
    const campoPersona = document.getElementById('persona_id');
    const campoMes = document.getElementById('mes');
    const campoAño = document.getElementById('año');

    // Crear nuevo saldo
    document.querySelectorAll('.btn-crear-saldos').forEach(boton => {
        boton.addEventListener('click', function () {
            const personaId = this.dataset.persona;

            // Limpieza general
            form.reset();

            // Asignar valores por defecto
            if (campoMonto) campoMonto.value = '';
            if (campoEstado) campoEstado.value = 'pendiente';
            if (campoMes) campoMes.value = '';
            if (campoAño) campoAño.value = '';
            if (campoPersona) campoPersona.value = personaId;

            // Configurar acción y método
            form.action = `/backoffice/saldo`;
            form.method = 'POST';

            // Eliminar cualquier método PUT residual
            const methodInput = form.querySelector('input[name="_method"]');
            if (methodInput) methodInput.remove();
        });
    });

    // Editar saldo existente
    document.querySelectorAll('.btn-editar-saldos').forEach(boton => {
        boton.addEventListener('click', function () {
            const id = this.dataset.id;
            const monto = this.dataset.monto;
            const estado = this.dataset.estado;
            const mes = this.dataset.mes;
            const año = this.dataset.año;

            // Asignar valores del saldo
            if (campoMonto) campoMonto.value = monto;
            if (campoEstado) campoEstado.value = estado;
            if (campoMes) campoMes.value = mes;
            if (campoAño) campoAño.value = año;
            if (campoPersona) campoPersona.value = '';

            // Configurar acción y método
            form.action = `/backoffice/saldo/${id}`;
            form.method = 'POST';

            // Eliminar método anterior si existe
            const oldMethod = form.querySelector('input[name="_method"]');
            if (oldMethod) oldMethod.remove();

            // Inyectar método PUT
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'PUT';
            form.appendChild(methodInput);
        });
    });
});
</script>
@endsection

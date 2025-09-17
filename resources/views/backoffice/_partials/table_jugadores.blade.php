@props(['lista', 'datos'])

<div class="table-responsive">
    <table class="datatables-users table border-top">
        <thead>
            <tr>
                <th>ID</th>
                <th>RUT</th>
                <th>Nombre</th>
                <th>Apellido</th>
                {{-- <th>F. Nacimiento</th> --}}
                <th>Edad </th>
                <th>Género</th>
                <th>Nacionalidad</th>
                <th>Posiciones de Juego</th>
                <th>Pierna Dominante</th>
                <th>Dorsal</th>
                {{-- <th>Comuna</th> --}}
                {{-- <th>Direccion</th> --}}
                <th>Oficio</th>
                {{-- <th>Medio de contacto</th> --}}
                {{-- <th>Cargo</th> --}}
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($lista as $jugador)
                <tr>
                    <td class="text-center">{{ $jugador->persona?->user?->id ?? 'N/A' }}</td>
                    <td class="text-center">{{ $jugador->persona?->user?->rut ?? 'N/A' }}</td>
                    <td>{{ $jugador->persona?->user?->name ?? 'N/A' }}</td>
                    <td>{{ $jugador->persona?->user?->lastname ?? 'N/A' }}</td>

                    {{-- 
<td>
    {{ $jugador->persona?->user?->fechaNacimiento
        ? \Carbon\Carbon::parse($jugador->persona->user->fechaNacimiento)->format('d-m-Y')
        : 'N/A' }}
</td>
--}}
                    <td>{{ $jugador->persona?->edad ?? 'N/A' }}</td>

                    <td>
                        {{ $jugador->persona?->user?->genero?->nombre ?? 'N/A' }}
                    </td>

                    <td>{{ $jugador->persona?->nacionalidad?->nombre ?? 'N/A' }}</td>



                    <td>
                        {{ $jugador->posicion?->nombre ?? 'N/A' }}
                        {{-- Si usas belongsToMany --}}
                        {{-- {{ $jugador->posiciones?->pluck('nombre')->implode(', ') ?? 'N/A' }} --}}
                    </td>
                    <td>{{ $jugador->piernaDominante?->nombre ?? 'N/A' }}</td>

                    <td>{{ $jugador->camisetas?->nombre ?? 'N/A' }}</td>
                    {{-- <td>{{ $jugador->persona?->comuna?->nombre ?? 'N/A' }}</td> --}}
                    {{-- <td>{{ $jugador->persona?->direccion ?? 'N/A' }}</td> --}}
                    <td>{{ $jugador->persona?->oficio?->nombre ?? 'N/A' }}</td>
                    {{-- <td>{{ $jugador->persona?->medioContacto?->nombre ?? 'N/A' }}</td> --}}
                    {{-- <td>{{ $jugador->persona?->user?->cargo?->nombre ?? 'N/A' }}</td> --}}
                    <td class="text-center">
                        @if ($jugador->activo == 1)
                            <span class="text-success">Activo</span>
                        @else
                            <span class="text-danger">Desactivado</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <!-- Botones de acción -->
                        @if ($jugador->activo == 1)
                            <form action="{{ route($datos['mantenedor']['routes']['down'], $jugador->id) }}"
                                method="POST" class="d-inline-block">
                                @csrf
                                <button type="submit" class="btn btn-danger">
                                    <i class="icon-base ti tabler-arrow-down"></i>
                                </button>
                            </form>
                        @endif

                        @if ($jugador->activo == 0)
                            <form action="{{ route($datos['mantenedor']['routes']['up'], $jugador->id) }}"
                                method="POST" class="d-inline-block">
                                @csrf
                                <button type="submit" class="btn btn-primary">
                                    <i class="icon-base ti tabler-arrow-up"></i>
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="15" class="text-center">Sin Registros</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<style>
    /* Scroll horizontal responsivo */
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        /* Smooth scrolling en iOS */
    }

    /* Columna de acciones fija al lado derecho */
    .sticky-actions {
        position: sticky;
        right: 0;
        background-color: #fff;
        z-index: 10;
        box-shadow: -2px 0 4px rgba(0, 0, 0, 0.1);
    }

    /* Evitar que el texto se rompa en las celdas */
    .datatables-users th,
    .datatables-users td {
        white-space: nowrap;
    }
</style>
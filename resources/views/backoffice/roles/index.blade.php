@extends('backoffice._partials.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="mb-1">{{$datos['mantenedor']['titulo']}}</h4>

        <p class="mb-6">
            {{$datos['mantenedor']['instruccion']}}
        </p>
        <!-- Role cards -->
        <div class="row g-6">
        @foreach ($roles as $rol)
    <div class="col-xl-4 col-lg-6 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="fw-normal mb-0 text-body">
                        Total {{ $rol->usuarios->count() }} usuarios
                    </h6>
                    <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
                        @foreach ($rol->usuarios->take(4) as $usuario)
                            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                title="{{ $usuario->name }}" class="avatar pull-up">
                                <img class="rounded-circle"
                                     src="{{ $usuario->avatar_url ?? '/vuexy/assets/img/avatars/default.png' }}"
                                     alt="Avatar" />
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="d-flex justify-content-between align-items-end">
                    <div class="role-heading">
                        <h5 class="mb-1">{{ $rol->nombre }}</h5>
                        <a href="javascript:;" data-bs-toggle="modal"
                           data-bs-target="#editRoleModal-{{ $rol->id }}"
                           class="role-edit-modal"><span>Editar Rol</span></a>
                    </div>
                    <a href="javascript:void(0);">
                        <i class="icon-base ti tabler-copy icon-md text-heading"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endforeach

            
            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="card h-100">
                    <div class="row h-100">
                        <div class="col-sm-5">
                            <div class="d-flex align-items-end h-100 justify-content-center mt-sm-0 mt-4">
                                <img src="/vuexy/assets/img/illustrations/add-new-roles.png" class="img-fluid"
                                    alt="Image" width="100" />
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="card-body text-sm-end text-center ps-sm-0">
                                <button data-bs-target="#addRoleModal" data-bs-toggle="modal"
                                    class="btn btn-sm btn-primary mb-4 text-nowrap add-new-role">
                                    Add New Role
                                </button>
                                <p class="mb-0">
                                    Add new role, <br />
                                    if it doesn't exist.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <h4 class="mt-6 mb-1">Total users with their roles</h4>
                <p class="mb-0">Find all of your company’s administrator accounts and their associate roles.</p>
            </div>
            <div class="col-12">
                <!-- Role Table -->
                <div class="card">
                    <div class="card-datatable">
                        <table class="datatables-users table border-top">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($lista))
                                    <tr>
                                        <td colspan="4" class="text-center">Sin Registros</td>
                                    </tr>
                                @else
                                    
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--/ Role Table -->
            </div>
        </div>
        <!--/ Role cards -->

        <!-- Add Role Modal -->
        <!-- Add Role Modal -->
        @component('backoffice._partials.modal', [
            'titulo' => 'Agregar Nuevo Rol',
            'instruccion' => 'Agregue todo lo que sale... por favor...',
            'campos' => $datos['mantenedor']['fields'] ?? []
        ])
            
        @endcomponent
        <!--/ Add Role Modal -->

        <!-- / Add Role Modal -->
    </div>
@endsection

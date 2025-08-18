@props(['titulo', 'instruccion', 'accion', 'ruta', 'campos'])
<div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-dialog-centered modal-add-new-role">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                <div class="text-center mb-6">
                    <h4 class="role-title">{{ $titulo }}</h4>
                    <p class="text-body-secondary">{{ $instruccion }}</p>
                </div>

                <hr>

                <form action="{{ $ruta }}" method="post" id="form-detalles">
                    @csrf
                    <div id="method-edit"></div> <!-- Aquí insertaremos @method('PUT') dinámicamente -->
                    @foreach ($campos as $campo)
                        @switch($campo['control']['element'])
                            @case('input')
                                <label class="form-label" for="{{ $campo['name'] }}">{{ $campo['label'] }}</label>
                                <input 
                                    type="{{ $campo['control']['type'] }}" 
                                    name="{{ $campo['name'] }}"
                                    id="{{ $campo['name'] }}"
                                    value="{{ $campo['value'] ?? ($campo['control']['type'] === 'number' ? 0 : '') }}"
                                    class="form-control mb-3 
                                        @if(isset($campo['control']['classList'])) 
                                            @foreach ($campo['control']['classList'] as $class){{ $class }} @endforeach 
                                        @endif"
                                    placeholder="{{ $campo['control']['placeholder'] ?? '' }}"
                                    @if(isset($campo['control']['min'])) min="{{ $campo['control']['min'] }}" @endif
                                    @if(isset($campo['control']['max'])) max="{{ $campo['control']['max'] }}" @endif>
                                @break
                            @case('select')
                                <label class="form-label" for="{{ $campo['name'] }}">{{ $campo['label'] }}</label>
                                <select 
                                    name="{{ $campo['name'] }}" 
                                    id="{{ $campo['name'] }}" 
                                    class="form-select mb-4">
                                    @foreach($campo['control']['options'] as $option)
                                        <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                                @break
                        @endswitch
                    @endforeach

                    <hr>

                    <button type="submit" class="btn btn-primary" id="btn-submit-detalle">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>

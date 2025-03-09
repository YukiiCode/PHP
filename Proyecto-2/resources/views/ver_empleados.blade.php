@extends('plantilla')
@section('titulo', 'Listado de Empleados')
@section('contenido')
<div class="container-fluid p-4">
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white py-3">
            <h3 class="card-title mb-0 fs-4 fw-bold"><i class="fas fa-users me-2"></i>Gestión de Empleados</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
            <table class="table table-striped table-hover align-middle mb-0">
                <thead class="table-light align-middle">
                    <tr class="fs-7 text-uppercase">
                        <th class="ps-3">Nombre</th>
                        <th>DNI</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Tipo</th>
                        <th class="text-center" style="width: 150px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($empleados as $empleado)
                    <tr>
                        <td class="ps-3">{{ $empleado->nombre }}</td>
                        <td>{{ $empleado->dni }}</td>
                        <td>{{ $empleado->correo }}</td>
                        <td>{{ $empleado->telefono }}</td>
                        <td>{{ $empleado->tipo }}</td>
                        <td>
                            <div class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('empleados.edit', $empleado->id) }}" class="btn btn-outline-primary btn-sm" data-toggle="tooltip" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('empleados.destroy', $empleado->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Eliminar empleado?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

@if($empleados->hasPages())
<div class="d-flex justify-content-center mt-3">
    {{ $empleados->appends(request()->except('page'))->links() }}
</div>
@endif

<style>
.hidden-row { padding: 0 !important; }
.table-hover tbody tr:hover { background-color: #f8f9fa; }
</style>
@endsection
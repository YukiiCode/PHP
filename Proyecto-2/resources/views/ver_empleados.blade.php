@extends('plantilla')



@section('contenido')
<div class="container mt-5">
    <h2 class="text-center mb-4">Listado de Empleados</h2>
    
    <div class="card">
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>DNI</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Tipo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($empleados as $empleado)
                    <tr>
                        <td>{{ $empleado->nombre }}</td>
                        <td>{{ $empleado->dni }}</td>
                        <td>{{ $empleado->correo }}</td>
                        <td>{{ $empleado->telefono }}</td>
                        <td>{{ $empleado->tipo }}</td>
                        <td>
                            <a href="{{ route('empleados.edit', $empleado->id) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('empleados.destroy', $empleado->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar empleado?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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
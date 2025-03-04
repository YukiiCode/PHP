@extends('plantilla')

@section('contenido')
<div class="container mt-4">
    <h2 class="mb-4">Listado de Empleados</h2>
    
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead class="thead-dark">
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
                        <button class="btn btn-sm btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#details-{{ $empleado->id }}">
                            ▼ Detalles
                        </button>
                        <a href="{{ route('empleados.edit', $empleado->id) }}" class="btn btn-sm btn-warning">
                            ✏️ Editar
                        </a>
                    </td>
                </tr>
                <tr>
                    <td colspan="6" class="collapse" id="details-{{ $empleado->id }}">
                        <div class="p-3 bg-light">
                            <p>Correo: {{ $empleado->correo }}</p>
                            <p>Dirección: {{ $empleado->direccion }}</p>
                            <p>Fecha Alta: {{ optional($empleado->fecha_alta)->format('d/m/Y') }}</p>
                            <p>Tiempo en la empresa: {{ optional($empleado->fecha_alta)->diffForHumans() }}</p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="5" class="hidden-row">
                        <div id="detalles{{$empleado->id}}" class="collapse">
                            <p><strong>DNI:</strong> {{$empleado->dni}}</p>
                            <p><strong>Dirección:</strong> {{$empleado->direccion}}</p>
                            <p><strong>Fecha Alta:</strong> {{ optional($empleado->fecha_alta)->format('d/m/Y') }}</p>
                            <p><strong>Tipo:</strong> {{$empleado->tipo}}</p>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>



<style>
.hidden-row { padding: 0 !important; }
.table-hover tbody tr:hover { background-color: #f8f9fa; }
</style>
@endsection
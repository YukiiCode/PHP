@extends('plantilla')

@section('contenido')
<div class="container mt-4">
    <h2 class="mb-4">Listado de Empleados</h2>
    
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($empleados as $empleado)
                <tr data-toggle="collapse" data-target="#detalles{{$empleado->id}}" style="cursor: pointer;">
                    <td>{{$empleado->nombre}}</td>
                    <td>{{$empleado->apellidos}}</td>
                    <td>{{$empleado->email}}</td>
                    <td>{{$empleado->telefono}}</td>
                    <td>
                        <div class="btn-group" role="group">
                            <a href="{{ route('empleados.edit', $empleado->id) }}" class="btn btn-primary btn-sm me-1">Editar</a>
                            <form action="{{route('empleados.destroy', $empleado->id)}}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar empleado?')">Eliminar</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="5" class="hidden-row">
                        <div id="detalles{{$empleado->id}}" class="collapse">
                            <p><strong>Dirección:</strong> {{$empleado->direccion}}</p>
                            <p><strong>Fecha Nacimiento:</strong> {{$empleado->fecha_nacimiento}}</p>
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
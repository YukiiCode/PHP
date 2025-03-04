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
                <tr data-toggle="collapse" data-target="#detalles{{$empleado->id}}" style="cursor: pointer;">
                    <td>{{$empleado->nombre}}</td>
                    <td>{{$empleado->dni}}</td>
                    <td>{{$empleado->correo}}</td>
                    <td>{{$empleado->telefono}}</td>
                    <td>{{$empleado->tipo}}</td>
                    <td>
                        <form action="{{route('empleados.destroy', $empleado->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm ml-1" onclick="return confirm('¿Eliminar empleado?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
                <tr>
                    <td colspan="5" class="hidden-row">
                        <div id="detalles{{$empleado->id}}" class="collapse">
                            <p><strong>DNI:</strong> {{$empleado->dni}}</p>
                            <p><strong>Dirección:</strong> {{$empleado->direccion}}</p>
                            <p><strong>Fecha Alta:</strong> {{$empleado->fecha_alta}}</p>
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
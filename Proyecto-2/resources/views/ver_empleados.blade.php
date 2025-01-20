@extends('plantilla')

@section('titulo', 'Listado de Empleados')

@section('contenido')
<div class="container mt-5">
    <h2 class="text-center mb-4">Lista de Empleados</h2>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Fecha de Contratación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($empleados as $empleado)
            <tr>
                <td>{{ $empleado->nombre }}</td>
                <td>{{ $empleado->tipo }}</td>
                <td>{{ $empleado->fecha_contratacion }}</td>
                <td>
                    <a href="" class="btn btn-primary btn-sm">Editar</a>
                    <a href="{{ route('borrar-empleado', ['id' => $empleado->id]) }}" class="btn btn-danger btn-sm">Eliminar</a>
                    <!-- Desplegable con mas datos -->
                    <div class="btn-group">
                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width: 60px;">
                            <a style="text-decoration: none; color:white"
                                href="@if (request()->query('id') == $empleado->id) {{ route('ver-empleados', ['page'=> request()->query('page')]) }} @else {{ route('ver-empleados', ['id'=>$empleado->id, 'page'=>request()->query('page')]) }} @endif">
                                @if (request()->query('id') == $empleado->id)
                                Menos
                                @else
                                Más
                                @endif
                            </a>
                        </button>
                    </div>

            <tr @if (request()->query('id') == $empleado->id) style="display: table-row;" @else style="display: none;" @endif>
                <td>INFORMACION EXTRA</td>
            </tr>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Paginacion - 10 empleados por pagina -->

    <div class="d-flex justify-content-center">
        {{ $empleados->links('vendor.pagination.default') }}
    </div>

</div>
@endsection
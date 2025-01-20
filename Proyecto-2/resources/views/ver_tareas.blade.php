@extends('plantilla')

@section('titulo', 'Listado de Tareas')

@section('contenido')
<div class="container mt-5">
    <h2 class="text-center mb-4">Lista de Tareas</h2>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Estado</th>
                <th>Operario Encargado</th>
                <th>Fecha de Creación</th>
                <th>Fecha de Finalización</th>
                <th>Anotaciones</th>
                <th>Cliente</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tareas as $tarea)
            <tr>
                <td>{{ $tarea->estado }}</td>
                <td>{{ $empleados[$tarea->operario_id]->nombre }}</td>
                <td>{{ $tarea->fecha_creacion }}</td>
                <td>{{ $tarea->fecha_finalizacion }}</td>
                <td>{{ $tarea->anotaciones }}</td>
                <td>{{ $clientes[$tarea->cliente_id]->nombre }}</td>
                <td>
                    <a href="" class="btn btn-primary btn-sm">Editar</a>
                    <a href="{{ route('borrar-tarea', ['id' => $tarea->id]) }}" class="btn btn-danger btn-sm">Eliminar</a>
                    <!-- Desplegable con mas datos -->
                    <div class="btn-group">
                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width: 60px;">
                            <a style="text-decoration: none; color:white"
                                href="@if (request()->query('id') == $tarea->id) {{ route('ver-tareas', ['page'=> request()->query('page')]) }} @else {{ route('ver-tareas', ['id'=>$tarea->id, 'page'=>request()->query('page')]) }} @endif">
                                @if (request()->query('id') == $tarea->id)
                                Menos
                                @else
                                Más
                                @endif
                            </a>
                        </button>
                    </div>

            <tr @if (request()->query('id') == $tarea->id) style="display: table-row;" @else style="display: none;" @endif>
                <td>INFORMACION EXTRA</td>
            </tr>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Paginacion - 10 tareas por pagina -->

    <div class="d-flex justify-content-center">
        {{ $tareas->links('vendor.pagination.default') }}
    </div>

</div>
@endsection
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
                    <a href="" class="btn btn-primary btn-sm">Ver Detalles/Editar</a>
                    <a href="{{ route('borrar_tarea', ['id' => $tarea->id]) }}" class="btn btn-danger btn-sm">Eliminar</a>
                    <!-- Desplegable con mas datos -->
                    <div class="dropdown">
                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Mas
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#">Descargar Resumen</a>
                            <a class="dropdown-item" href="#">Cambiar Estado</a>
                        </div>
                </td>
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
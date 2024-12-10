
@extends('plantilla')

@section('titulo', 'Tareas Pendientes')

@section('contenido')
<div class="container mt-5">
    <h2 class="text-center mb-4">Lista de Tareas Pendientes</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>NIF/CIF</th>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Descripción</th>
                <th>Correo Electrónico</th>
                <th>Fecha Creación</th>
                <th>Fecha Realización</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tareas as $tarea)
                <tr>
                    <td>{{ $tarea['nif_cif'] }}</td>
                    <td>{{ $tarea['nombre'] }}</td>
                    <td>{{ $tarea['telefono_contacto'] }}</td>
                    <td>{{ $tarea['descripcion'] }}</td>
                    <td>{{ $tarea['correo_contacto'] }}</td>
                    <td>{{ $tarea['fecha_creacion'] }}</td>
                    <td>{{ $tarea['fecha_realizacion'] }}</td>
                    <td>
                        <a href="{{ $utiles->myUrl('/tareas/editar/' . $tarea['id']) }}" class="btn btn-primary btn-sm">Editar</a>
                        <a href="{{ $utiles->myUrl('/tareas/eliminar/' . $tarea['id']) }}" class="btn btn-danger btn-sm">Eliminar</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Paginación -->
    <nav aria-label="Page navigation" class="mt-4">
        <ul class="pagination justify-content-center">
            <!-- Botón Anterior -->
            <li class="page-item {{ $paginaActual <= 1 ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $utiles->myUrl('tareas-pendientes?page=' . ($paginaActual - 1)) }}">Anterior</a>
            </li>

            <!-- Números de página -->
            @for ($i = 1; $i <= ceil($totalTareas / $tareasPorPagina); $i++)
                <li class="page-item {{ $paginaActual == $i ? 'active' : '' }}">
                    <a class="page-link" href="{{ $utiles->myUrl('tareas-pendientes?page=' . $i) }}">{{ $i }}</a>
                </li>
            @endfor

            <!-- Botón Siguiente -->
            <li class="page-item {{ $paginaActual >= ceil($totalTareas / $tareasPorPagina) ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $utiles->myUrl('tareas-pendientes?page=' . ($paginaActual + 1)) }}">Siguiente</a>
            </li>
        </ul>
    </nav>
</div>
@endsection
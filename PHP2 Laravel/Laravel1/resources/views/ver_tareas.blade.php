

@extends('plantilla')

@section('titulo', 'Lista de Tareas')

@section('contenido')
<div class="container mt-5">
    <h2 class="text-center mb-4">Lista de Tareas</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th><a href="{{ route('ver-tareas', ['ordenar_por' => 'nif_cif', 'orden' => $orden === 'ASC' && $ordenarPor === 'nif_cif' ? 'DESC' : 'ASC']) }}">NIF/CIF</a></th>
                <th><a href="{{ route('ver-tareas', ['ordenar_por' => 'nombre', 'orden' => $orden === 'ASC' && $ordenarPor === 'nombre' ? 'DESC' : 'ASC']) }}">Nombre</a></th>
                <th><a href="{{ route('ver-tareas', ['ordenar_por' => 'telefono_contacto', 'orden' => $orden === 'ASC' && $ordenarPor === 'telefono_contacto' ? 'DESC' : 'ASC']) }}">Teléfono</a></th>
                <th><a href="{{ route('ver-tareas', ['ordenar_por' => 'descripcion', 'orden' => $orden === 'ASC' && $ordenarPor === 'descripcion' ? 'DESC' : 'ASC']) }}">Descripción</a></th>
                <th><a href="{{ route('ver-tareas', ['ordenar_por' => 'email', 'orden' => $orden === 'ASC' && $ordenarPor === 'email' ? 'DESC' : 'ASC']) }}">Correo Electrónico</a></th>
                <th><a href="{{ route('ver-tareas', ['ordenar_por' => 'fecha_realizacion', 'orden' => $orden === 'ASC' && $ordenarPor === 'fecha_realizacion' ? 'DESC' : 'ASC']) }}">Fecha Realización</a></th>
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
                    <td>{{ $tarea['email'] }}</td>
                    <td>{{ $tarea['fecha_realizacion'] }}</td>
                    <td>
                        <a href="{{ route('editar-tarea', $tarea['id']) }}" class="btn btn-primary btn-sm">Editar</a>
                        <form action="{{ route('eliminar-tarea', $tarea['id']) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('¿Seguro que deseas eliminar esta tarea?');" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Paginación -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            @for ($i = 1; $i <= ceil($totalTareas / $tareasPorPagina); $i++)
                <li class="page-item {{ $paginaActual == $i ? 'active' : '' }}">
                    <a class="page-link" href="{{ route('ver-tareas', ['page' => $i, 'ordenar_por' => $ordenarPor, 'orden' => $orden]) }}">{{ $i }}</a>
                </li>
            @endfor
        </ul>
    </nav>
</div>
@endsection
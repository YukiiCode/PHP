@extends('plantilla')

@section('titulo', 'Listado de Tareas')

@section('contenido')
<div class="container mt-5">
    <h2 class="text-center mb-4">Lista de Tareas</h2>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

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
                <td>{{ isset($empleados[$tarea->operario_id]) ? $empleados[$tarea->operario_id]->nombre : 'N/A' }}</td>
                <td>{{ $tarea->fecha_creacion }}</td>
                <td>{{ $tarea->fecha_finalizacion }}</td>
                <td>{{ $tarea->anotaciones }}</td>
                <td>{{ isset($clientes[$tarea->cliente_id]) ? $clientes[$tarea->cliente_id]->nombre : 'N/A' }}</td>
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
                <td>Informacion extra</td>
                <td colspan="6">
                    @if ($tarea->archivos)
                    <div class="row">
                        @foreach ($tarea->archivos as $archivo)
                        @php
                        // Genera la URL a través de Storage::url()
                        $archivoUrl = Storage::url($archivo->ruta);
                        $extension = pathinfo($archivo->ruta, PATHINFO_EXTENSION);
                        @endphp

                        <div class="col-md-4 mb-3">
                            @if ($extension === 'pdf')
                            <div class="card">
                                <div class="card-body text-center">
                                    <a href="{{ $archivoUrl }}" target="_blank" class="btn btn-outline-primary btn-sm">Ver PDF</a>
                                    <a href="{{ $archivoUrl }}" download class="btn btn-outline-secondary btn-sm">Descargar PDF</a>
                                </div>
                            </div>
                            @elseif(in_array($extension, ['jpg', 'jpeg', 'png', 'gif']))
                            <div class="card">
                                <img src="{{ $archivoUrl }}" class="card-img-top" alt="Imagen" style="max-width: 100%; height: auto;">
                                <div class="card-body text-center">
                                    <a href="{{ $archivoUrl }}" download class="btn btn-outline-secondary btn-sm">Descargar Imagen</a>
                                </div>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-center">No hay archivos adjuntos.</p>
                    @endif
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
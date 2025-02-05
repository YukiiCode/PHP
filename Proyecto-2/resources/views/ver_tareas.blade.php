@extends('plantilla')

@section('titulo', 'Listado de Tareas')

@section('contenido')
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title mb-0"><i class="fas fa-tasks mr-2"></i> Listado Tareas</h3>
        </div>

        <div class="card-body">
            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h5 class="alert-heading"><i class="fas fa-exclamation-circle mr-2"></i>Error en el formulario</h5>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover table-bordered mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Estado</th>
                            <th>Operario</th>
                            <th class="text-center">Creación</th>
                            <th class="text-center">Finalización</th>
                            <th>Anotaciones</th>
                            <th>Cliente</th>
                            <th class="text-center" style="width: 150px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tareas as $tarea)
                        <tr class="@if(request()->query('id') == $tarea->id) table-active @endif">
                            <td>
                                @php
                                    $badgeClass = [
                                        'pendiente' => 'badge-danger',
                                        'en proceso' => 'badge-warning',
                                        'completada' => 'badge-success'
                                    ][$tarea->estado] ?? 'badge-secondary';
                                @endphp
                                <span class="badge {{ $badgeClass }} badge-pill">{{ $tarea->estado }}</span>
                            </td>
                            <td>{{ isset($empleados[$tarea->operario_id]) ? $empleados[$tarea->operario_id]->nombre : 'N/A' }}</td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($tarea->fecha_creacion)->format('d/m/Y H:i') }}</td>
                            <td class="text-center">{{ $tarea->fecha_finalizacion ? \Carbon\Carbon::parse($tarea->fecha_finalizacion)->format('d/m/Y H:i') : 'N/A' }}</td>
                            <td>
                                <span data-toggle="tooltip" title="{{ $tarea->anotaciones }}">
                                    {{ Str::limit($tarea->anotaciones, 30) }}
                                </span>
                            </td>
                            <td>{{ isset($clientes[$tarea->cliente_id]) ? $clientes[$tarea->cliente_id]->nombre : 'N/A' }}</td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="#" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('borrar-tarea', ['id' => $tarea->id]) }}" 
                                       class="btn btn-danger btn-sm" 
                                       data-toggle="tooltip" 
                                       title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    <a href="@if (request()->query('id') == $tarea->id) {{ route('ver-tareas', ['page'=> request()->query('page')]) }} @else {{ route('ver-tareas', ['id'=>$tarea->id, 'page'=>request()->query('page')]) }} @endif"
                                       class="btn btn-secondary btn-sm" 
                                       data-toggle="tooltip" 
                                       title="@if(request()->query('id') == $tarea->id) Ocultar detalles @else Ver detalles @endif">
                                        <i class="fas @if(request()->query('id') == $tarea->id) fa-chevron-up @else fa-chevron-down @endif"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>

                        @if(request()->query('id') == $tarea->id)
                        <tr class="table-info">
                            <td colspan="7">
                                <div class="p-3">
                                    <h5 class="mb-3"><i class="fas fa-file-alt mr-2"></i>Detalles adicionales</h5>
                                    
                                    @if($tarea->archivos && count($tarea->archivos) > 0)
                                    <div class="row">
                                        @foreach($tarea->archivos as $archivo)
                                        @php
                                            $archivoUrl = Storage::url($archivo->ruta);
                                            $extension = pathinfo($archivo->ruta, PATHINFO_EXTENSION);
                                        @endphp
                                        
                                        <div class="col-md-4 mb-3">
                                            <div class="card h-100 shadow-sm">
                                                <div class="card-body text-center">
                                                    @if($extension === 'pdf')
                                                    <div class="mb-2">
                                                        <i class="fas fa-file-pdf fa-3x text-danger"></i>
                                                    </div>
                                                    <div class="btn-group">
                                                        <a href="{{ $archivoUrl }}" target="_blank" class="btn btn-outline-danger btn-sm">
                                                            <i class="fas fa-eye mr-1"></i>Ver
                                                        </a>
                                                        <a href="{{ $archivoUrl }}" download class="btn btn-danger btn-sm">
                                                            <i class="fas fa-download mr-1"></i>Descargar
                                                        </a>
                                                    </div>
                                                    @elseif(in_array($extension, ['jpg','jpeg','png','gif']))
                                                    <img src="{{ $archivoUrl }}" class="img-thumbnail mb-2" style="max-height: 150px;">
                                                    <a href="{{ $archivoUrl }}" download class="btn btn-primary btn-sm btn-block">
                                                        <i class="fas fa-download mr-1"></i>Descargar imagen
                                                    </a>
                                                    @endif
                                                </div>
                                                <div class="card-footer small text-muted">
                                                    {{ basename($archivo->ruta) }}
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    @else
                                    <div class="alert alert-info mb-0">
                                        <i class="fas fa-info-circle mr-2"></i>No hay archivos adjuntos para esta tarea
                                    </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endif

                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <h4 class="text-muted"><i class="fas fa-inbox mr-2"></i>No se encontraron tareas</h4>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $tareas->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection


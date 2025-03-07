@extends('plantilla')
@section('titulo', 'Listado de Tareas')
@section('contenido')
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title mb-0"><i class="fas fa-tasks mr-2"></i> Listado Tareas</h3>
        </div>
        <div class="card-body">

            <!-- Tabla de Tareas -->
            <div class="table-responsive">
                <table class="table table-hover table-bordered mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th class="text-center">Id</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Operario</th>
                            <th class="text-center">Creación</th>
                            <th class="text-center">Finalización</th>
                            <th class="text-center">Anotaciones</th>
                            <th class="text-center">Cliente</th>
                            <th class="text-center" style="width: 150px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tareas as $tarea)
                        <tr class="@if(request()->query('id') == $tarea->id) table-active @endif">
                            <td class="text-center">{{$tarea->id}}</td>
                            <td class="text-center">
                                @php
                                $estados = [
                                'F' => ['descripcion' => 'Finalizada', 'clase' => 'bg-success'],
                                'T' => ['descripcion' => 'En proceso', 'clase' => 'bg-warning'],
                                'C' => ['descripcion' => 'Cancelada', 'clase' => 'bg-danger'],
                                'A' => ['descripcion' => 'Por Aprobar', 'clase' => 'bg-secondary'],
                                'E' => ['descripcion' => 'Pausada', 'clase' => 'bg-info'],
                                ];
                                $estadoActual = $estados[$tarea->estado] ?? ['descripcion' => 'Desconocido', 'clase' => 'badge-dark'];
                                @endphp
                                <span class="badge badge-pill {{ $estadoActual['clase'] }}">
                                    {{ $estadoActual['descripcion'] }}
                                </span>
                            </td>
                            <td> {{ $tarea->empleado ? $tarea->empleado->nombre : 'N/A' }} </td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($tarea->fecha_creacion)->format('d/m/Y H:i') }}</td>
                            <td class="text-center">{{ $tarea->fecha_finalizacion ? \Carbon\Carbon::parse($tarea->fecha_finalizacion)->format('d/m/Y H:i') : '' }}</td>
                            <td>
                                <span data-toggle="tooltip" title="{{ $tarea->anotaciones }}">
                                    {{ Str::limit($tarea->anotaciones, 30) }}
                                </span>
                            </td>
                            <td> 
                                <a href="{{ route('tareas.cliente-detail',['id' => $tarea->cliente_id]) }}" 
                                   class="btn btn-outline-info btn-sm text-decoration-none"
                                   data-toggle="tooltip"
                                   title="Ver detalles del cliente">
                                    <i class="fas fa-user mr-1"></i>
                                    {{ $tarea->cliente ? $tarea->cliente->nombre : 'N/A' }}
                                </a>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                        <a href="{{ route('tareas.edit',['tarea' => $tarea]) }}" class="btn btn-outline-primary btn-sm" data-toggle="tooltip" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @if(Auth::user()->empleado->tipo !== 'operario')
                                    <form action="{{ route('tareas.destroy', $tarea->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                class="btn btn-outline-danger btn-sm text-decoration-none" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#confirmDeleteModal"
                                                data-taskid="{{ $tarea->id }}"
                                                data-taskstatus="{{ $estadoActual['descripcion'] }}"
                                                data-taskoperator="{{ $tarea->empleado ? $tarea->empleado->nombre : 'N/A' }}"
                                                data-taskcreation="{{ \Carbon\Carbon::parse($tarea->fecha_creacion)->format('d/m/Y H:i') }}"
                                                data-tasknotes="{{ Str::limit($tarea->anotaciones, 30) }}"
                                                data-taskclient="{{ $tarea->cliente ? $tarea->cliente->nombre : 'N/A' }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                    <a href="@if (request()->query('id') == $tarea->id) {{ route('tareas.index', ['page'=> request()->query('page')]) }} @else {{ route('tareas.index', ['id'=>$tarea->id, 'page'=>request()->query('page')]) }} @endif"
                                        class="btn btn-outline-secondary btn-sm"
                                        data-toggle="tooltip"
                                        title="@if(request()->query('id') == $tarea->id) Ocultar detalles @else Ver detalles @endif">
                                        <i class="fas @if(request()->query('id') == $tarea->id) fa-chevron-up @else fa-chevron-down @endif"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @if(request()->query('id') == $tarea->id)
                        <tr class="table-info">
                            <td colspan="8">
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
                                                    <div class="pdf-container">
                                                        <iframe src="{{ $archivoUrl }}" class="pdf-viewer mb-2" frameborder="0"></iframe>
                                                        <div class="btn-group mt-2">
                                                            <a href="{{ $archivoUrl }}" target="_blank" class="btn btn-outline-danger btn-sm">
                                                                <i class="fas fa-external-link-alt mr-1"></i>Abrir
                                                            </a>
                                                            <a href="{{ $archivoUrl }}" download class="btn btn-outline-danger btn-sm">
                                                                <i class="fas fa-download mr-1"></i>Descargar
                                                            </a>
                                                        </div>
                                                    </div>
                                                    @elseif(in_array($extension, ['jpg','jpeg','png','gif']))
                                                    <img src="{{ $archivoUrl }}" class="img-thumbnail mb-2" style="max-height: 150px;">
                                                    <a href="{{ $archivoUrl }}" download class="btn btn-outline-primary btn-sm btn-block">
                                                        <i class="fas fa-download mr-1"></i>Descargar imagen
                                                    </a>
                                                    @endif
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

            <!-- Paginación -->
            <div class="d-flex justify-content-center mt-4">
                {{ $tareas->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Borrado</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas borrar la siguiente tarea?</p>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>ID:</strong> <span id="modalTaskId"></span></li>
                    <li class="list-group-item"><strong>Estado:</strong> <span id="modalTaskStatus"></span></li>
                    <li class="list-group-item"><strong>Operario:</strong> <span id="modalTaskOperator"></span></li>
                    <li class="list-group-item"><strong>Creación:</strong> <span id="modalTaskCreation"></span></li>
                    <li class="list-group-item"><strong>Anotaciones:</strong> <span id="modalTaskNotes"></span></li>
                    <li class="list-group-item"><strong>Cliente:</strong> <span id="modalTaskClient"></span></li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Sí, borrar</button>
                </form>
            </div>
        </div>
    </div>
</div>


@if (Request::is('ver-tareas/detalle-cliente/*'))   
@php
$id = Request::route('id'); // Obtiene el ID de la ruta
$cliente = $tareas->firstWhere('cliente_id', $id)->cliente;
@endphp
<div class="modal fade show" tabindex="-1" role="dialog" style="display: block;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Detalles del Cliente</h5>
                <a href="{{ route('tareas.index',['page'=> request()->query('page')]) }}" class="btn-close btn-close-white" aria-label="Close"></a>
            </div>
            <div class="modal-body">
                @if(isset($cliente))
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>ID:</strong> {{ $cliente->id }}</li>
                    <li class="list-group-item"><strong>Nombre:</strong> {{ $cliente->nombre }}</li>
                    <li class="list-group-item"><strong>CIF:</strong> {{ $cliente->cif }}</li>
                    <li class="list-group-item"><strong>Teléfono:</strong> {{ $cliente->telefono }}</li>
                    <li class="list-group-item"><strong>Correo Electrónico:</strong> {{ $cliente->correo }}</li>
                    <li class="list-group-item"><strong>Dirección:</strong> {{ $cliente->direccion ?? 'N/A' }}</li>
                    <li class="list-group-item"><strong>Fecha de Registro:</strong> {{ \Carbon\Carbon::parse($cliente->created_at)->format('d/m/Y H:i') }}</li>
                </ul>
                @else
                <p class="text-muted">No se encontró el cliente.</p>
                @endif
            </div>
            <div class="modal-footer">
                <a href="{{ route('tareas.index', ['page'=> request()->query('page')])  }}" class="btn btn-secondary">Cerrar</a>
            </div>
        </div>
    </div>
</div>
@endif

@endsection

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Borrado</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas borrar la siguiente tarea?</p>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>ID:</strong> <span id="modalTaskId"></span></li>
                    <li class="list-group-item"><strong>Estado:</strong> <span id="modalTaskStatus"></span></li>
                    <li class="list-group-item"><strong>Operario:</strong> <span id="modalTaskOperator"></span></li>
                    <li class="list-group-item"><strong>Creación:</strong> <span id="modalTaskCreation"></span></li>
                    <li class="list-group-item"><strong>Anotaciones:</strong> <span id="modalTaskNotes"></span></li>
                    <li class="list-group-item"><strong>Cliente:</strong> <span id="modalTaskClient"></span></li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Sí, borrar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const deleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
    
    document.querySelectorAll('[data-bs-target="#confirmDeleteModal"]').forEach(button => {
        button.addEventListener('click', function() {
            const taskId = this.dataset.taskid;
            
            // Actualizar contenido del modal
            document.getElementById('modalTaskId').textContent = this.dataset.taskid;
            document.getElementById('modalTaskStatus').textContent = this.dataset.taskstatus;
            document.getElementById('modalTaskOperator').textContent = this.dataset.taskoperator;
            document.getElementById('modalTaskCreation').textContent = this.dataset.taskcreation;
            document.getElementById('modalTaskNotes').textContent = this.dataset.tasknotes;
            document.getElementById('modalTaskClient').textContent = this.dataset.taskclient;
            
            // Actualizar acción del formulario
            document.getElementById('deleteForm').action = `{{ route('tareas.destroy', '') }}/${taskId}`;
            
            // Mostrar modal
            deleteModal.show();
        });
    });
});
</script>
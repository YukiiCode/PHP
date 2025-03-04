@extends('plantilla')

@section('contenido')
<div class="container-fluid px-4">
    <h1 class="mt-4">Gestión de Cuotas</h1>
    
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div class="me-3">
                    <i class="fas fa-table me-1"></i>
                    Listado de Cuotas
                </div>
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-plus me-1"></i> Añadir Cuotas
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                        <li>
                            <a class="dropdown-item" href="{{ route('cuotas.create') }}">
                                <i class="fas fa-user me-1"></i> Cuota Individual
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('cuotas.batch.create') }}">
                                <i class="fas fa-users me-1"></i> Remesa para Todos los Clientes
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="mb-3">
                <form class="row g-2">
                    <div class="col-md-3">
                        <input type="text" class="form-control" placeholder="Buscar cliente..." name="search">
                    </div>
                    <div class="col-md-2">
                        <select class="form-select" name="estado">
                            <option value="">Todos los estados</option>
                            <option value="pendiente">Pendiente</option>
                            <option value="pagado">Pagado</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="month" class="form-control" name="mes">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary">Filtrar</button>
                    </div>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Cliente</th>
                            <th>Concepto</th>
                            <th>Tipo</th>
                            <th>Importe</th>
                            <th>Fecha Emisión</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cuotas as $cuota)
                        <tr class="{{ $cuota->estado === 'pagado' ? 'table-success' : 'table-warning' }}">
                            <td>{{ $cuota->cliente->nombre ?? 'Cliente no encontrado' }}</td>
                            <td>{{ $cuota->concepto }}</td>
                            <td>{{ ucfirst($cuota->tipo) }}</td>
                            <td>{{ number_format($cuota->importe, 2) }}€</td>
                            <td>{{ $cuota->fecha_emision->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge bg-{{ $cuota->estado === 'pagado' ? 'success' : 'warning' }}">
                                    {{ ucfirst($cuota->estado) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('cuotas.edit', $cuota->id) }}" class="btn btn-sm btn-outline-secondary" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('cuotas.download', $cuota->id) }}" class="btn btn-sm btn-outline-primary" title="Descargar PDF">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                                <form action="{{ route('cuotas.email', $cuota->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-info" title="Enviar por email">
                                        <i class="fas fa-envelope"></i>
                                    </button>
                                </form>
                                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" 
                                    data-bs-target="#deleteModal{{ $cuota->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .modal-backdrop {
        z-index: 1040 !important;
    }
    .modal {
        z-index: 1050 !important;
    }
</style>

<!-- Delete Modals -->
@foreach($cuotas as $cuota)
<div class="modal fade" id="deleteModal{{ $cuota->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $cuota->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel{{ $cuota->id }}">Confirmar eliminación</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de eliminar la cuota de {{ $cuota->cliente->nombre }} ({{ $cuota->concepto }})?
            </div>
            <div class="modal-footer">
                <form action="{{ route('cuotas.destroy', $cuota->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
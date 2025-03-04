@extends('plantilla')
@section('titulo', 'Listado de Clientes')
@section('contenido')
<div class="container-fluid p-4">
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white py-3">
            <h3 class="card-title mb-0 fs-4 fw-bold"><i class="fas fa-users me-2"></i>Gestión de Clientes</h3>
        </div>
        <div class="card-body"> 
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-light align-middle">
                        <tr class="fs-7 text-uppercase">
                            <th class="ps-3">CIF</th>
                            <th>Nombre</th>
                            <th>Teléfono</th>
                            <th>Correo</th>
                            <th>País</th>
                            <th>Moneda</th>
                            <th>Importe Mensual</th>
                            <th class="text-center" style="width: 150px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($clientes as $cliente)
                        <tr class="@if(request()->query('id') == $cliente->id) table-active @endif">
                            <td>{{ $cliente->cif }}</td>
                            <td>{{ $cliente->nombre }}</td>
                            <td>{{ $cliente->telefono }}</td>
                            <td>{{ $cliente->correo }}</td>
                            <td>{{ $cliente->pais }}</td>
                            <td>{{ $cliente->moneda }}</td>
                            <td>{{ $cliente->importe_mensual }}</td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group" aria-label="Acciones cliente">
                                    <a href="{{ route('ver-cliente', ['id' => $cliente->id]) }}" 
                                       class="btn btn-outline-primary"
                                       data-bs-toggle="tooltip"
                                       data-bs-placement="top"
                                       title="Detalles completos">
                                        <i class="fas fa-eye me-1"></i>Ver
                                    </a>
                                    <button class="btn btn-outline-info"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#cuotas-{{ $cliente->id }}"
                                        aria-expanded="false"
                                        aria-controls="cuotas-{{ $cliente->id }}"
                                        title="{{ request()->query('id') == $cliente->id ? 'Ocultar' : 'Mostrar' }} cuotas"
                                        aria-label="Gestión de cuotas">
                                        <i class="fas fa-coins me-1"></i>Cuotas
                                    </button>
                                    <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                            class="btn btn-outline-danger"
                                            onclick="return confirm('¿Confirmar eliminación permanente?')"
                                            aria-label="Eliminar cliente">
                                            <i class="fas fa-trash-alt me-1"></i>Baja
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <tr class="collapse" id="cuotas-{{ $cliente->id }}">
                            <td colspan="8" class="p-0">
                                <div class="p-3 bg-light">
                                    <h5 class="mb-3 text-primary fs-5"><i class="fas fa-coins me-2"></i>Historial de Cuotas</h5>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-borderless mb-0">
                                            <thead class="small bg-soft-primary">
                                                <tr>
                                                    <th class="ps-3">Concepto</th>
                                                <th>Fecha Emisión</th>
                                                <th>Importe</th>
                                                <th>Pagado</th>
                                                <th>Fecha Pago</th>
                                                <th>Notas</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($cliente->cuotas as $cuota)
                                            <tr class="{{ $cuota->pagado ? 'bg-success bg-opacity-25 text-dark' : 'bg-warning bg-opacity-25' }}">
                                                <td>{{ $cuota->concepto }}</td>
                                                <td class="text-nowrap">{{ \Carbon\Carbon::parse($cuota->fecha_emision)->isoFormat('DD MMM YYYY') }}</td>
                                                <td class="fw-medium">{{ number_format($cuota->importe, 2) }}€</td>
                                                <td>
                                                    <span class="badge bg-{{ $cuota->pagado ? 'success' : 'warning' }} rounded-pill">
                                                        {{ $cuota->pagado ? 'Pagado' : 'Pendiente' }}
                                                    </span>
                                                </td>
                                                <td>{{ $cuota->fecha_pago ? \Carbon\Carbon::parse($cuota->fecha_pago)->format('d/m/Y') : 'N/A' }}</td>
                                                <td>{{ $cuota->notas }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No hay cuotas registradas para este cliente.</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <h4 class="text-muted"><i class="fas fa-inbox mr-2"></i>No se encontraron clientes</h4>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-4 px-3">
                    <span class="text-muted small">Mostrando {{ $clientes->firstItem() }} - {{ $clientes->lastItem() }} de {{ $clientes->total() }} registros</span>
                    <div class="d-flex">
                        {{ $clientes->onEachSide(1)->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
        </div>
    </div>
</div>
@endsection
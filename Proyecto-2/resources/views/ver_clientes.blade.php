@extends('plantilla')
@section('titulo', 'Listado de Clientes')
@section('contenido')
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title mb-0"><i class="fas fa-users mr-2"></i> Listado de Clientes</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>CIF</th>
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
                                <div class="btn-group" role="group">
                                    <a href="{{ route('ver-cliente', ['id' => $cliente->id]) }}" 
                                       class="btn btn-info btn-sm" 
                                       data-toggle="tooltip" 
                                       title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="@if (request()->query('id') == $cliente->id) {{ route('ver-clientes', ['page'=> request()->query('page')]) }} @else {{ route('ver-clientes', ['id'=>$cliente->id, 'page'=>request()->query('page')]) }} @endif"
                                       class="btn btn-secondary btn-sm" 
                                       data-toggle="tooltip" 
                                       title="@if(request()->query('id') == $cliente->id) Ocultar cuotas @else Ver cuotas @endif">
                                        <i class="fas @if(request()->query('id') == $cliente->id) fa-chevron-up @else fa-chevron-down @endif"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @if(request()->query('id') == $cliente->id)
                        <tr class="table-info">
                            <td colspan="8">
                                <div class="p-3">
                                    <h5 class="mb-3"><i class="fas fa-coins mr-2"></i>Cuotas del Cliente</h5>
                                    <table class="table table-hover table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Concepto</th>
                                                <th>Fecha Emisión</th>
                                                <th>Importe</th>
                                                <th>Pagado</th>
                                                <th>Fecha Pago</th>
                                                <th>Notas</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($cliente->cuotas as $cuota)
                                            <tr class="{{ $cuota->pagado ? 'bg-success text-white' : 'bg-warning' }}">
                                                <td>{{ $cuota->concepto }}</td>
                                                <td>{{ \Carbon\Carbon::parse($cuota->fecha_emision)->format('d/m/Y') }}</td>
                                                <td>{{ $cuota->importe }}</td>
                                                <td>{{ $cuota->pagado ? 'Sí' : 'No' }}</td>
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
                        @endif
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
            <div class="d-flex justify-content-center mt-4">
                {{ $clientes->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection
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
                <form class="row g-2" method="GET" action="{{ route('cuotas.index') }}">
                    <div class="col-md-3">
                        <input type="text" class="form-control" placeholder="Buscar cliente..." name="search" value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <select class="form-select" name="estado">
                            <option value="">Todos los estados</option>
                            <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="pagado" {{ request('estado') == 'pagado' ? 'selected' : '' }}>Pagado</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="month" class="form-control" name="mes" value="{{ request('mes') }}">
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
                            <th>Moneda</th>
                            <th>Fecha Emisión</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cuotas as $cuota)
                        <tr class="{{ $cuota->pagado ? 'table-success' : 'table-warning' }}">
                            <td>{{ $cuota->cliente->nombre ?? 'Cliente no encontrado' }}</td>
                            <td>{{ $cuota->concepto }}</td>
                            <td>{{ ucfirst($cuota->tipo) }}</td>
                            <td>{{ number_format($cuota->importe, 2) }}</td>
                            <td>
                                {{ $cuota->cliente->moneda ?? 'EUR' }}
                                @if($cuota->cliente && $cuota->cliente->moneda && $cuota->cliente->moneda !== 'EUR')
                                    <button type="button" class="btn btn-sm btn-outline-info convert-btn" 
                                        data-bs-toggle="tooltip" 
                                        data-bs-placement="top" 
                                        title="{{ number_format($cuota->getImporteEnEuros(), 2) }}€"
                                        data-bs-title="{{ number_format($cuota->getImporteEnEuros(), 2) }}€">
                                        <i class="fas fa-euro-sign"></i>
                                    </button>
                                @endif
                            </td>
                            <td>{{ $cuota->fecha_emision->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge bg-{{ $cuota->pagado ? 'success' : 'warning' }}">
                                    {{ $cuota->pagado ? 'Pagado' : 'Pendiente' }}
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
                                @if(!$cuota->pagado)
                                <button class="btn btn-sm btn-outline-success paypal-button" 
                                    title="Pagar con PayPal"
                                    data-cuota-id="{{ $cuota->id }}"
                                    data-amount="{{ $cuota->importe }}"
                                    data-description="Cuota {{ $cuota->concepto }}">
                                    <i class="fab fa-paypal"></i>
                                </button>
                                @endif
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

<!-- Bootstrap Modal -->
<div class="modal fade" id="conversionModal" tabindex="-1" aria-labelledby="conversionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="conversionModalLabel">Conversión a Euros</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <h3 id="euroAmount">0.00€</h3>
                <p class="text-muted small">Valor convertido según tipo de cambio actual</p>
            </div>
        </div>
    </div>
</div>

<style>
    .convert-btn {
        margin-left: 5px;
        padding: 0.1rem 0.3rem;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // PayPal Payment Handling
        document.querySelectorAll('.paypal-button').forEach(button => {
            button.addEventListener('click', async (e) => {
                e.preventDefault();
                const cuotaId = button.dataset.cuotaId;
                
                try {
                    const response = await fetch(`/paypal/payment/${cuotaId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });

                    const data = await response.json();
                    if (data.redirect_url) {
                        window.location.href = data.redirect_url;
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Error al iniciar el pago con PayPal');
                }
            });
        });
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Get the modal element
        var conversionModal = new bootstrap.Modal(document.getElementById('conversionModal'));

        // Add click event listeners to conversion buttons
        document.querySelectorAll('.convert-btn').forEach(function(button) {
            button.addEventListener('click', function() {
                var amount = this.getAttribute('data-bs-title');
                document.getElementById('euroAmount').textContent = amount;
                conversionModal.show();

                // Hide the tooltip
                var tooltip = bootstrap.Tooltip.getInstance(this);
                if (tooltip) {
                    tooltip.hide();
                }
            });
        });
    });
</script>

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
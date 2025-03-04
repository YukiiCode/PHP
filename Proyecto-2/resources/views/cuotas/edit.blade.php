@extends('plantilla')

@section('contenido')
<div class="container-fluid px-4">
    <h1 class="mt-4">Editar Cuota</h1>
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-edit me-1"></i>
            Modificar Cuota #{{ $cuota->id }}
        </div>
        
        <div class="card-body">
            <form method="POST" action="{{ route('cuotas.update', $cuota->id) }}">
                @csrf
                @method('PUT')
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Concepto</label>
                        <input type="text" class="form-control" name="concepto" 
                            value="{{ old('concepto', $cuota->concepto) }}" required>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Tipo de Cargo</label>
                        <select class="form-select" name="tipo" required>
                            <option value="individual" {{ $cuota->tipo == 'individual' ? 'selected' : '' }}>Normal</option>
                            <option value="mensual" {{ $cuota->tipo == 'mensual' ? 'selected' : '' }}>Mensual</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Importe</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="importe" 
                                step="0.01" value="{{ old('importe', $cuota->importe) }}" required>
                            <span class="input-group-text">€</span>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label">Fecha Emisión</label>
                        <input type="date" class="form-control" name="fecha_emision" 
                            value="{{ old('fecha_emision', $cuota->fecha_emision->format('Y-m-d')) }}">
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label">Fecha Pago</label>
                        <input type="date" class="form-control" name="fecha_pago" 
                            value="{{ old('fecha_pago', optional($cuota->fecha_pago)?->format('Y-m-d')) }}">
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label">Estado</label>
                        <select class="form-select" id="estado" name="estado" required>
                            <option value="pendiente" {{ old('estado', $cuota->estado) == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="pagado" {{ old('estado', $cuota->estado) == 'pagado' ? 'selected' : '' }}>Pagado</option>
                        </select>
                    </div>
                    
                    <div class="col-12">
                        <label class="form-label">Notas</label>
                        <textarea class="form-control" name="notas" rows="3">{{ old('notas', $cuota->notas) }}</textarea>
                    </div>
                </div>

                @if($errors->any())
                <div class="alert alert-danger mt-4">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Guardar Cambios
                    </button>
                    <a href="{{ route('cuotas.index') }}" class="btn btn-secondary">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
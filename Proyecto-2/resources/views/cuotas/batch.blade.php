@extends('plantilla')

@section('contenido')
<div class="container-fluid px-4">
    <h1 class="mt-4">Generar Cuotas Mensuales</h1>
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-copy me-1"></i>
            Parámetros de generación
        </div>
        
        <div class="card-body">
            <form method="POST" action="{{ route('cuotas.batch.store') }}">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label">Clientes</label>
                    <div class="border p-3 rounded">
                        @foreach($clientes as $cliente)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="clientes[]" 
                                value="{{ $cliente->id }}" id="cliente_{{ $cliente->id }}">
                            <label class="form-check-label" for="cliente_{{ $cliente->id }}">
                                {{ $cliente->nombre }} {{ $cliente->apellidos }}
                            </label>
                        </div>
                        @endforeach
                        @error('clientes')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Mes y Año</label>
                        <input type="month" class="form-control @error('mes') is-invalid @enderror" name="mes" 
                            value="{{ old('mes') ?? now()->format('Y-m') }}" required>
                        @error('mes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Importe</label>
                        <div class="input-group">
                            <input type="number" class="form-control @error('importe') is-invalid @enderror" name="importe" 
                                step="0.01" value="{{ old('importe') }}" required>
                            @error('importe')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <span class="input-group-text">€</span>
                        </div>
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
                        <i class="fas fa-save me-1"></i> Generar Cuotas
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
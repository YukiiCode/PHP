@extends('plantilla')

@section('contenido')
<div class="container-fluid px-4">
    <h1 class="mt-4">Crear Nueva Cuota</h1>
    
    <div class="card mb-4">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form method="POST" action="{{ route('cuotas.store') }}">
                @csrf
                
                <div class="mb-3">
                    <label for="cliente_id" class="form-label">Cliente</label>
                    <select class="form-select" id="cliente_id" name="cliente_id" required>
                        <option value="">Seleccione un cliente</option>
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                {{ $cliente->nombre }} {{ $cliente->apellidos }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="concepto" class="form-label">Concepto</label>
                    <input type="text" class="form-control" id="concepto" name="concepto" 
                           value="{{ old('concepto') }}" required maxlength="100">
                </div>

                <div class="mb-3">
                    <label for="importe" class="form-label">Importe (€)</label>
                    <input type="number" class="form-control" id="importe" name="importe"
                           step="0.01" min="0" value="{{ old('importe') }}" required>
                </div>

                <div class="mb-3">
                    <label for="fecha_emision" class="form-label">Fecha de Emisión</label>
                    <input type="date" class="form-control" id="fecha_emision" name="fecha_emision"
                           value="{{ old('fecha_emision', now()->format('Y-m-d')) }}" required>
                </div>

                <button type="submit" class="btn btn-primary">Crear Cuota</button>
                <a href="{{ route('cuotas.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection
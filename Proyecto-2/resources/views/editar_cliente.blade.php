@extends('plantilla')
@section('titulo', 'Editar Cliente')
@section('contenido')
<div class="container">
    <h1 class="my-4">Editar Cliente</h1>

    @if ($errors->any())
    <div class="alert alert-danger">
        <strong>Por favor, corrige los siguientes errores:</strong>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('clientes.update', $cliente) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="cif" class="form-label">CIF <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('cif') is-invalid @enderror" 
                   name="cif" id="cif" value="{{ old('cif', $cliente->cif) }}" required>
            @error('cif')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                   name="nombre" id="nombre" value="{{ old('nombre', $cliente->nombre) }}" required>
            @error('nombre')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" class="form-control @error('telefono') is-invalid @enderror" 
                   name="telefono" id="telefono" value="{{ old('telefono', $cliente->telefono) }}">
            @error('telefono')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="correo" class="form-label">Correo Electrónico</label>
            <input type="text" class="form-control @error('correo') is-invalid @enderror" 
                   name="correo" id="correo" value="{{ old('correo', $cliente->correo) }}">
            @error('correo')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="cuenta_corriente" class="form-label">Cuenta Corriente</label>
            <input type="text" class="form-control @error('cuenta_corriente') is-invalid @enderror" 
                   name="cuenta_corriente" id="cuenta_corriente" value="{{ old('cuenta_corriente', $cliente->cuenta_corriente) }}" required>
            @error('cuenta_corriente')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="pais" class="form-label">País</label>
            <input type="text" class="form-control @error('pais') is-invalid @enderror" 
                   name="pais" id="pais" value="{{ old('pais', $cliente->pais) }}" required>
            @error('pais')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="moneda" class="form-label">Moneda</label>
            <select class="form-select @error('moneda') is-invalid @enderror" name="moneda" id="moneda" required>
                <option value="" {{ old('moneda', $cliente->moneda) == '' ? 'selected' : '' }}>Seleccionar moneda</option>
                <option value="EUR" {{ old('moneda', $cliente->moneda) == 'EUR' ? 'selected' : '' }}>Euro (EUR)</option>
                <option value="USD" {{ old('moneda', $cliente->moneda) == 'USD' ? 'selected' : '' }}>Dólar (USD)</option>
                <option value="GBP" {{ old('moneda', $cliente->moneda) == 'GBP' ? 'selected' : '' }}>Libra (GBP)</option>
            </select>
            @error('moneda')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="importe_mensual" class="form-label">Importe Mensual</label>
            <input type="number" step="0.01" min="0" max="9999999.99" 
                   class="form-control @error('importe_mensual') is-invalid @enderror" 
                   name="importe_mensual" id="importe_mensual" value="{{ old('importe_mensual', $cliente->importe_mensual) }}">
            @error('importe_mensual')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Cliente</button>
        <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
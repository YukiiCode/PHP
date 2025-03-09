@extends('plantilla')

@section('titulo', 'Nuevo Cliente')

@section('contenido')
<div class="container mt-4">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0"><i class="fas fa-user-plus me-2"></i>Nuevo Cliente</h3>
        </div>

        <div class="card-body">
            <form action="{{ route('clientes.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre: <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                        id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                    @error('nombre')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono: <span class="text-danger">*</span></label>
                    <input type="tel" class="form-control @error('telefono') is-invalid @enderror"
                        id="telefono" name="telefono" value="{{ old('telefono') }}" required>
                    @error('telefono')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="correo" class="form-label">Email: <span class="text-danger">*</span></label>
                    <input type="email" class="form-control @error('correo') is-invalid @enderror"
                        id="correo" name="correo" value="{{ old('correo') }}" required>
                    @error('correo')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="cif" class="form-label">CIF: <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('cif') is-invalid @enderror"
                        id="cif" name="cif" value="{{ old('cif') }}" required>
                    @error('cif')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="cuenta_corriente" class="form-label">Cuenta Corriente: <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('cuenta_corriente') is-invalid @enderror"
                        id="cuenta_corriente" name="cuenta_corriente" value="{{ old('cuenta_corriente') }}" required>
                    @error('cuenta_corriente')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="pais" class="form-label">País: <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('pais') is-invalid @enderror"
                        id="pais" name="pais" value="{{ old('pais') }}" required>
                    @error('pais')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="moneda" class="form-label">Moneda: <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('moneda') is-invalid @enderror"
                        id="moneda" name="moneda" value="{{ old('moneda') }}" required>
                    @error('moneda')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="importe_mensual" class="form-label">Importe Mensual: <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" class="form-control @error('importe_mensual') is-invalid @enderror"
                        id="importe_mensual" name="importe_mensual" value="{{ old('importe_mensual') }}" required>
                    @error('importe_mensual')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Guardar Cliente
                    </button>
                    <a href="{{ route('clientes.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
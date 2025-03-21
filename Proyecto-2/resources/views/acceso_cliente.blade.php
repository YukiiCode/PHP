@extends('plantilla')

@section('contenido')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">{{ __('Registro de Incidencia') }}</div>
                <div class="card-body">
                    <!-- Mostrar mensaje de éxito o error -->
                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif
                    
                    @if($errors->has('credentials'))
                    <div class="alert alert-danger">
                        {{ $errors->first('credentials') }}
                    </div>
                    @endif
                    
                    @if($errors->has('database'))
                    <div class="alert alert-danger">
                        {{ $errors->first('database') }}
                    </div>
                    @endif

                    <form method="POST" action="{{ route('tareas.cliente-store') }}">
                        @csrf

                        <!-- CIF del Cliente -->
                        <div class="mb-3">
                            <label for="cif" class="form-label">CIF <span class="text-danger"></span></label>
                            <input type="text" class="form-control @error('cif') is-invalid @enderror"
                                id="cif" name="cif" value="{{ old('cif') }}" placeholder="Introduce tu CIF">
                            @error('cif')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Teléfono del Cliente -->
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono <span class="text-danger"></span></label>
                            <input type="text" class="form-control @error('telefono') is-invalid @enderror"
                                id="telefono" name="telefono" value="{{ old('telefono') }}" placeholder="Introduce tu teléfono">
                            @error('telefono')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Descripción de la Incidencia -->
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('descripcion') is-invalid @enderror"
                                id="descripcion" name="descripcion" rows="5"
                                placeholder="Proporciona detalles sobre la incidencia">{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Botón de Envío -->
                        <div class="d-flex gap-2">
                            <a href=" {{ route('home') }} " class="btn btn-warning bi bi-arrow-return-left col-2">
                                <i class=" me-2"></i> Volver
                            </a>
                            <button type="submit" class="btn btn-primary col-10">
                                <i class="fas fa-paper-plane me-2"></i> Enviar Incidencia
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
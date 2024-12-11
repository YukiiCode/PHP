@extends('plantilla')

@section('titulo', 'Login')

@section('contenido')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <!-- Tarjeta de login -->
            <div class="card">
                <div class="card-header text-center bg-primary text-white">
                    <h3>Iniciar Sesión</h3>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        <!-- Campo Usuario -->
                        <div class="mb-3">
                            <label for="user" class="form-label">Usuario:</label>
                            <input type="text" id="user" name="user" class="form-control" value="{{ isset($_COOKIE['username']) ? htmlspecialchars($_COOKIE['username']) : old('user') }}">
                            {!! $utiles->mostrarError("user", $errores ?? []) !!}
                        </div>
                        <!-- Campo Contraseña -->
                        <div class="mb-3">
                            <label for="psw" class="form-label">Contraseña:</label>
                            <input type="password" id="psw" name="psw" class="form-control">
                            {!! $utiles->mostrarError("psw", $errores ?? []) !!}
                            {!! $utiles->mostrarError("novalido", $errores ?? []) !!}
                        </div>
                        <!-- Casilla de Recordar Usuario -->
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ isset($_COOKIE['username']) ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">Recordar Usuario</label>
                        </div>
                        <!-- Botón de Inicio de Sesión -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
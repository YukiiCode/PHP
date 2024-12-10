@php
use App\Models\Utiles;
$utiles = $utiles ?? Utiles::getInstance();
$usuario = $_SESSION['usuario'] ?? null;
@endphp
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo') - Gestión de Tareas</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light">
    <!-- Barra de navegación -->
<!-- Barra de navegación superior -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ $utiles->myUrl('home') }}">Gestión de Tareas</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <!-- Menú de Navegación -->
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('home') ? 'active' : '' }}" href="{{ $utiles->myUrl('home') }}">
                            <i class="fas fa-home me-1"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('nueva-tarea') ? 'active' : '' }}" href="{{ $utiles->myUrl('nueva-tarea') }}">
                            <i class="fas fa-plus-circle me-1"></i> Nueva Tarea
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('ver-tareas') ? 'active' : '' }}" href="{{ $utiles->myUrl('ver-tareas') }}">
                            <i class="fas fa-list me-1"></i> Listado de Tareas
                        </a>
                    </li>
                </ul>
                <!-- Menú de Usuario -->
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    @if ($usuario)
                        <li class="nav-item">
                            <span class="nav-link text-white">Hola, {{ $usuario['nombre_usuario'] }}</span>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{ $utiles->myUrl('cerrar-sesion') }}">
                            <i class="fas fa-sign-out-alt me-1"></i> Cerrar sesión
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido principal -->
    <div class="container">
        @yield('contenido')
    </div>

    <!-- Footer -->
    <footer class="bg-light text-center text-lg-start mt-5">
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
            © 2024 Fernando Nieves. Todos los derechos reservados.
        </div>
    </footer>

    <!-- Bootstrap JS Bundle con Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
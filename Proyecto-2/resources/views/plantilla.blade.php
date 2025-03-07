<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo') - Gestión de Tareas</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- cdn bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Bundle JS (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Estilos personalizados -->
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .pdf-container {
            position: relative;
            width: 100%;
            height: 200px;
            padding: 10px;
        }

        .navbar {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        footer {
            box-shadow: 0 -4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body class="bg-light">
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <i class="fas fa-home me-2"></i> Gestión de Tareas
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            @if (Auth::check())
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::routeIs('home') ? 'active' : '' }}" aria-current="page" href="{{ route('home') }}">
                            <i class="fas fa-home me-1"></i> Home
                        </a>
                    </li>

                    <!-- Menú desplegable para Tareas -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ Request::routeIs('tareas.*') ? 'active' : '' }}" href="#" id="navbarDropdownTareas" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-tasks me-1"></i> Tareas
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdownTareas">
                            <li>
                                <a class="dropdown-item {{ Request::routeIs('tareas.create') ? 'active' : '' }}" href="{{ route('tareas.create') }}">
                                    <i class="fas fa-plus-circle me-2"></i>Nueva Tarea
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ Request::routeIs('tareas.index') ? 'active' : '' }}" href="{{ route('tareas.index') }}">
                                    <i class="fas fa-list me-2"></i>Ver Tareas
                                </a>
                            </li>
                        </ul>
                    </li>

                    @if(Auth::user()->empleado->tipo !== 'operario')
                    <!-- Menú desplegable para Empleados -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownEmpleados" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-users-cog me-1"></i> Empleados
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdownEmpleados">
                            <li>
                                <a class="dropdown-item {{ Request::routeIs('empleados.index') ? 'active' : '' }}" href="{{ route('empleados.index') }}">
                                    <i class="fas fa-list me-2"></i>Ver Empleados
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ Request::routeIs('empleados.create') ? 'active' : '' }}" href="{{ route('empleados.create') }}">
                                    <i class="fas fa-plus-circle me-2"></i>Nuevo Empleado
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Menú desplegable para Clientes -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ Request::routeIs('clientes.*') ? 'active' : '' }}" href="#" id="navbarDropdownClientes" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-tie me-1"></i> Clientes
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdownClientes">
                            <li>
                                <a class="dropdown-item {{ Request::routeIs('clientes.index') ? 'active' : '' }}" href="{{ route('clientes.index') }}">
                                    <i class="fas fa-list me-2"></i>Ver Clientes
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ Request::routeIs('clientes.create') ? 'active' : '' }}" href="{{ route('clientes.create') }}">
                                    <i class="fas fa-plus-circle me-2"></i>Nuevo Cliente
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Request::routeIs('cuotas.*') ? 'active' : '' }}" href="{{ route('cuotas.index') }}">
                            <i class="fas fa-euro-sign me-2"></i>Gestión de Cuotas
                        </a>
                    </li>
                    @endif

                    @if(Auth::check())
                    <!-- Menú de usuario -->
                    <li class="nav-item dropdown ms-auto">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownUsuario" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user me-1"></i>{{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdownUsuario">
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión
                                    </button>
                                </form>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item {{ Request::routeIs('change.password') ? 'active' : '' }}" href="{{ route('change.password') }}">
                                    <i class="fas fa-lock me-2"></i>Cambiar Contraseña
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endif

                </ul>
            </div>
            @endif
        </div>
    </nav>

    <!-- Contenido principal -->
    <div class="container my-5">
        @yield('contenido')
    </div>

    <!-- Footer -->
    <footer class="bg-primary text-white text-center py-3">
        <div class="container">
            <p class="mb-0 small">© 2025 Aplicación de Gestión. Todos los derechos reservados.</p>
        </div>
    </footer>

    <!-- Bootstrap Dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
</body>

</html>
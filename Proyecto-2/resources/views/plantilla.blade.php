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
    <!-- Estilos personalizados -->
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        footer {
            box-shadow: 0 -4px 6px rgba(0, 0, 0, 0.1);
        }

        .modal {
            display: flex;
            /* Esto asegura que la modal esté oculta inicialmente */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            /* Fondo oscuro semi-transparente */
            justify-content: center;
            align-items: center;
            z-index: 999;
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
                        <a class="nav-link active" aria-current="page" href="{{ route('home') }}">
                            <i class="fas fa-home me-1"></i> Home
                        </a>
                    </li>

                    <!-- Menú desplegable para Tareas -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownTareas" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-tasks me-1"></i> Tareas
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdownTareas">
                            <li>
                                <a class="dropdown-item" href="{{ route('nueva-tarea') }}">
                                    <i class="fas fa-plus-circle me-2"></i>Nueva Tarea
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('ver-tareas') }}">
                                    <i class="fas fa-list me-2"></i>Ver Tareas
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Menú desplegable para Empleados -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownEmpleados" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-users me-1"></i> Empleados
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdownEmpleados">
                            <li>
                                <a class="dropdown-item" href="{{ route('ver-empleados') }}">
                                    <i class="fas fa-list me-2"></i>Ver Empleados
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-plus-circle me-2"></i>Nuevo Empleado
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Menú desplegable para Clientes -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownClientes" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-tie me-1"></i> Clientes
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdownClientes">
                            <li>
                                <a class="dropdown-item" href="{{ route('ver-clientes') }}">
                                    <i class="fas fa-list me-2"></i>Ver Clientes
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-plus-circle me-2"></i>Nuevo Cliente
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Opción para Cerrar Sesión -->
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link text-white p-0">
                                <i class="fas fa-sign-out-alt me-1"></i>Cerrar Sesión
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
        @endif
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
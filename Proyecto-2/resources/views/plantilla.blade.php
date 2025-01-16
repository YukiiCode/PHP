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

    <!-- Barra navegacion -->
    <nav class="navbar navbar-expand-lg bg-primary navbar-dark mt-auto py-3">
        <div class="container">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link text-white {{ $utiles->myUrl('home')  }}" href="{{ $utiles->myUrl('home') }}">
                        <i class="fas fa-home me-1"></i> Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ $utiles->myUrl('nueva-tarea')  }}" href="{{ $utiles->myUrl('nueva-tarea') }}">
                        <i class="fas fa-plus-circle me-1"></i> Nueva Tarea
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ $utiles->myUrl('ver-tareas')  }}" href="{{ $utiles->myUrl('ver-tareas') }}">
                        <i class="fas fa-list me-1"></i> Listado de Tareas
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ $utiles->myUrl('ver-tareas-borradas')  }}" href="{{ $utiles->myUrl('ver-tareas-borradas') }}">
                        <i class="fas fa-list me-1"></i> Listado de Tareas Borradas
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ $utiles->myUrl('ayuda') }}" href="{{ $utiles->myUrl('ayuda') }}">
                        <i class="fas fa-question-circle me-1"></i> Ayuda
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Contenido principal -->
    <div class="container">
        @yield('contenido')
    </div>

    <!-- Footer -->
    <footer class="bg-primary text-white text-center py-3 mt-5 container-fluid">
        <p class="mb-0">© 2025 Aplicacion de gestion. Todos los derechos reservados.</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
@extends('plantilla')

@section('titulo', 'Inicio')

@section('contenido')
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h3 class="mb-0"><i class="fas fa-home mr-2"></i>Panel de Control</h3>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-light btn-sm">
                    <i class="fas fa-sign-out-alt mr-1"></i>Cerrar sesión
                </button>
            </form>
        </div>

        <div class="card-body">
            <div class="row mb-4">
                <div class="col-12">
                    <h4 class="text-muted mb-4">Bienvenido, {{ Auth::user()->name ?? 'Usuario' }}</h4>
                </div>
            </div>

            <!-- Acciones Principales -->
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="fas fa-tasks fa-3x text-primary"></i>
                            </div>
                            <h4 class="card-title">Gestión de Tareas</h4>
                            <p class="card-text text-muted">Administra las tareas del sistema</p>
                            <div class="d-grid gap-2">
                                <a href="{{ route('ver-tareas') }}" class="btn btn-primary">
                                    <i class="fas fa-list mr-1"></i>Ver todas
                                </a>
                                <a href="{{ route('nueva-tarea') }}" class="btn btn-success">
                                    <i class="fas fa-plus mr-1"></i>Nueva tarea
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="fas fa-users fa-3x text-success"></i>
                            </div>
                            <h4 class="card-title">Gestión de Empleados</h4>
                            <p class="card-text text-muted">Administra los operarios</p>
                            <div class="d-grid gap-2">
                                <a href="{{ route('ver-empleados') }}" class="btn btn-primary">
                                    <i class="fas fa-list mr-1"></i>Ver todos
                                </a>
                                <a href="" class="btn btn-success">
                                    <i class="fas fa-plus mr-1"></i>Nuevo empleado
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="fas fa-user-tie fa-3x text-info"></i>
                            </div>
                            <h4 class="card-title">Gestión de Clientes</h4>
                            <p class="card-text text-muted">Administra los clientes</p>
                            <div class="d-grid gap-2">
                                <a href="{{ route('ver-clientes') }}" class="btn btn-primary">
                                    <i class="fas fa-list mr-1"></i>Ver todos
                                </a>
                                <a href="" class="btn btn-success">
                                    <i class="fas fa-plus mr-1"></i>Nuevo cliente
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
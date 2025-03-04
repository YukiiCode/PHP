@extends('plantilla')
@section('titulo', 'Inicio')
@section('contenido')
<div class="container mt-5">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center rounded-top-4">
            <h3 class="mb-0"><i class="fas fa-home me-2"></i>Panel de Control</h3>
            
        </div>
        <div class="card-body p-4">
            <div class="row mb-4">
                <div class="col-12">
                    <h4 class="text-muted mb-4">Bienvenido, {{ Auth::user()->empleado->nombre ?? 'Usuario' }}</h4>
                </div>
            </div>
            <!-- Acciones Principales -->
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0 rounded-4">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="fas fa-tasks fa-3x text-primary"></i>
                            </div>
                            <h4 class="card-title fw-bold">Gestión de Tareas</h4>
                            <p class="card-text text-muted small">Administra las tareas del sistema.</p>
                            <div class="d-grid gap-2">
                                <a href="{{ route('tareas.index') }}" class="btn btn-primary rounded-pill">
                                    <i class="fas fa-list me-1"></i>Ver todas
                                </a>
                                <a href="{{ route('tareas.create') }}" class="btn btn-success rounded-pill">
                                    <i class="fas fa-plus me-1"></i>Nueva tarea
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0 rounded-4">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="fas fa-users fa-3x text-success"></i>
                            </div>
                            <h4 class="card-title fw-bold">Gestión de Empleados</h4>
                            <p class="card-text text-muted small">Administra los operarios del sistema.</p>
                            <div class="d-grid gap-2">
                                <a href="{{ route('empleados.index') }}" class="btn btn-primary rounded-pill">
                                    <i class="fas fa-list me-1"></i>Ver todos
                                </a>
                                <a href="" class="btn btn-success rounded-pill">
                                    <i class="fas fa-plus me-1"></i>Nuevo empleado
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0 rounded-4">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="fas fa-user-tie fa-3x text-info"></i>
                            </div>
                            <h4 class="card-title fw-bold">Gestión de Clientes</h4>
                            <p class="card-text text-muted small">Administra los clientes del sistema.</p>
                            <div class="d-grid gap-2">
                                <a href="{{ route('clientes.index') }}" class="btn btn-primary rounded-pill">
                                    <i class="fas fa-list me-1"></i>Ver todos
                                </a>
                                <a href="{{ route('clientes.create') }}" class="btn btn-success rounded-pill">
                                    <i class="fas fa-plus me-1"></i>Nuevo cliente
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
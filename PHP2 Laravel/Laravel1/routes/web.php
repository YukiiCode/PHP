<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TareasController;
use App\Models\Utiles;

// Redirección de la raíz al login
Route::get('/', function () {
    header("Location: " . Utiles::getInstance()->myUrl('login'));
    exit();
});

// Rutas para añadir una nueva tarea
Route::get('/nueva-tarea', [FormController::class, 'mostrarFormulario'])->name('mostrar-formulario');
Route::post('/nueva-tarea', [FormController::class, 'validarFormulario'])->name('validar-formulario');

// Rutas de autenticación
Route::view('/login', 'login')->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('procesar-login');

// Ruta para la página de inicio
Route::view('/home', 'home')->name('home');

// Rutas de gestión de tareas
Route::get('/ver-tareas', [TareasController::class, 'mostrarTareas'])->name('ver-tareas');
Route::get('/tareas/editar/{id}', [TareasController::class, 'editarTarea'])->name('editar-tarea');
Route::post('/tareas/editar/{id}', [FormController::class, 'validarFormulario'])->name('validar-editar-tarea');
Route::delete('/tareas/eliminar/{id}', [TareasController::class, 'eliminarTarea'])->name('eliminar-tarea');
Route::get('/tareas-pendientes', [TareasController::class, 'tareasPendientes'])->name('tareas-pendientes');

// Ruta para cerrar sesión
Route::get('cerrar-sesion', [LoginController::class, 'logout'])->name('cerrar-sesion');
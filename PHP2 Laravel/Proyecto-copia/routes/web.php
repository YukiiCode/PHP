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
Route::get('/nueva-tarea', [FormController::class, 'mostrarFormulario']);
Route::post('/nueva-tarea', [FormController::class, 'validarFormulario']);

// Rutas de autenticación
Route::view('/login', 'login')->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('procesar-login');

// Ruta para la página de inicio
Route::view('/home', 'home')->name('home');

// Rutas de gestión de tareas
Route::get('/ver-tareas', [TareasController::class, 'mostrarTareas']);
Route::get('/tareas/editar/{id}', [TareasController::class, 'editarTarea']);
Route::post('/tareas/editar/{id}', [FormController::class, 'validarFormulario']);
// Ruta para mostrar la confirmación de eliminación
Route::get('/tareas/confirmar-eliminar/{id}', [TareasController::class, 'confirmarEliminarTarea']);
Route::get('/tareas-pendientes', [TareasController::class, 'tareasPendientes']);

// Ruta para cerrar sesión
Route::get('cerrar-sesion', [LoginController::class, 'logout']);

// Ruta no autorizado
Route::view('/no-autorizado', 'no_autorizado');

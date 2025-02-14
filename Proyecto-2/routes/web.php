<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TareasController;
use App\Http\Controllers\EmpleadosController;
use App\Http\Controllers\ClientesController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FileController;
use App\Http\Controllers\HomeController;

Route::get('/',  [HomeController::class, 'index'])->name('home');

Route::post('/guardar-empleado', [EmpleadosController::class, 'store'])->name('guardar-empleado');
Route::post('/guardar-cliente', [ClientesController::class, 'store'])->name('guardar-cliente');

Route::post('/upload', [FileController::class, 'upload'])->name('upload');

// Tareas
Route::get('/nueva-tarea', [TareasController::class, 'form'])->name('nueva-tarea');
Route::post('/nueva-tarea', [TareasController::class, 'store']);
Route::get('/editar-tarea/{id}', [TareasController::class, 'edit'])->name('editar-tarea');
Route::get('/borrar-tarea/{id}', [TareasController::class, 'borrarTarea'])->name('borrar-tarea');
Route::post('/actualizar-tarea/{id}', [TareasController::class, 'update'])->name('actualizar-tarea');

// Clientes
Route::get('/ver-clientes', [ClientesController::class, 'index'])->name('ver-clientes');
Route::get('/ver-cliente/{id}', [ClientesController::class, 'show'])->name('ver-cliente');
Route::get('/borrar-cliente/{id}', [ClientesController::class, 'borrarCliente'])->name('borrar-cliente');

// Empleados
Route::get('/ver-empleados', [EmpleadosController::class, 'index'])->name('ver-empleados');
Route::get('/borrar-empleado/{id}', [EmpleadosController::class, 'borrarEmpleado'])->name('borrar-empleado');

Route::get('/ver-tarea/{id}', [TareasController::class, 'verTareas'])->name('ver-tarea');
Route::get('/ver-tareas', [TareasController::class, 'index'])->name('ver-tareas');

Route::get('home', function () {
    return view('home');
})->name('home');

Route::get('/ayuda', function () {
    return view('ayuda');
})->name('ayuda');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

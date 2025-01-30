<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TareasController;
use App\Http\Controllers\EmpleadosController;
use App\Http\Controllers\ClientesController;

Route::get('/', function () {
    return view('home');
});

Route::get('/añadir-usuario', function () {
    return view('añadir_usuario');
})->name('añadir-usuario');

Route::post('/guardar-empleado', [EmpleadosController::class, 'store'])->name('guardar-empleado');
Route::post('/guardar-cliente', [ClientesController::class, 'store'])->name('guardar-cliente');


Route::get('/nueva-tarea', [TareasController::class, 'index'])->name('nueva-tarea');
Route::post('/nueva-tarea', [TareasController::class, 'store']);

Route::get('/tareas', [TareasController::class, 'index'])->name('tareas');


// Rutas para empleados
Route::get('/ver-empleados', [EmpleadosController::class, 'index'])->name('ver-empleados');
Route::get('/borrar-empleado/{id}', [EmpleadosController::class, 'borrarEmpleado'])->name('borrar-empleado');

Route::get('/ver-tarea/{id}', [TareasController::class, 'verTareas'])->name('ver-tarea');
Route::get('/ver-tareas', [TareasController::class, 'verTareas'])->name('ver-tareas');

Route::get('/borrar-tarea/{id}', [TareasController::class, 'borrarTarea'])->name('borrar-tarea');

Route::get('home', function () {
    return view('home');
})->name('home');

Route::get('/ayuda', function () {
    return view('ayuda');
})->name('ayuda');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

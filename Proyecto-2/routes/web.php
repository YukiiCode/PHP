<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Que_Tal_Estas;
use App\Http\Controllers\Ctrl1;
use App\Http\Controllers\TareasController;


Route::get('/', function () {
    return view('home');
});

Route::get('/nueva-tarea', [TareasController::class, 'index'])->name('nueva-tarea');
Route::post('/nueva-tarea', [TareasController::class, 'store']);

Route::get('/tareas', [TareasController::class, 'index'])->name('tareas');


Route::get('/ver-tarea/{id}', [TareasController::class, 'verTareas'])->name('ver-tarea');
Route::get('/ver-tareas', [TareasController::class, 'verTareas'])->name('ver-tareas');

Route::get('/borrar-tarea/{id}', [TareasController::class, 'borrarTarea'])->name('borrar-tarea');

Route::get('home', function () {
    return view('home');
})->name('home');

Route::get('/ayuda', function () {
    return view('ayuda');
})->name('ayuda');







// PRUEBAS 



Route::get('/u/{par0}/{parametro}', function ($par0, $parametro) {
    return 'Hello World' . $par0 . ' ' . $parametro;
});

Route::get('/adios', [Ctrl1::class, 'despedida'])->name('Adios');

Route::get('/hola', [Ctrl1::class, 'saludo'])->name('Hola');

Route::get('/cuenta/{num?}', [Que_Tal_Estas::class, 'CuentaNumeros'])->name('cuenta');

Route::get('/menu', function () {
    return view('inicio');
})->name('Menu');

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Que_Tal_Estas;
use App\Http\Controllers\Ctrl1;
use App\Http\Controllers\TareasController;




Route::get('/nueva-tarea', [TareasController::class, 'index'])->name('nueva-tarea');
Route::post('/nueva-tarea', [TareasController::class, 'store']);

Route::get('/tareas', [TareasController::class, 'index'])->name('tareas');

Route::get('/ver-tareas', [TareasController::class, 'verTareas'])->name('ver_tareas');

Route::get('/borrar-tarea/{id}', [TareasController::class, 'borrarTarea'])->name('borrar_tarea');










// PRUEBAS 

Route::get('/', function () {
    return 'Hello World' . '<br> <a href="' . route('Adios') . '">Adios mundo</a>' . '<br> <a href="' . route('Hola') . '">Hola mundo</a>' . '<br> <a href="' . route('Menu') . '">Menu</a>';
});

Route::get('/u/{par0}/{parametro}', function ($par0, $parametro) {
    return 'Hello World' . $par0 . ' ' . $parametro;
});

Route::get('/adios', [Ctrl1::class, 'despedida'])->name('Adios');

Route::get('/hola', [Ctrl1::class, 'saludo'])->name('Hola');

Route::get('/cuenta/{num?}', [Que_Tal_Estas::class, 'CuentaNumeros'])->name('cuenta');

Route::get('/menu', function () {
    return view('inicio');
})->name('Menu');

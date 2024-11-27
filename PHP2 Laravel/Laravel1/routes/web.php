<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/nueva-tarea', function () {
    return view('form_creacion_tareas');
});

Route::post('/nueva-tarea', function () {
    return view('form_creacion_tareas');
});

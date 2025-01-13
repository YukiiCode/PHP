<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Que_Tal_Estas;
use App\Http\Controllers\Ctrl1;

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

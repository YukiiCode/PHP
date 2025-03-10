<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TareasController;
use App\Http\Controllers\EmpleadosController;
use App\Http\Controllers\ClientesController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CuotasController;

// Rutas de Inicio
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/ayuda', function () { return view('ayuda'); })->name('ayuda');

// Rutas de Autenticación
Auth::routes();
Route::get('/change-password', [HomeController::class, 'showChangePasswordForm'])->name('change.password');
Route::post('/change-password', [HomeController::class, 'changePassword'])->name('change.password.update');
Route::get('/añadir-usuario', [HomeController::class, 'añadirUsuario'])->name('añadir-usuario');

// Rutas de Tareas
Route::prefix('tareas')->group(function () {
    Route::get('/', [TareasController::class, 'index'])->name('tareas.index');
    Route::get('/nueva', [TareasController::class, 'create'])->name('tareas.create');
    Route::post('/nueva', [TareasController::class, 'store'])->name('tareas.store');
    Route::get('/editar/{tarea}', [TareasController::class, 'edit'])->name('tareas.edit');
    Route::put('/actualizar/{tarea}', [TareasController::class, 'update'])->name('tareas.update');
    Route::delete('/borrar/{tarea}', [TareasController::class, 'destroy'])->name('tareas.destroy');
    Route::get('/ver/{id}', [TareasController::class, 'verTareas'])->name('tareas.show');
    Route::get('/acceso-cliente', [TareasController::class, 'indexClienteView'])->name('tareas.cliente-access');
    Route::post('/acceso-cliente', [TareasController::class, 'storeClienteTask'])->name('tareas.cliente-store');
    Route::get('/detalle-cliente/{id}', [TareasController::class, 'index'])->name('tareas.cliente-detail');
});

// Rutas de Empleados
Route::prefix('empleados')->group(function () {
    Route::get('/', [EmpleadosController::class, 'index'])->name('empleados.index');
    Route::get('/create', [EmpleadosController::class, 'create'])->name('empleados.create');
    Route::post('/', [EmpleadosController::class, 'store'])->name('empleados.store');
    Route::get('/{id}/edit', [EmpleadosController::class, 'edit'])->name('empleados.edit');
    Route::put('/{id}', [EmpleadosController::class, 'update'])->name('empleados.update');
    Route::delete('/{id}', [EmpleadosController::class, 'destroy'])->name('empleados.destroy');
    Route::get('/data', [EmpleadosController::class, 'data'])->name('empleados.data');
});

// Rutas de Clientes
Route::prefix('clientes')->group(function () {
    Route::get('/', [ClientesController::class, 'index'])->name('clientes.index');
    Route::get('/create', [ClientesController::class, 'create'])->name('clientes.create');
    Route::post('/', [ClientesController::class, 'store'])->name('clientes.store');
    Route::get('/{id}', [ClientesController::class, 'show'])->name('clientes.show');
    Route::get('/{id}/edit', [ClientesController::class, 'edit'])->name('clientes.edit');
    Route::put('/{id}', [ClientesController::class, 'update'])->name('clientes.update');
    Route::delete('/{id}', [ClientesController::class, 'destroy'])->name('clientes.destroy');
});

// Rutas de Cuotas
Route::prefix('cuotas')->group(function () {
    Route::get('/', [CuotasController::class, 'index'])->name('cuotas.index');
    Route::get('/create', [CuotasController::class, 'create'])->name('cuotas.create');
    Route::post('/', [CuotasController::class, 'store'])->name('cuotas.store');
    Route::get('/batch', [CuotasController::class, 'batchCreate'])->name('cuotas.batch.create');
    Route::post('/batch', [CuotasController::class, 'batchStore'])->name('cuotas.batch.store');
    Route::get('/{cuota}/pdf', [CuotasController::class, 'generatePdf'])->name('cuotas.pdf');
    Route::get('/{cuota}/download', [CuotasController::class, 'download'])->name('cuotas.download');
    Route::post('/{cuota}/email', [CuotasController::class, 'email'])->name('cuotas.email');
    Route::get('/{cuota}/edit', [CuotasController::class, 'edit'])->name('cuotas.edit');
    Route::put('/{cuota}', [CuotasController::class, 'update'])->name('cuotas.update');
    Route::delete('/{cuota}', [CuotasController::class, 'destroy'])->name('cuotas.destroy');
});

// Rutas de PayPal
Route::prefix('paypal')->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class])->group(function () {
    Route::post('/payment/{cuota}', [CuotasController::class, 'handlePayPalPayment'])->name('paypal.payment');
    Route::get('/success', [CuotasController::class, 'paypalSuccess'])->name('paypal.success');
    Route::get('/cancel', [CuotasController::class, 'paypalCancel'])->name('paypal.cancel');
});

// Ruta de Subida de Archivos
Route::post('/upload', [FileController::class, 'upload'])->name('upload');

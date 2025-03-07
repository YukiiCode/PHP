<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TareasController;
use App\Http\Controllers\EmpleadosController;
use App\Http\Controllers\ClientesController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CuotasController;

Route::get('/',  [HomeController::class, 'index'])->name('home');

Route::post('/guardar-empleado', [EmpleadosController::class, 'store'])->name('empleados.store');


Route::post('/upload', [FileController::class, 'upload'])->name('upload');

// Tareas
Route::get('/nueva-tarea', [TareasController::class, 'create'])->name('tareas.create');
Route::post('/nueva-tarea', [TareasController::class, 'store'])->name('tareas.store');
Route::get('/editar-tarea/{tarea}', [TareasController::class, 'edit'])->name('tareas.edit');
Route::put('/actualizar-tarea/{tarea}', [TareasController::class, 'update'])->name('tareas.update');
Route::delete('/borrar-tarea/{tarea}', [TareasController::class, 'destroy'])->name('tareas.destroy');

// Empleados CRUD
Route::resource('empleados', EmpleadosController::class)->except(['create']);
Route::get('empleados/data', [EmpleadosController::class, 'data'])->name('empleados.data');
Route::get('/empleados/create', [EmpleadosController::class, 'create'])->name('empleados.create');

// Clientes CRUD
Route::resource('clientes', \App\Http\Controllers\ClientesController::class);

Route::get('/acceso-cliente', [TareasController::class, 'indexClienteView'])->name('tareas.cliente-access');
Route::post('/acceso-cliente', [TareasController::class, 'storeClienteTask'])->name('tareas.cliente-store');
Route::get('/ver-tareas/detalle-cliente/{id}',[TareasController::class, 'index'])->name('tareas.cliente-detail');

// Clientes
Route::get('/ver-clientes', [ClientesController::class, 'index'])->name('clientes.index');
Route::get('/ver-cliente/{id}', [ClientesController::class, 'show'])->name('clientes.show');
Route::get('/nuevo-cliente', [ClientesController::class, 'create'])->name('clientes.create');
Route::get('/editar-cliente/{id}', [ClientesController::class, 'edit'])->name('clientes.edit');
Route::put('/actualizar-cliente/{id}', [ClientesController::class, 'update'])->name('clientes.update');
Route::delete('/eliminar-cliente/{id}', [ClientesController::class, 'destroy'])->name('clientes.destroy');
Route::get('/borrar-cliente/{id}', [ClientesController::class, 'borrarCliente'])->name('clientes.delete');

// Empleados
Route::get('/ver-empleados', [EmpleadosController::class, 'index'])->name('empleados.index');
Route::get('/nuevo-empleado', [EmpleadosController::class, 'create'])->name('empleados.create');
Route::get('/editar-empleado/{id}', [EmpleadosController::class, 'edit'])->name('empleados.edit');
Route::put('/actualizar-empleado/{id}', [EmpleadosController::class, 'update'])->name('empleados.update');
Route::get('/borrar-empleado/{id}', [EmpleadosController::class, 'borrarEmpleado'])->name('empleados.delete');

Route::get('/ver-tarea/{id}', [TareasController::class, 'verTareas'])->name('tareas.show');
Route::get('/ver-tareas', [TareasController::class, 'index'])->name('tareas.index');
Route::get('/ver-cliente/{id}', [ClientesController::class, 'show'])->name('ver-cliente');
Route::delete('/empleados/{id}', [EmpleadosController::class, 'destroy'])->name('empleados.destroy');
Route::post('/cuotas/batch', [CuotasController::class, 'storeBatch'])->name('cuotas.storeBatch');

Route::get('home', function () {
    return view('home');
})->name('home');

Route::get('/ayuda', function () {
    return view('ayuda');
})->name('ayuda');

Auth::routes();


Route::get('/change-password', [HomeController::class, 'showChangePasswordForm'])->name('change.password');
Route::post('/change-password', [HomeController::class, 'changePassword'])->name('change.password.update');

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Añadir usuario routes
Route::get('/añadir-usuario', [HomeController::class, 'añadirUsuario'])->name('añadir-usuario');

// Cuotas routes
Route::get('/cuotas', [CuotasController::class, 'index'])->name('cuotas.index');
Route::get('/cuotas/create', [CuotasController::class, 'create'])->name('cuotas.create');
Route::post('/cuotas', [CuotasController::class, 'store'])->name('cuotas.store');
Route::get('/cuotas/batch', [CuotasController::class, 'batchCreate'])->name('cuotas.batch.create');
Route::post('/cuotas/batch', [CuotasController::class, 'batchStore'])->name('cuotas.batch.store');
Route::get('/cuotas/{cuota}/pdf', [CuotasController::class, 'generatePdf'])->name('cuotas.pdf');
Route::get('/cuotas/{cuota}/download', [CuotasController::class, 'download'])->name('cuotas.download');
Route::post('/cuotas/{cuota}/email', [CuotasController::class, 'email'])->name('cuotas.email');
Route::get('/cuotas/{cuota}/edit', [CuotasController::class, 'edit'])->name('cuotas.edit');
Route::put('/cuotas/{cuota}', [CuotasController::class, 'update'])->name('cuotas.update');
Route::delete('/cuotas/{cuota}', [CuotasController::class, 'destroy'])->name('cuotas.destroy');

// PayPal Payment Routes
Route::post('/paypal/payment/{cuota}', [CuotasController::class, 'handlePayPalPayment'])->name('paypal.payment');
Route::get('/paypal/success', [CuotasController::class, 'paypalSuccess'])->name('paypal.success');
Route::get('/paypal/cancel', [CuotasController::class, 'paypalCancel'])->name('paypal.cancel');

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\TareasController;
use App\Http\Controllers\EmpleadosController;
use App\Http\Controllers\ClientesController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CuotasController;

Route::resource('cuotas', CuotasController::class);

Route::prefix('cuotas')->group(function() {
    Route::get('batch', [CuotasController::class, 'batchCreate'])->name('cuotas.batch');
    Route::post('batch', [CuotasController::class, 'batchStore'])->name('cuotas.storeBatch');
    
    Route::get('{cuota}/pdf', [CuotasController::class, 'generatePdf'])->name('cuotas.pdf');
    Route::post('{cuota}/email', [CuotasController::class, 'sendEmail'])->name('cuotas.email');
});

Route::get('/',  [HomeController::class, 'index'])->name('home');

Route::post('/guardar-empleado', [EmpleadosController::class, 'store'])->name('guardar-empleado');
Route::delete('/empleados/{id}', [EmpleadosController::class, 'destroy'])->name('empleados.destroy');
Route::post('/guardar-cliente', [ClientesController::class, 'store'])->middleware(['auth', 'admin'])->name('guardar-cliente');

Route::post('/upload', [FileController::class, 'upload'])->name('upload');

// Tareas
Route::get('/nueva-tarea', [TareasController::class, 'form'])->name('nueva-tarea');
Route::post('/nueva-tarea', [TareasController::class, 'store']);
Route::get('/editar-tarea/{id}', [TareasController::class, 'edit'])->name('editar-tarea');
Route::get('/confirmar-borrado-tarea/{id}', [TareasController::class, 'index'])->name('confirmar-borrado-tarea');
Route::delete('/borrar-tarea/{id}', [TareasController::class, 'borrarTarea'])->name('borrar-tarea');
Route::post('/actualizar-tarea/{id}', [TareasController::class, 'update'])->name('actualizar-tarea');
Route::get('/acceso-cliente', [TareasController::class, 'indexClienteView'])->name('acceso-cliente');
Route::get('/ver-tareas/detalle-cliente/{id}',[TareasController::class, 'index'])->name('tarea.detalle-cliente');

// Clientes
Route::get('/ver-clientes', [ClientesController::class, 'index'])->name('ver-clientes')->middleware(['auth', 'can:admin']);
Route::get('/ver-cliente/{id}', [ClientesController::class, 'show'])->name('ver-cliente');
// Removed invalid borrarCliente route

// Empleados
Route::get('/ver-empleados', [EmpleadosController::class, 'index'])->name('ver-empleados');
Route::get('/empleados/{empleado}/edit', [App\Http\Controllers\EmpleadosController::class, 'edit'])->name('empleados.edit');
Route::put('/empleados/{empleado}', [App\Http\Controllers\EmpleadosController::class, 'update'])->name('empleados.update');
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

// Password Change Routes
Route::get('/change-password', [ChangePasswordController::class, 'show'])->name('change.password');
Route::post('/change-password', [ChangePasswordController::class, 'update'])->name('change.password.update');

Route::middleware(['auth'])->group(function() {
    Route::get('/clientes/nuevo', [ClientesController::class, 'create'])->name('nuevo-cliente');
    Route::post('/clientes', [ClientesController::class, 'store'])->name('guardar-cliente');
    Route::delete('/clientes/{id}', [ClientesController::class, 'destroy'])->name('eliminar-cliente');
Route::put('/clientes/{id}', [ClientesController::class, 'update'])->name('actualizar-cliente');
Route::get('/clientes/{id}/edit', [ClientesController::class, 'edit'])->name('editar-cliente');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');
// Cuotas
Route::get('/cuotas', [CuotasController::class, 'index'])->name('cuotas.index');
Route::get('/cuotas/create', [CuotasController::class, 'create'])->name('cuotas.create');
Route::post('/cuotas', [CuotasController::class, 'store'])->name('cuotas.store');
Route::get('/cuotas/{cuota}/pdf', [CuotasController::class, 'generatePdf'])->name('cuotas.pdf');
Route::post('/cuotas/{cuota}/email', [CuotasController::class, 'sendEmail'])->name('cuotas.email');
Route::get('/cuotas/{cuota}/edit', [CuotasController::class, 'edit'])->name('cuotas.edit');
Route::put('/cuotas/{cuota}', [CuotasController::class, 'update'])->name('cuotas.update');
Route::delete('/cuotas/{cuota}', [CuotasController::class, 'destroy'])->name('cuotas.destroy');
Route::post('/cuotas/{cuota}/email', [CuotasController::class, 'sendEmail'])->name('cuotas.email');
Route::get('/cuotas/{cuota}/edit', [CuotasController::class, 'edit'])->name('cuotas.edit');
Route::put('/cuotas/{cuota}', [CuotasController::class, 'update'])->name('cuotas.update');
Route::delete('/cuotas/{cuota}', [CuotasController::class, 'destroy'])->name('cuotas.destroy');

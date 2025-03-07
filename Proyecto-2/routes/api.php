<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TareaController;

Route::group(['prefix' => 'tareas', 'namespace' => 'Api', 'middleware' => 'api'], function () {
    Route::get('/', [TareaController::class, 'index']);
    Route::post('/', [TareaController::class, 'store']);
    Route::get('/{id}', [TareaController::class, 'show']);
    Route::put('/{id}', [TareaController::class, 'update']);
    Route::delete('/{id}', [TareaController::class, 'destroy']);
});
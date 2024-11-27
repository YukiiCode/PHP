<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TareasCtrl;


Route::any('/', [TareasCtrl::class, 'Index']);
Route::any('/index', [TareasCtrl::class, 'Index']);

Route::any('/listar', [TareasCtrl::class, 'Listar']);
Route::any('/edit', [TareasCtrl::class, 'Edit']);

Route::any('/uno', function () {
    echo "<p>Ruta uno";
});




/**
 * Devuelve el valor de una variable enviada por POST. Devolverá el valor
 * por defecto en caso de no existir.
 *
 * @param string $campo
 * @param string $default   Valor por defecto en caso de no existir
 * @return string
 */
function VPost($campo, $default='')
{
    if (isset($_POST[$campo]))
    {
        return $_POST[$campo];
    }
    else
    {
        return $default;
    }
}



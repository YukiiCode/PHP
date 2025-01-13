<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Que_Tal_Estas extends Controller
{
    public function CuentaNumeros(?int $num = null)
    {
        $resultado = "";
        $aux = 1;
        if ($num === null) {
            $num = 10;
            while ($aux <= $num) {
                $resultado .= $aux . " ";
                $aux++;
            }
        } else {
            while ($aux <= $num) {
                $resultado .= ($aux % 10 == 0) ? "$aux<br>" : $aux . " ";
                $aux++;
            }
        }
        return $resultado;
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Ctrl1 extends Controller
{
    function despedida()
    {
        return 'Adios mundo';
    }

    function saludo()
    {
        return 'Hola mundo';
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function upload(Request $request)
    {
        $path = $request->file('file')->store('uploads');
        return back()->with('success', 'Archivo subido con éxito. Ruta: ' . $path);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    protected $table = 'tareas';
    protected $fillable = ['id', 'estado', 'operario_id', 'fecha_creacion', 'fecha_finalizacion', 'anotaciones', 'cliente_id'];
    public $timestamps = false;

    public function cliente()
    {
        return $this->belongsTo('App\Models\Cliente', 'id_cliente');
    }

    public function getArchivosAttribute()
    {
        $archivos = [];

        // Agregar el fichero resumen si existe
        if (!empty($this->fichero_resumen)) {
            $archivos[] = (object) ['ruta' => $this->fichero_resumen];
        }

        // Agregar cada foto del trabajo si existe
        $fotos = json_decode($this->fotos_trabajo, true);
        if (is_array($fotos)) {
            foreach ($fotos as $foto) {
                $archivos[] = (object) ['ruta' => $foto];
            }
        }

        return $archivos;
    }
}

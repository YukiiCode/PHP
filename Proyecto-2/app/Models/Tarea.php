<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    protected $table = 'tareas';
    protected $fillable = ['id','estado','operario_id','fecha_creacion','fecha_finalizacion','anotaciones','cliente_id'];
    public $timestamps = false;

    public function cliente()
    {
        return $this->belongsTo('App\Models\Cliente', 'id_cliente');
    }
}

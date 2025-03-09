<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';
    protected $guarded = [];
    public $timestamps = false;

    public function usuario()
    {
        // Relación comentada ya que no existe el campo id_usuario en la tabla clientes
        // según el esquema de la base de datos
        // return $this->belongsTo('App\Models\User', 'id_usuario');
        return null;
    }

    public function tareas()
    {
        return $this->hasMany('App\Models\Tarea', 'cliente_id');
    }

    public function cuotas()
    {
        return $this->hasMany('App\Models\Cuotas', 'cliente_id');
    }
}

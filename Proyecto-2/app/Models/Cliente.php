<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';
    protected $fillable = ['id', 'nombre', 'apellidos', 'direccion', 'telefono', 'email', 'fecha_nacimiento', 'id_usuario'];
    public $timestamps = false;

    public function usuario()
    {
        return $this->belongsTo('App\Models\Usuario', 'id_usuario');
    }

    public function tareas()
    {
        return $this->hasMany('App\Models\Tarea', 'id_cliente');
    }

    public function cuotas()
    {
        return $this->hasMany('App\Models\Cuotas', 'cliente_id');
    }
}

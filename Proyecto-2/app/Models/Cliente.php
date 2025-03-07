<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';
    protected $fillable = ['id', 'cif', 'nombre', 'telefono', 'correo', 'cuenta_corriente', 'pais', 'moneda', 'importe_mensual'];
    public $timestamps = false;

    public function usuario()
    {
        // Relationship commented out as there's no id_usuario field in the clientes table
        // according to the database schema
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

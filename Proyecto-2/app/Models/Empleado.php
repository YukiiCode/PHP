<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Empleado extends Model
{
    protected $table = 'empleados';
    protected $fillable = ['id','nombre','apellidos','direccion','telefono','email','fecha_nacimiento','id_usuario'];
    public $timestamps = false;

    public function usuario()
    {
        return $this->belongsTo('App\Models\Usuario', 'id_usuario');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tareas()
    {
        return $this->hasMany('App\Models\Tarea', 'id_empleado');
    }
}

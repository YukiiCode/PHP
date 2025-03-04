<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Empleado extends Model
{
    use HasFactory;

    protected $casts = [
        'fecha_alta' => 'datetime'
    ];

    protected $table = 'empleados';
    protected $fillable = ['id','nombre','dni','direccion','telefono','correo','fecha_alta','tipo','user_id'];
    public $timestamps = false;

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tareas()
    {
        return $this->hasMany(Tarea::class, 'id_empleado');
    }
}

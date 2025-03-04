<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cuotas extends Model
{
 
    protected $table = 'cuotas';
    protected $fillable = ['cliente_id', 'empleado_id', 'concepto', 'importe', 'tipo', 'fecha_emision', 'fecha_pago', 'pagado', 'notas', 'estado'];
    public $timestamps = false;

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id');
    }
    protected $casts = [
        'fecha_emision' => 'date',
        'fecha_pago' => 'date',
    ];
}


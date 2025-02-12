<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cuotas extends Model
{
    protected $table = 'cuotas';
    protected $guarded = [];
    public $timestamps = false;

    public function cliente(){
        return $this->belongsTo('App\Models\Cliente', 'cliente_id');
    }

    public function empleado(){
        return $this->belongsTo('App\Models\Empleado', 'empleado_id');
    }

}


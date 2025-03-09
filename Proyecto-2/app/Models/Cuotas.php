<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\CurrencyConverter;

class Cuotas extends Model
{
 
    protected $table = 'cuotas';
    protected $guarded = [];
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
    
    /**
     * Get the amount converted to euros
     *
     * @return float
     */
    public function getImporteEnEuros()
    {
        // If client doesn't have a currency set or it's already in euros, return the original amount
        if (!$this->cliente || !$this->cliente->moneda || $this->cliente->moneda === 'EUR') {
            return $this->importe;
        }
        
        // Use the singleton currency converter to convert to euros
        $converter = CurrencyConverter::getInstance();
        return $converter->convertToEuro($this->importe, $this->cliente->moneda);
    }
}


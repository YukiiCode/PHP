<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Tarea",
 *     title="Task",
 *     description="Task model",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="estado", type="string", enum={"F","T","C","A","E"}),
 *     @OA\Property(property="operario_id", type="integer"),
 *     @OA\Property(property="cliente_id", type="integer"),
 *     @OA\Property(property="fecha_creacion", type="string", format="date-time"),
 *     @OA\Property(property="fecha_finalizacion", type="string", format="date-time", nullable=true)
 * )
 */
class Tarea extends Model
{
    protected $table = 'tareas';
    protected $guarded = [];
    public $timestamps = false;
    protected $casts = [
        'fotos_trabajo' => 'array', // Convierte el JSON a un array automáticamente
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function empleado()
    {
        return $this->belongsTo('App\Models\Empleado', 'operario_id');
    }


    public function getArchivosAttribute()
    {
        $archivos = [];

        // Agregar el fichero resumen si existe
        if (!empty($this->fichero_resumen)) {
            $archivos[] = (object) ['ruta' => $this->fichero_resumen];
        }

        // Agregar cada foto del trabajo si existe
        $fotos = $this->fotos_trabajo;

        // Handle single photo or array of photos
        if (!empty($fotos)) {
            if (is_string($fotos)) {
                // If it's a JSON string, try to decode it
                $fotosArray = json_decode($fotos);
                if (json_last_error() === JSON_ERROR_NONE) {
                    // If it's a valid JSON
                    $fotos = $fotosArray;
                }
            }

            // If it's still a string (single photo path)
            if (is_string($fotos)) {
                $archivos[] = (object) ['ruta' => $fotos];
            } 
            // If it's an array (multiple photos)
            elseif (is_array($fotos)) {
                foreach ($fotos as $foto) {
                    if (!empty($foto)) {
                        $archivos[] = (object) ['ruta' => $foto];
                    }
                }
            }
        }

        return $archivos;
    }
}

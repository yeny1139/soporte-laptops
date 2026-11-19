<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reparacion extends Model
{
    use HasFactory;

    protected $table = 'reparaciones';

    protected $fillable = [
        'orden_servicio_id', 'diagnostico_tecnico',
        'solucion_aplicada', 'costo_servicio', 'observaciones',
    ];

    protected function casts(): array
    {
        return ['costo_servicio' => 'decimal:2'];
    }

    public function ordenServicio(): BelongsTo
    {
        return $this->belongsTo(OrdenServicio::class, 'orden_servicio_id');
    }
}
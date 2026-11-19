<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrdenServicio extends Model
{
    use HasFactory;

    protected $table = 'ordenes_servicio';

    protected $fillable = [
        'cliente_id', 'tecnico_id', 'marca_laptop', 'modelo_laptop',
        'numero_serie', 'fecha_ingreso', 'fecha_entrega_estimada',
        'problema_reportado', 'estado',
    ];

    protected function casts(): array
    {
        return [
            'fecha_ingreso'          => 'datetime',
            'fecha_entrega_estimada' => 'datetime',
        ];
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function tecnico(): BelongsTo
    {
        return $this->belongsTo(Tecnico::class);
    }

    public function reparacion(): HasOne
    {
        return $this->hasOne(Reparacion::class, 'orden_servicio_id');
    }
}
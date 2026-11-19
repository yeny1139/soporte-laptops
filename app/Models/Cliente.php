<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'dni', 'nombres', 'apellidos',
        'telefono', 'email', 'direccion',
    ];

    public function ordenes(): HasMany
    {
        return $this->hasMany(OrdenServicio::class);
    }

    // Historial técnico: reparaciones del cliente a través de sus órdenes de servicio
    public function reparaciones(): HasManyThrough
    {
        return $this->hasManyThrough(
            Reparacion::class,
            OrdenServicio::class,
            'cliente_id',        // FK en ordenes_servicio
            'orden_servicio_id'  // FK en reparaciones
        );
    }
}
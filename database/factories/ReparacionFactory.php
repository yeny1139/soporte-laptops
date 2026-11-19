<?php

namespace Database\Factories;

use App\Models\OrdenServicio;
use App\Models\Reparacion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Reparacion>
 */
class ReparacionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'orden_servicio_id'   => OrdenServicio::factory()->state(['estado' => 'reparada']),
            'diagnostico_tecnico' => fake()->randomElement([
                'Falla en circuito de carga de placa madre y sulfatación leve.',
                'Pasta térmica seca y obstrucción total de disipador por polvo.',
                'Cable flex de pantalla dañado en la zona de la bisagra izquierda.',
                'Sectores dañados en unidad SSD y corrupción del arranque de Windows.',
                'Batería degradada al 18% de su capacidad original.',
            ]),
            'solucion_aplicada'   => fake()->randomElement([
                'Limpieza ultrasónica, resoldado de línea de carga y pruebas de estrés.',
                'Mantenimiento preventivo completo y cambio de pasta térmica de alto rendimiento.',
                'Reemplazo de cable flex de video y ajuste de bisagras.',
                'Cambio de unidad SSD NVMe e instalación limpia de sistema operativo y drivers.',
                'Reemplazo de batería original y calibración de energía.',
            ]),
            'costo_servicio'      => fake()->randomFloat(2, 50, 450),
            'observaciones'       => fake()->optional(0.6)->sentence(),
        ];
    }
}
<?php

namespace Database\Factories;

use App\Models\Tecnico;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Tecnico>
 */
class TecnicoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id'        => null,
            'dni'            => fake()->unique()->numerify('########'),
            'nombres'        => fake()->firstName(),
            'apellidos'      => fake()->lastName() . ' ' . fake()->lastName(),
            'especialidad'   => fake()->randomElement([
                'Hardware y Placas Base',
                'Sistemas Operativos y Software',
                'Pantallas y Bisagras',
                'Mantenimiento Térmico y Limpieza',
                'Redes y Conectividad',
            ]),
            'codigo_tecnico' => 'TEC-' . fake()->unique()->numerify('###'),
            'activo'         => true,
        ];
    }

    public function inactivo(): static
    {
        return $this->state(fn (array $attributes) => [
            'activo' => false,
        ]);
    }
}
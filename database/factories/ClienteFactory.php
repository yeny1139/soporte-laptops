<?php

namespace Database\Factories;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Cliente>
 */
class ClienteFactory extends Factory
{
    public function definition(): array
    {
        return [
            'dni'       => fake()->unique()->numerify('########'),
            'nombres'   => fake()->firstName(),
            'apellidos' => fake()->lastName() . ' ' . fake()->lastName(),
            'telefono'  => '9' . fake()->numerify('########'),
            'email'     => fake()->unique()->safeEmail(),
            'direccion' => fake()->streetAddress(),
        ];
    }
}
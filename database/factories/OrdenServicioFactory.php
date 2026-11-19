<?php

namespace Database\Factories;

use App\Models\Cliente;
use App\Models\OrdenServicio;
use App\Models\Tecnico;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OrdenServicio>
 */
class OrdenServicioFactory extends Factory
{
    public function definition(): array
    {
        $fechaIngreso = fake()->dateTimeBetween('-15 days', 'now');
        $fechaEntrega = (clone $fechaIngreso)->modify('+' . fake()->numberBetween(2, 7) . ' days');

        $marcasModelos = [
            'Lenovo' => ['ThinkPad T14', 'IdeaPad Slim 5', 'Legion 5 Pro'],
            'HP'     => ['Pavilion 15', 'ProBook 450 G9', 'Victus 16'],
            'Dell'   => ['Inspiron 15 3520', 'Latitude 5430', 'XPS 13'],
            'Asus'   => ['VivoBook 15', 'TUF Gaming F15', 'ZenBook 14'],
            'Acer'   => ['Aspire 5', 'Nitro V 15', 'Swift Go 14'],
        ];

        $marca = fake()->randomElement(array_keys($marcasModelos));
        $modelo = fake()->randomElement($marcasModelos[$marca]);

        return [
            'cliente_id'             => Cliente::factory(),
            'tecnico_id'             => Tecnico::factory(),
            'marca_laptop'           => $marca,
            'modelo_laptop'          => $modelo,
            'numero_serie'           => strtoupper(fake()->bothify('SN-????########')),
            'fecha_ingreso'          => $fechaIngreso,
            'fecha_entrega_estimada' => $fechaEntrega,
            'problema_reportado'     => fake()->randomElement([
                'No enciende al presionar el botón de poder',
                'Sobrecalentamiento y apagado repentino tras 15 minutos',
                'Pantalla parpadea o muestra líneas verticales',
                'Teclado con varias teclas sin respuesta',
                'Batería no carga y solo funciona conectada al cargador',
                'Lentitud extrema del sistema operativo y ruidos en ventilador',
            ]),
            'estado'                 => 'pendiente',
        ];
    }
}
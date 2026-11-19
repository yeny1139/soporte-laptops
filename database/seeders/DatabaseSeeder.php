<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\OrdenServicio;
use App\Models\Reparacion;
use App\Models\Tecnico;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Usuario Administrador
        User::factory()->create([
            'name'     => 'Administrador Taller',
            'email'    => 'admin@soporte.test',
            'password' => 'password',
            'rol'      => 'administrador',
        ]);

        // 2. Usuario Recepción
        User::factory()->create([
            'name'     => 'Recepción Taller',
            'email'    => 'recepcion@soporte.test',
            'password' => 'password',
            'rol'      => 'recepcion',
        ]);

        // 3. Usuario Técnico vinculado a su ficha en tecnicos
        $userTecnico = User::factory()->create([
            'name'     => 'Carlos Mendoza',
            'email'    => 'tecnico@soporte.test',
            'password' => 'password',
            'rol'      => 'tecnico',
        ]);

        $tecnicoPrincipal = Tecnico::factory()->create([
            'user_id'        => $userTecnico->id,
            'dni'            => '45128934',
            'nombres'        => 'Carlos',
            'apellidos'      => 'Mendoza Quispe',
            'especialidad'   => 'Hardware y Placas Base',
            'codigo_tecnico' => 'TEC-001',
            'activo'         => true,
        ]);

        // 4. Técnicos adicionales (2 activos + 1 inactivo)
        $tecnicosActivos = Tecnico::factory()->count(2)->create();
        $todosActivos = $tecnicosActivos->push($tecnicoPrincipal);

        Tecnico::factory()->inactivo()->create([
            'codigo_tecnico' => 'TEC-099',
        ]);

        // 5. Clientes de prueba
        $clientes = Cliente::factory()->count(8)->create();

        // 6. Órdenes de servicio en distintos estados
        foreach (['pendiente', 'en_proceso', 'cancelada'] as $estado) {
            OrdenServicio::factory()
                ->count(3)
                ->recycle($clientes)
                ->recycle($todosActivos)
                ->create(['estado' => $estado]);
        }

        // 7. Órdenes reparadas con su respectiva reparación registrada (RN05)
        $ordenesReparadas = OrdenServicio::factory()
            ->count(5)
            ->recycle($clientes)
            ->recycle($todosActivos)
            ->create(['estado' => 'reparada']);

        foreach ($ordenesReparadas as $orden) {
            Reparacion::factory()->create([
                'orden_servicio_id' => $orden->id,
            ]);
        }
    }
}
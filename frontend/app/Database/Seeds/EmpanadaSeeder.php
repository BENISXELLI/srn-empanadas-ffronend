<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class EmpanadaSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name'       => 'Pino',
                'type'       => 'Horno',
                'filling'    => 'Carne, cebolla, huevo, aceituna',
                'price'      => 1800,
                'is_sold_out'=> false,
            ],
            [
                'name'       => 'Queso',
                'type'       => 'Frita',
                'filling'    => 'Queso',
                'price'      => 1500,
                'is_sold_out'=> false,
            ],
            [
                'name'       => 'Vegetariana',
                'type'       => 'Horno',
                'filling'    => 'Champiñón, choclo, aceituna',
                'price'      => 1700,
                'is_sold_out'=> false,
            ],
            [
                'name'       => 'Camarón queso',
                'type'       => 'Frita',
                'filling'    => 'Camarón y queso',
                'price'      => 2200,
                'is_sold_out'=> true,
            ],
        ];

        // Insertar en la tabla empanadas
        $this->db->table('empanadas')->insertBatch($data);
    }
}

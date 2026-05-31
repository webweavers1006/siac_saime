<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Seeder for table: sgc_estados (26 rows)
 * Generated from existing database data
 */
class EstadosSeeder extends Seeder
{
    public function run()
    {
        $this->db->query('TRUNCATE TABLE sgc_estados RESTART IDENTITY CASCADE');

        $this->db->table('sgc_estados')->insertBatch([
            [
                'estadoid' => 1,
                'estadonom' => 'Amazonas',
                'paisid' => 1,
                'borrado' => false,
            ],
            [
                'estadoid' => 2,
                'estadonom' => 'Anzoátegui',
                'paisid' => 1,
                'borrado' => false,
            ],
            [
                'estadoid' => 3,
                'estadonom' => 'Apure',
                'paisid' => 1,
                'borrado' => false,
            ],
            [
                'estadoid' => 4,
                'estadonom' => 'Aragua',
                'paisid' => 1,
                'borrado' => false,
            ],
            [
                'estadoid' => 5,
                'estadonom' => 'Barinas',
                'paisid' => 1,
                'borrado' => false,
            ],
            [
                'estadoid' => 6,
                'estadonom' => 'Bolívar',
                'paisid' => 1,
                'borrado' => false,
            ],
            [
                'estadoid' => 7,
                'estadonom' => 'Carabobo',
                'paisid' => 1,
                'borrado' => false,
            ],
            [
                'estadoid' => 8,
                'estadonom' => 'Cojedes',
                'paisid' => 1,
                'borrado' => false,
            ],
            [
                'estadoid' => 9,
                'estadonom' => 'Delta Amacuro',
                'paisid' => 1,
                'borrado' => false,
            ],
            [
                'estadoid' => 10,
                'estadonom' => 'Falcón',
                'paisid' => 1,
                'borrado' => false,
            ],
            [
                'estadoid' => 11,
                'estadonom' => 'Guárico',
                'paisid' => 1,
                'borrado' => false,
            ],
            [
                'estadoid' => 12,
                'estadonom' => 'Lara',
                'paisid' => 1,
                'borrado' => false,
            ],
            [
                'estadoid' => 13,
                'estadonom' => 'Mérida',
                'paisid' => 1,
                'borrado' => false,
            ],
            [
                'estadoid' => 14,
                'estadonom' => 'Miranda',
                'paisid' => 1,
                'borrado' => false,
            ],
            [
                'estadoid' => 15,
                'estadonom' => 'Monagas',
                'paisid' => 1,
                'borrado' => false,
            ],
            [
                'estadoid' => 16,
                'estadonom' => 'Nueva Esparta',
                'paisid' => 1,
                'borrado' => false,
            ],
            [
                'estadoid' => 17,
                'estadonom' => 'Portuguesa',
                'paisid' => 1,
                'borrado' => false,
            ],
            [
                'estadoid' => 18,
                'estadonom' => 'Sucre',
                'paisid' => 1,
                'borrado' => false,
            ],
            [
                'estadoid' => 19,
                'estadonom' => 'Táchira',
                'paisid' => 1,
                'borrado' => false,
            ],
            [
                'estadoid' => 20,
                'estadonom' => 'Trujillo',
                'paisid' => 1,
                'borrado' => false,
            ],
            [
                'estadoid' => 21,
                'estadonom' => 'La Guaira',
                'paisid' => 1,
                'borrado' => false,
            ],
            [
                'estadoid' => 22,
                'estadonom' => 'Yaracuy',
                'paisid' => 1,
                'borrado' => false,
            ],
            [
                'estadoid' => 23,
                'estadonom' => 'Zulia',
                'paisid' => 1,
                'borrado' => false,
            ],
            [
                'estadoid' => 24,
                'estadonom' => 'Distrito Capital',
                'paisid' => 1,
                'borrado' => false,
            ],
            [
                'estadoid' => 25,
                'estadonom' => 'Dependencias Federales',
                'paisid' => 1,
                'borrado' => false,
            ],
            [
                'estadoid' => 26,
                'estadonom' => 'N/A',
                'paisid' => 216,
                'borrado' => false,
            ],
        ]);

    }
}

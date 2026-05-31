<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Seeder for table: sgc_roles (8 rows)
 * Generated from existing database data
 */
class RolesSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('sgc_roles')->truncate();

        $this->db->table('sgc_roles')->insertBatch([
            [
                'idrol' => 1,
                'rolnom' => 'Director',
                'borrado' => false,
            ],
            [
                'idrol' => 2,
                'rolnom' => 'Analista',
                'borrado' => false,
            ],
            [
                'idrol' => 3,
                'rolnom' => 'Supervisor',
                'borrado' => false,
            ],
            [
                'idrol' => 4,
                'rolnom' => 'Coordinador',
                'borrado' => false,
            ],
            [
                'idrol' => 5,
                'rolnom' => 'Administrador',
                'borrado' => false,
            ],
            [
                'idrol' => 6,
                'rolnom' => 'Reportes',
                'borrado' => false,
            ],
            [
                'idrol' => 9,
                'rolnom' => 'Audiencias',
                'borrado' => false,
            ],
            [
                'idrol' => 10,
                'rolnom' => 'Casos recibidos',
                'borrado' => false,
            ],
        ]);

    }
}

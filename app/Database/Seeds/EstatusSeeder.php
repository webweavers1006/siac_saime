<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Seeder for table: sgc_estatus (2 rows)
 * Generated from existing database data
 */
class EstatusSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('sgc_estatus')->truncate();

        $this->db->table('sgc_estatus')->insertBatch([
            [
                'idest' => 1,
                'estnom' => 'Abierto',
                'borrado' => false,
            ],
            [
                'idest' => 2,
                'estnom' => 'Cerrado',
                'borrado' => false,
            ],
        ]);

    }
}

<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Seeder for table: sgc_ente_asdcrito (2 rows)
 * Generated from existing database data
 */
class EnteAsdcritoSeeder extends Seeder
{
    public function run()
    {
        $this->db->query('TRUNCATE TABLE sgc_ente_asdcrito CASCADE');

        $this->db->table('sgc_ente_asdcrito')->insertBatch([
            [
                'ente_id' => 1,
                'ente_nombre' => 'COMERCIO',
                'borrado' => false,
            ],
            [
                'ente_id' => 2,
                'ente_nombre' => 'ALMACENAMIENTO CARACAS',
                'borrado' => false,
            ],
        ]);

    }
}

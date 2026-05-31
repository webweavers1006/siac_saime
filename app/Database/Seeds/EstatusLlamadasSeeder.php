<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Seeder for table: sgc_estatus_llamadas (4 rows)
 * Generated from existing database data
 */
class EstatusLlamadasSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('sgc_estatus_llamadas')->truncate();

        $this->db->table('sgc_estatus_llamadas')->insertBatch([
            [
                'idestllam' => 1,
                'estllamnom' => 'Por Llamar',
            ],
            [
                'idestllam' => 2,
                'estllamnom' => 'Atendido',
            ],
            [
                'idestllam' => 3,
                'estllamnom' => 'No Contesta',
            ],
            [
                'idestllam' => 4,
                'estllamnom' => 'Otro',
            ],
        ]);

    }
}

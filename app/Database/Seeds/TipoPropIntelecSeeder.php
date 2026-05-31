<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Seeder for table: sgc_tipo_prop_intelec (5 rows)
 * Generated from existing database data
 */
class TipoPropIntelecSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('sgc_tipo_prop_intelec')->truncate();

        $this->db->table('sgc_tipo_prop_intelec')->insertBatch([
            [
                'tipo_prop_id' => 1,
                'tipo_prop_nombre' => 'No Aplica',
                'tipo_prop_borrado' => false,
            ],
            [
                'tipo_prop_id' => 2,
                'tipo_prop_nombre' => 'Patentes',
                'tipo_prop_borrado' => false,
            ],
            [
                'tipo_prop_id' => 3,
                'tipo_prop_nombre' => 'Derecho de Autor',
                'tipo_prop_borrado' => false,
            ],
            [
                'tipo_prop_id' => 4,
                'tipo_prop_nombre' => 'Indicación Geográfica Protegida',
                'tipo_prop_borrado' => false,
            ],
            [
                'tipo_prop_id' => 5,
                'tipo_prop_nombre' => 'Marcas',
                'tipo_prop_borrado' => false,
            ],
        ]);

    }
}

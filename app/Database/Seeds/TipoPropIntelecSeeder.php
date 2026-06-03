<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Seeder for table: sgc_tipo_prop_intelec
 * Catálogo de cabeceras / áreas del SAIME.
 */
class TipoPropIntelecSeeder extends Seeder
{
    public function run()
    {
        $this->db->query('TRUNCATE TABLE sgc_tipo_prop_intelec CASCADE');

        $this->db->table('sgc_tipo_prop_intelec')->insertBatch([
            [
                'tipo_prop_id' => 1,
                'tipo_prop_nombre' => 'No Aplica',
                'tipo_prop_borrado' => false,
            ],
            [
                'tipo_prop_id' => 2,
                'tipo_prop_nombre' => 'Caso Externo',
                'tipo_prop_borrado' => false,
            ],
            [
                'tipo_prop_id' => 3,
                'tipo_prop_nombre' => 'Extranjería',
                'tipo_prop_borrado' => false,
            ],
            [
                'tipo_prop_id' => 4,
                'tipo_prop_nombre' => 'Identificación',
                'tipo_prop_borrado' => false,
            ],
            [
                'tipo_prop_id' => 5,
                'tipo_prop_nombre' => 'Verificación y Registro',
                'tipo_prop_borrado' => false,
            ],
            [
                'tipo_prop_id' => 6,
                'tipo_prop_nombre' => 'Migración',
                'tipo_prop_borrado' => false,
            ],
            [
                'tipo_prop_id' => 7,
                'tipo_prop_nombre' => 'Regiones',
                'tipo_prop_borrado' => false,
            ],
        ]);

    }
}

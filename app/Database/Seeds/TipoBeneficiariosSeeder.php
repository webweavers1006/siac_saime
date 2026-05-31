<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Seeder for table: sgc_tipo_beneficiarios (5 rows)
 * Generated from existing database data
 */
class TipoBeneficiariosSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('sgc_tipo_beneficiarios')->truncate();

        $this->db->table('sgc_tipo_beneficiarios')->insertBatch([
            [
                'tipo_beneficiario_id' => 1,
                'tipo_beneficiario_nombre' => 'Usuario',
                'tipo_beneficiario_borrado' => false,
            ],
            [
                'tipo_beneficiario_id' => 2,
                'tipo_beneficiario_nombre' => 'Emprendedor',
                'tipo_beneficiario_borrado' => false,
            ],
            [
                'tipo_beneficiario_id' => 3,
                'tipo_beneficiario_nombre' => 'Innovador',
                'tipo_beneficiario_borrado' => false,
            ],
            [
                'tipo_beneficiario_id' => 4,
                'tipo_beneficiario_nombre' => 'Cultor',
                'tipo_beneficiario_borrado' => false,
            ],
            [
                'tipo_beneficiario_id' => 5,
                'tipo_beneficiario_nombre' => 'Productor',
                'tipo_beneficiario_borrado' => false,
            ],
        ]);

    }
}

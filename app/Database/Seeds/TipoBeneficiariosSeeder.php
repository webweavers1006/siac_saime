<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Seeder for table: sgc_tipo_beneficiarios (3 rows)
 * Tipos: Venezolano (requiere cédula), Extranjero con cédula, Extranjero sin cédula
 */
class TipoBeneficiariosSeeder extends Seeder
{
    public function run()
    {
        $this->db->query('TRUNCATE TABLE sgc_tipo_beneficiarios CASCADE');

        $this->db->table('sgc_tipo_beneficiarios')->insertBatch([
            [
                'tipo_beneficiario_id' => 1,
                'tipo_beneficiario_nombre' => 'Venezolano',
                'tipo_beneficiario_requiere_cedula' => true,
                'tipo_beneficiario_borrado' => false,
            ],
            [
                'tipo_beneficiario_id' => 2,
                'tipo_beneficiario_nombre' => 'Extranjero con cédula',
                'tipo_beneficiario_requiere_cedula' => true,
                'tipo_beneficiario_borrado' => false,
            ],
            [
                'tipo_beneficiario_id' => 3,
                'tipo_beneficiario_nombre' => 'Extranjero sin cédula',
                'tipo_beneficiario_requiere_cedula' => false,
                'tipo_beneficiario_borrado' => false,
            ],
        ]);

    }
}

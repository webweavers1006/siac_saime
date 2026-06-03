<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Seeder for table: sgc_via_tipo_atencion (59 rows)
 * Generated from existing database data
 */
class ViaTipoAtencionSeeder extends Seeder
{
    public function run()
    {
        $this->db->query('TRUNCATE TABLE sgc_via_tipo_atencion CASCADE');

        $this->db->table('sgc_via_tipo_atencion')->insertBatch([
            [
                'id' => 1,
                'via_atencion_id' => 5,
                'tipo_atencion_id' => 2,
                'borrado' => false,
            ],
            [
                'id' => 1,
                'via_atencion_id' => 2,
                'tipo_atencion_id' => 23,
                'borrado' => false,
            ],
            [
                'id' => 2,
                'via_atencion_id' => 5,
                'tipo_atencion_id' => 3,
                'borrado' => false,
            ],
            [
                'id' => 2,
                'via_atencion_id' => 9,
                'tipo_atencion_id' => 2,
                'borrado' => false,
            ],
            [
                'id' => 3,
                'via_atencion_id' => 9,
                'tipo_atencion_id' => 3,
                'borrado' => false,
            ],
            [
                'id' => 3,
                'via_atencion_id' => 5,
                'tipo_atencion_id' => 4,
                'borrado' => false,
            ],
            [
                'id' => 4,
                'via_atencion_id' => 9,
                'tipo_atencion_id' => 4,
                'borrado' => false,
            ],
            [
                'id' => 4,
                'via_atencion_id' => 5,
                'tipo_atencion_id' => 5,
                'borrado' => false,
            ],
            [
                'id' => 5,
                'via_atencion_id' => 9,
                'tipo_atencion_id' => 5,
                'borrado' => false,
            ],
            [
                'id' => 5,
                'via_atencion_id' => 5,
                'tipo_atencion_id' => 6,
                'borrado' => false,
            ],
            [
                'id' => 6,
                'via_atencion_id' => 5,
                'tipo_atencion_id' => 1,
                'borrado' => false,
            ],
            [
                'id' => 6,
                'via_atencion_id' => 9,
                'tipo_atencion_id' => 1,
                'borrado' => false,
            ],
            [
                'id' => 7,
                'via_atencion_id' => 9,
                'tipo_atencion_id' => 6,
                'borrado' => false,
            ],
            [
                'id' => 7,
                'via_atencion_id' => 4,
                'tipo_atencion_id' => 2,
                'borrado' => false,
            ],
            [
                'id' => 8,
                'via_atencion_id' => 3,
                'tipo_atencion_id' => 23,
                'borrado' => false,
            ],
            [
                'id' => 8,
                'via_atencion_id' => 4,
                'tipo_atencion_id' => 3,
                'borrado' => false,
            ],
            [
                'id' => 9,
                'via_atencion_id' => 2,
                'tipo_atencion_id' => 24,
                'borrado' => false,
            ],
            [
                'id' => 9,
                'via_atencion_id' => 4,
                'tipo_atencion_id' => 4,
                'borrado' => false,
            ],
            [
                'id' => 10,
                'via_atencion_id' => 4,
                'tipo_atencion_id' => 5,
                'borrado' => false,
            ],
            [
                'id' => 11,
                'via_atencion_id' => 4,
                'tipo_atencion_id' => 6,
                'borrado' => false,
            ],
            [
                'id' => 12,
                'via_atencion_id' => 4,
                'tipo_atencion_id' => 1,
                'borrado' => false,
            ],
            [
                'id' => 13,
                'via_atencion_id' => 3,
                'tipo_atencion_id' => 2,
                'borrado' => false,
            ],
            [
                'id' => 14,
                'via_atencion_id' => 3,
                'tipo_atencion_id' => 3,
                'borrado' => false,
            ],
            [
                'id' => 15,
                'via_atencion_id' => 3,
                'tipo_atencion_id' => 4,
                'borrado' => false,
            ],
            [
                'id' => 16,
                'via_atencion_id' => 3,
                'tipo_atencion_id' => 5,
                'borrado' => false,
            ],
            [
                'id' => 17,
                'via_atencion_id' => 3,
                'tipo_atencion_id' => 6,
                'borrado' => false,
            ],
            [
                'id' => 18,
                'via_atencion_id' => 3,
                'tipo_atencion_id' => 1,
                'borrado' => false,
            ],
            [
                'id' => 19,
                'via_atencion_id' => 2,
                'tipo_atencion_id' => 2,
                'borrado' => false,
            ],
            [
                'id' => 20,
                'via_atencion_id' => 2,
                'tipo_atencion_id' => 3,
                'borrado' => false,
            ],
            [
                'id' => 21,
                'via_atencion_id' => 2,
                'tipo_atencion_id' => 4,
                'borrado' => false,
            ],
            [
                'id' => 22,
                'via_atencion_id' => 2,
                'tipo_atencion_id' => 5,
                'borrado' => false,
            ],
            [
                'id' => 23,
                'via_atencion_id' => 2,
                'tipo_atencion_id' => 6,
                'borrado' => false,
            ],
            [
                'id' => 24,
                'via_atencion_id' => 2,
                'tipo_atencion_id' => 7,
                'borrado' => false,
            ],
            [
                'id' => 25,
                'via_atencion_id' => 2,
                'tipo_atencion_id' => 1,
                'borrado' => false,
            ],
            [
                'id' => 26,
                'via_atencion_id' => 1,
                'tipo_atencion_id' => 2,
                'borrado' => false,
            ],
            [
                'id' => 27,
                'via_atencion_id' => 1,
                'tipo_atencion_id' => 3,
                'borrado' => false,
            ],
            [
                'id' => 28,
                'via_atencion_id' => 1,
                'tipo_atencion_id' => 4,
                'borrado' => false,
            ],
            [
                'id' => 29,
                'via_atencion_id' => 1,
                'tipo_atencion_id' => 5,
                'borrado' => false,
            ],
            [
                'id' => 30,
                'via_atencion_id' => 1,
                'tipo_atencion_id' => 6,
                'borrado' => false,
            ],
            [
                'id' => 31,
                'via_atencion_id' => 1,
                'tipo_atencion_id' => 1,
                'borrado' => false,
            ],
            [
                'id' => 32,
                'via_atencion_id' => 6,
                'tipo_atencion_id' => 1,
                'borrado' => false,
            ],
            [
                'id' => 33,
                'via_atencion_id' => 6,
                'tipo_atencion_id' => 2,
                'borrado' => false,
            ],
            [
                'id' => 34,
                'via_atencion_id' => 6,
                'tipo_atencion_id' => 3,
                'borrado' => false,
            ],
            [
                'id' => 35,
                'via_atencion_id' => 6,
                'tipo_atencion_id' => 4,
                'borrado' => false,
            ],
            [
                'id' => 36,
                'via_atencion_id' => 6,
                'tipo_atencion_id' => 5,
                'borrado' => false,
            ],
            [
                'id' => 37,
                'via_atencion_id' => 6,
                'tipo_atencion_id' => 6,
                'borrado' => false,
            ],
            [
                'id' => 38,
                'via_atencion_id' => 7,
                'tipo_atencion_id' => 1,
                'borrado' => false,
            ],
            [
                'id' => 39,
                'via_atencion_id' => 7,
                'tipo_atencion_id' => 2,
                'borrado' => false,
            ],
            [
                'id' => 40,
                'via_atencion_id' => 7,
                'tipo_atencion_id' => 3,
                'borrado' => false,
            ],
            [
                'id' => 41,
                'via_atencion_id' => 7,
                'tipo_atencion_id' => 4,
                'borrado' => false,
            ],
        ]);

        $this->db->table('sgc_via_tipo_atencion')->insertBatch([
            [
                'id' => 42,
                'via_atencion_id' => 7,
                'tipo_atencion_id' => 5,
                'borrado' => false,
            ],
            [
                'id' => 43,
                'via_atencion_id' => 7,
                'tipo_atencion_id' => 6,
                'borrado' => false,
            ],
            [
                'id' => 44,
                'via_atencion_id' => 8,
                'tipo_atencion_id' => 1,
                'borrado' => false,
            ],
            [
                'id' => 45,
                'via_atencion_id' => 8,
                'tipo_atencion_id' => 2,
                'borrado' => false,
            ],
            [
                'id' => 46,
                'via_atencion_id' => 8,
                'tipo_atencion_id' => 3,
                'borrado' => false,
            ],
            [
                'id' => 47,
                'via_atencion_id' => 8,
                'tipo_atencion_id' => 4,
                'borrado' => false,
            ],
            [
                'id' => 48,
                'via_atencion_id' => 8,
                'tipo_atencion_id' => 5,
                'borrado' => false,
            ],
            [
                'id' => 49,
                'via_atencion_id' => 8,
                'tipo_atencion_id' => 6,
                'borrado' => false,
            ],
            [
                'id' => 49,
                'via_atencion_id' => 8,
                'tipo_atencion_id' => 6,
                'borrado' => false,
            ],
        ]);

    }
}

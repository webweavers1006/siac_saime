<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Seeder for table: sgc_red_social (9 rows)
 * Generated from existing database data
 */
class RedSocialSeeder extends Seeder
{
    public function run()
    {
        $this->db->query('TRUNCATE TABLE sgc_red_social CASCADE');

        $this->db->table('sgc_red_social')->insertBatch([
            [
                'red_s_id' => 1,
                'red_s_nom' => 'Whatsapp',
                'red_s_borrado' => false,
            ],
            [
                'red_s_id' => 2,
                'red_s_nom' => 'Oficina presencial',
                'red_s_borrado' => false,
            ],
            [
                'red_s_id' => 4,
                'red_s_nom' => 'Correo Electrónico',
                'red_s_borrado' => false,
            ],
            [
                'red_s_id' => 5,
                'red_s_nom' => 'Centro de llamadas',
                'red_s_borrado' => false,
            ],
            [
                'red_s_id' => 9,
                'red_s_nom' => 'Telegram',
                'red_s_borrado' => false,
            ],
        ]);

    }
}

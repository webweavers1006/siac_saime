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
        $this->db->table('sgc_red_social')->truncate();

        $this->db->table('sgc_red_social')->insertBatch([
            [
                'red_s_id' => 1,
                'red_s_nom' => 'Whatsapp',
                'red_s_borrado' => false,
            ],
            [
                'red_s_id' => 2,
                'red_s_nom' => 'Personal',
                'red_s_borrado' => false,
            ],
            [
                'red_s_id' => 3,
                'red_s_nom' => 'Portal web ',
                'red_s_borrado' => false,
            ],
            [
                'red_s_id' => 4,
                'red_s_nom' => 'Correo Electrónico',
                'red_s_borrado' => false,
            ],
            [
                'red_s_id' => 5,
                'red_s_nom' => 'Llamada Telefónica',
                'red_s_borrado' => false,
            ],
            [
                'red_s_id' => 6,
                'red_s_nom' => 'Taquilla Expres',
                'red_s_borrado' => false,
            ],
            [
                'red_s_id' => 7,
                'red_s_nom' => 'Stand Informativo',
                'red_s_borrado' => false,
            ],
            [
                'red_s_id' => 8,
                'red_s_nom' => 'Taquilla Comunal',
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

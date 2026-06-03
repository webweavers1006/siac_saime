<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Seeder for table: sgc_oficinas (2 rows)
 * Generated from existing database data
 */
class OficinasSeeder extends Seeder
{
    public function run()
    {
        $this->db->query('TRUNCATE TABLE sgc_oficinas CASCADE');

        $this->db->table('sgc_oficinas')->insertBatch([
            [
                'idofi' => 1,
                'ofinom' => 'Sala Situacional',
            ],
            [
                'idofi' => 2,
                'ofinom' => 'Coordinacion Regional',
            ],
        ]);

    }
}

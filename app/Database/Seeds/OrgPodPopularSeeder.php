<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Seeder for table: sgc_org_pod_popular (3 rows)
 * Generated from existing database data
 */
class OrgPodPopularSeeder extends Seeder
{
    public function run()
    {
        $this->db->query('TRUNCATE TABLE sgc_org_pod_popular CASCADE');

        $this->db->table('sgc_org_pod_popular')->insertBatch([
            [
                'org_id' => 1,
                'org_nombre' => 'N/A',
                'org_borrado' => false,
            ],
            [
                'org_id' => 2,
                'org_nombre' => 'Concejo Comunales',
                'org_borrado' => false,
            ],
            [
                'org_id' => 3,
                'org_nombre' => 'Comunas',
                'org_borrado' => false,
            ],
        ]);

    }
}

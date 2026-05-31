<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Seeder for table: sgc_mediacion (27 rows)
 * Generated from existing database data
 */
class MediacionSeeder extends Seeder
{
    public function run()
    {
        $this->db->query('TRUNCATE TABLE sgc_mediacion RESTART IDENTITY CASCADE');

        $this->db->table('sgc_mediacion')->insertBatch([
            [
                'med_id' => 1,
                'med_caso_id' => 46241,
                'med_apo_sol_id' => 2,
                'med_contra_id' => 1,
                'med_apo_contra_id' => 0,
            ],
            [
                'med_id' => 2,
                'med_caso_id' => 46242,
                'med_apo_sol_id' => 0,
                'med_contra_id' => 1,
                'med_apo_contra_id' => 0,
            ],
            [
                'med_id' => 3,
                'med_caso_id' => 46246,
                'med_apo_sol_id' => 0,
                'med_contra_id' => 1,
                'med_apo_contra_id' => 0,
            ],
            [
                'med_id' => 4,
                'med_caso_id' => 48373,
                'med_apo_sol_id' => 0,
                'med_contra_id' => 3,
                'med_apo_contra_id' => 0,
            ],
            [
                'med_id' => 5,
                'med_caso_id' => 50559,
                'med_apo_sol_id' => 1,
                'med_contra_id' => 1,
                'med_apo_contra_id' => 0,
            ],
            [
                'med_id' => 6,
                'med_caso_id' => 50601,
                'med_apo_sol_id' => 0,
                'med_contra_id' => 1,
                'med_apo_contra_id' => 0,
            ],
            [
                'med_id' => 7,
                'med_caso_id' => 50604,
                'med_apo_sol_id' => 0,
                'med_contra_id' => 1,
                'med_apo_contra_id' => 0,
            ],
            [
                'med_id' => 8,
                'med_caso_id' => 51779,
                'med_apo_sol_id' => 0,
                'med_contra_id' => 4,
                'med_apo_contra_id' => 0,
            ],
            [
                'med_id' => 9,
                'med_caso_id' => 53024,
                'med_apo_sol_id' => 0,
                'med_contra_id' => 5,
                'med_apo_contra_id' => 0,
            ],
            [
                'med_id' => 10,
                'med_caso_id' => 53370,
                'med_apo_sol_id' => 1,
                'med_contra_id' => 1,
                'med_apo_contra_id' => 0,
            ],
            [
                'med_id' => 11,
                'med_caso_id' => 53553,
                'med_apo_sol_id' => 0,
                'med_contra_id' => 6,
                'med_apo_contra_id' => 0,
            ],
            [
                'med_id' => 12,
                'med_caso_id' => 53557,
                'med_apo_sol_id' => 0,
                'med_contra_id' => 6,
                'med_apo_contra_id' => 0,
            ],
            [
                'med_id' => 13,
                'med_caso_id' => 54037,
                'med_apo_sol_id' => 0,
                'med_contra_id' => 1,
                'med_apo_contra_id' => 0,
            ],
            [
                'med_id' => 14,
                'med_caso_id' => 54088,
                'med_apo_sol_id' => 0,
                'med_contra_id' => 1,
                'med_apo_contra_id' => 0,
            ],
            [
                'med_id' => 15,
                'med_caso_id' => 54089,
                'med_apo_sol_id' => 0,
                'med_contra_id' => 1,
                'med_apo_contra_id' => 0,
            ],
            [
                'med_id' => 16,
                'med_caso_id' => 54113,
                'med_apo_sol_id' => 1,
                'med_contra_id' => 1,
                'med_apo_contra_id' => 1,
            ],
            [
                'med_id' => 17,
                'med_caso_id' => 54482,
                'med_apo_sol_id' => 0,
                'med_contra_id' => 7,
                'med_apo_contra_id' => 0,
            ],
            [
                'med_id' => 18,
                'med_caso_id' => 54483,
                'med_apo_sol_id' => 0,
                'med_contra_id' => 7,
                'med_apo_contra_id' => 0,
            ],
            [
                'med_id' => 19,
                'med_caso_id' => 54930,
                'med_apo_sol_id' => 1,
                'med_contra_id' => 1,
                'med_apo_contra_id' => 0,
            ],
            [
                'med_id' => 20,
                'med_caso_id' => 54931,
                'med_apo_sol_id' => 1,
                'med_contra_id' => 1,
                'med_apo_contra_id' => 0,
            ],
            [
                'med_id' => 21,
                'med_caso_id' => 54936,
                'med_apo_sol_id' => 1,
                'med_contra_id' => 1,
                'med_apo_contra_id' => 0,
            ],
            [
                'med_id' => 22,
                'med_caso_id' => 54937,
                'med_apo_sol_id' => 1,
                'med_contra_id' => 1,
                'med_apo_contra_id' => 0,
            ],
            [
                'med_id' => 23,
                'med_caso_id' => 54937,
                'med_apo_sol_id' => 1,
                'med_contra_id' => 1,
                'med_apo_contra_id' => 0,
            ],
            [
                'med_id' => 24,
                'med_caso_id' => 54938,
                'med_apo_sol_id' => 1,
                'med_contra_id' => 1,
                'med_apo_contra_id' => 0,
            ],
            [
                'med_id' => 25,
                'med_caso_id' => 54943,
                'med_apo_sol_id' => 1,
                'med_contra_id' => 1,
                'med_apo_contra_id' => 0,
            ],
            [
                'med_id' => 26,
                'med_caso_id' => 55098,
                'med_apo_sol_id' => 1,
                'med_contra_id' => 1,
                'med_apo_contra_id' => 0,
            ],
            [
                'med_id' => 27,
                'med_caso_id' => 55259,
                'med_apo_sol_id' => 0,
                'med_contra_id' => 1,
                'med_apo_contra_id' => 0,
            ],
        ]);

    }
}

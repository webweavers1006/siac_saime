<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Seeder for table: sgc_tipoatencion_usu (9 rows)
 * Generated from existing database data
 */
class TipoatencionUsuSeeder extends Seeder
{
    public function run()
    {
        $this->db->query('TRUNCATE TABLE sgc_tipoatencion_usu CASCADE');

        $this->db->table('sgc_tipoatencion_usu')->insertBatch([
            [
                'tipo_aten_id' => 1,
                'tipo_aten_nombre' => 'Asesoría',
                'tipo_aten_borrado' => false,
                'act_pro_int' => true,
                'acc_participantes' => false,
                'env_correo' => false,
                'organismo_pp' => false,
                'act_coordenadas' => false,
                'act_punto_cuenta' => false,
            ],
            [
                'tipo_aten_id' => 2,
                'tipo_aten_nombre' => 'Sugerencia',
                'tipo_aten_borrado' => false,
                'act_pro_int' => true,
                'acc_participantes' => false,
                'env_correo' => false,
                'organismo_pp' => false,
                'act_coordenadas' => false,
                'act_punto_cuenta' => false,
            ],
            [
                'tipo_aten_id' => 3,
                'tipo_aten_nombre' => 'Queja',
                'tipo_aten_borrado' => false,
                'act_pro_int' => true,
                'acc_participantes' => false,
                'env_correo' => false,
                'organismo_pp' => false,
                'act_coordenadas' => false,
                'act_punto_cuenta' => false,
            ],
            [
                'tipo_aten_id' => 4,
                'tipo_aten_nombre' => 'Reclamo',
                'tipo_aten_borrado' => false,
                'act_pro_int' => true,
                'acc_participantes' => false,
                'env_correo' => false,
                'organismo_pp' => false,
                'act_coordenadas' => false,
                'act_punto_cuenta' => false,
            ],
            [
                'tipo_aten_id' => 5,
                'tipo_aten_nombre' => 'Denuncia',
                'tipo_aten_borrado' => false,
                'act_pro_int' => true,
                'acc_participantes' => false,
                'env_correo' => false,
                'organismo_pp' => false,
                'act_coordenadas' => false,
                'act_punto_cuenta' => false,
            ]
        ]);

    }
}

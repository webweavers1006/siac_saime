<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Seeder for table: sgc_tipoatenciondetalle (7 rows)
 * Generated from existing database data
 */
class TipoatenciondetalleSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('sgc_tipoatenciondetalle')->truncate();

        $this->db->table('sgc_tipoatenciondetalle')->insertBatch([
            [
                'tipo_atend_id' => 1,
                'tipo_atend_nombre' => 'Donación por gastos fúnebres',
                'tipo_aten_id' => 6,
                'tipo_atend_borrado' => false,
            ],
            [
                'tipo_atend_id' => 2,
                'tipo_atend_nombre' => 'Donación por gastos médicos',
                'tipo_aten_id' => 6,
                'tipo_atend_borrado' => false,
            ],
            [
                'tipo_atend_id' => 3,
                'tipo_atend_nombre' => 'Donación por gastos operatorios',
                'tipo_aten_id' => 6,
                'tipo_atend_borrado' => false,
            ],
            [
                'tipo_atend_id' => 4,
                'tipo_atend_nombre' => 'Donaciones personales',
                'tipo_aten_id' => 6,
                'tipo_atend_borrado' => false,
            ],
            [
                'tipo_atend_id' => 5,
                'tipo_atend_nombre' => 'Donaciones de apoyo alimenticio',
                'tipo_aten_id' => 6,
                'tipo_atend_borrado' => false,
            ],
            [
                'tipo_atend_id' => 6,
                'tipo_atend_nombre' => 'Donaciones por apoyo académico',
                'tipo_aten_id' => 6,
                'tipo_atend_borrado' => false,
            ],
            [
                'tipo_atend_id' => 7,
                'tipo_atend_nombre' => 'Donaciones de materiales de construcción',
                'tipo_aten_id' => 6,
                'tipo_atend_borrado' => false,
            ],
        ]);

    }
}

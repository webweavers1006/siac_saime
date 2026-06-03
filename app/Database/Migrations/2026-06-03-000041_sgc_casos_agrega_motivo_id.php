<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration: Agrega columna motivo_id a sgc_casos
 * Relaciona cada caso con un motivo (sgc_motivos).
 */
class AgregaMotivoIdCasos extends Migration
{
    public function up()
    {
        $this->forge->addColumn('sgc_casos', [
            'motivo_id' => [
                'type'       => 'INT',
                'null'       => true,
                'after'      => 'tipo_beneficiario',
            ],
        ]);

        $this->db->query("ALTER TABLE sgc_casos ADD CONSTRAINT sgc_casos_motivo_id_foreign FOREIGN KEY (motivo_id) REFERENCES sgc_motivos (motivo_id) ON DELETE SET NULL ON UPDATE CASCADE");
    }

    public function down()
    {
        $this->db->query("ALTER TABLE sgc_casos DROP CONSTRAINT IF EXISTS sgc_casos_motivo_id_foreign");
        $this->forge->dropColumn('sgc_casos', 'motivo_id');
    }
}

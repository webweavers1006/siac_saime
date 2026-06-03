<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration for table: sgc_motivos
 * Catálogo de motivos vinculados a una cabecera (sgc_tipo_prop_intelec).
 * Relación: N motivos → 1 cabecera (tipo_prop_id).
 */
class Motivos extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'motivo_id' => [
                'null' => false,
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'tipo_prop_id' => [
                'null' => false,
                'type' => 'INT',
            ],
            'motivo_nombre' => [
                'null' => false,
                'type' => 'TEXT',
            ],
            'motivo_borrado' => [
                'null' => false,
                'default' => false,
                'type' => 'BOOLEAN',
            ],
        ]);

        $this->forge->addKey('motivo_id', true);
        $this->forge->addKey('tipo_prop_id');

        $this->forge->createTable('sgc_motivos', true);

        // FK: sgc_motivos.tipo_prop_id → sgc_tipo_prop_intelec.tipo_prop_id
        $this->db->query("ALTER TABLE sgc_motivos ADD CONSTRAINT sgc_motivos_tipo_prop_id_foreign FOREIGN KEY (tipo_prop_id) REFERENCES sgc_tipo_prop_intelec (tipo_prop_id) ON DELETE CASCADE ON UPDATE CASCADE");
    }

    public function down()
    {
        $this->db->query("ALTER TABLE sgc_motivos DROP CONSTRAINT IF EXISTS sgc_motivos_tipo_prop_id_foreign");
        $this->forge->dropTable('sgc_motivos', true);
    }
}

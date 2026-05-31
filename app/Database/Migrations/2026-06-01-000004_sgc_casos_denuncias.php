<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration for table: sgc_casos_denuncias
 * Columns: 13 | Rows in DB: 27
 * Generated from existing database schema
 */
class CasosDenuncias extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'denu_id' => [
                'null' => false,
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'denu_afecta_persona' => [
                'null' => false,
                'default' => false,
                'type' => 'BOOLEAN',
            ],
            'denu_afecta_comunidad' => [
                'null' => false,
                'default' => false,
                'type' => 'BOOLEAN',
            ],
            'denu_afecta_terceros' => [
                'null' => false,
                'default' => false,
                'type' => 'BOOLEAN',
            ],
            'denu_involucrados' => [
                'null' => true,
                'type' => 'TEXT',
            ],
            'denu_fecha_hechos' => [
                'null' => false,
                'type' => 'DATE',
            ],
            'denu_instancia_popular' => [
                'null' => true,
                'type' => 'TEXT',
            ],
            'denu_rif_instancia' => [
                'null' => true,
                'type' => 'TEXT',
            ],
            'denu_ente_financiador' => [
                'null' => true,
                'type' => 'TEXT',
            ],
            'denu_nombre_proyecto' => [
                'null' => true,
                'type' => 'TEXT',
            ],
            'denu_monto_aprovado' => [
                'null' => true,
                'type' => 'TEXT',
            ],
            'denu_id_caso' => [
                'null' => true,
                'type' => 'INT',
            ],
            'denu_borrado' => [
                'null' => true,
                'default' => false,
                'type' => 'BOOLEAN',
            ],
        ]);

        $this->forge->addKey(['denu_id'], true);

        $this->forge->createTable('sgc_casos_denuncias', true);
    }

    public function down()
    {
        $this->forge->dropTable('sgc_casos_denuncias', true);
    }
}

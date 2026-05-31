<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration for table: sgc_talleres_participantes
 * Columns: 4 | Rows in DB: 746
 * Generated from existing database schema
 */
class TalleresParticipantes extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'null' => false,
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'id_caso' => [
                'null' => false,
                'type' => 'INT',
            ],
            'participante_id' => [
                'null' => false,
                'type' => 'INT',
            ],
            'org_id' => [
                'null' => true,
                'type' => 'INT',
            ],
        ]);

        $this->forge->addKey(['id'], true);
        $this->forge->addKey(['id_caso', 'participante_id'], false, true); // uq_caso_participante

        $this->forge->createTable('sgc_talleres_participantes', true);
    }

    public function down()
    {
        $this->forge->dropTable('sgc_talleres_participantes', true);
    }
}

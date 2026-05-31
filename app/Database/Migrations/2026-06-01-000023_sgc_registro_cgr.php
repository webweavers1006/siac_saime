<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration for table: sgc_registro_cgr
 * Columns: 5 | Rows in DB: 41633
 * Generated from existing database schema
 */
class RegistroCgr extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_cgr' => [
                'null' => false,
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'competencia_cgr' => [
                'null' => false,
                'type' => 'INT',
            ],
            'asume_cgr' => [
                'null' => false,
                'type' => 'INT',
            ],
            'borrado_cgr' => [
                'null' => false,
                'default' => false,
                'type' => 'BOOLEAN',
            ],
            'id_caso' => [
                'null' => true,
                'type' => 'INT',
            ],
        ]);

        $this->forge->addKey(['id_cgr'], true);

        $this->forge->createTable('sgc_registro_cgr', true);
    }

    public function down()
    {
        $this->forge->dropTable('sgc_registro_cgr', true);
    }
}

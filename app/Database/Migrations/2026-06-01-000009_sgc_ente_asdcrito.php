<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration for table: sgc_ente_asdcrito
 * Columns: 3 | Rows in DB: 2
 * Generated from existing database schema
 */
class EnteAsdcrito extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'ente_id' => [
                'null' => false,
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'ente_nombre' => [
                'null' => false,
                'type' => 'TEXT',
            ],
            'borrado' => [
                'null' => false,
                'default' => false,
                'type' => 'BOOLEAN',
            ],
        ]);

        $this->forge->addKey(['ente_id'], true);

        $this->forge->createTable('sgc_ente_asdcrito', true);
    }

    public function down()
    {
        $this->forge->dropTable('sgc_ente_asdcrito', true);
    }
}

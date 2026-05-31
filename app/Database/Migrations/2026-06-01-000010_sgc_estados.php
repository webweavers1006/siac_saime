<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration for table: sgc_estados
 * Columns: 4 | Rows in DB: 26
 * Generated from existing database schema
 */
class Estados extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'estadoid' => [
                'null' => false,
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'estadonom' => [
                'null' => false,
                'type' => 'VARCHAR',
                'constraint' => 48,
            ],
            'paisid' => [
                'null' => false,
                'type' => 'INT',
            ],
            'borrado' => [
                'null' => true,
                'default' => false,
                'type' => 'BOOLEAN',
            ],
        ]);

        $this->forge->addKey(['estadoid'], true);
        $this->forge->addKey(['estadoid'], false, true); // pk_sgc_estados
        $this->forge->createTable('sgc_estados', true);
    }

    public function down()
    {
        // Drop foreign keys        $this->forge->dropTable('sgc_estados', true);
    }
}

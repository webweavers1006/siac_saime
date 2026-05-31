<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration for table: sgc_paises
 * Columns: 2 | Rows in DB: 216
 * Generated from existing database schema
 */
class Paises extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'paisid' => [
                'null' => false,
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'paisnom' => [
                'null' => false,
                'type' => 'VARCHAR',
                'constraint' => 48,
            ],
        ]);

        $this->forge->addKey(['paisid'], true);
        $this->forge->addKey(['paisid'], false, true); // pk_sgc_paises

        $this->forge->createTable('sgc_paises', true);
    }

    public function down()
    {
        $this->forge->dropTable('sgc_paises', true);
    }
}

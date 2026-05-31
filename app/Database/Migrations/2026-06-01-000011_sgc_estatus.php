<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration for table: sgc_estatus
 * Columns: 3 | Rows in DB: 2
 * Generated from existing database schema
 */
class Estatus extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'idest' => [
                'null' => false,
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'estnom' => [
                'null' => false,
                'type' => 'VARCHAR',
                'constraint' => 48,
            ],
            'borrado' => [
                'null' => true,
                'default' => false,
                'type' => 'BOOLEAN',
            ],
        ]);

        $this->forge->addKey(['idest'], true);
        $this->forge->addKey(['idest'], false, true); // pk_sgc_estatus

        $this->forge->createTable('sgc_estatus', true);
    }

    public function down()
    {
        $this->forge->dropTable('sgc_estatus', true);
    }
}

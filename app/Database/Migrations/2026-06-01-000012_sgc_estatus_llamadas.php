<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration for table: sgc_estatus_llamadas
 * Columns: 2 | Rows in DB: 4
 * Generated from existing database schema
 */
class EstatusLlamadas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'idestllam' => [
                'null' => false,
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'estllamnom' => [
                'null' => false,
                'type' => 'VARCHAR',
                'constraint' => 48,
            ],
        ]);

        $this->forge->addKey(['idestllam'], true);
        $this->forge->addKey(['idestllam'], false, true); // pk_sgc_estatus_llamadas

        $this->forge->createTable('sgc_estatus_llamadas', true);
    }

    public function down()
    {
        $this->forge->dropTable('sgc_estatus_llamadas', true);
    }
}

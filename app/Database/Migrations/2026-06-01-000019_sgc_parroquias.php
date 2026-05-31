<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration for table: sgc_parroquias
 * Columns: 3 | Rows in DB: 1135
 * Generated from existing database schema
 */
class Parroquias extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'parroquiaid' => [
                'null' => false,
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'parroquianom' => [
                'null' => false,
                'type' => 'VARCHAR',
                'constraint' => 48,
            ],
            'municipioid' => [
                'null' => false,
                'type' => 'INT',
            ],
        ]);

        $this->forge->addKey(['parroquiaid'], true);
        $this->forge->addKey(['parroquiaid'], false, true); // pk_sgc_parroquias
        $this->forge->createTable('sgc_parroquias', true);
    }

    public function down()
    {
        // Drop foreign keys        $this->forge->dropTable('sgc_parroquias', true);
    }
}

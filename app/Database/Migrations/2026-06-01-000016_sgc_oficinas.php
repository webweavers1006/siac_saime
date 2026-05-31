<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration for table: sgc_oficinas
 * Columns: 2 | Rows in DB: 2
 * Generated from existing database schema
 */
class Oficinas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'idofi' => [
                'null' => false,
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'ofinom' => [
                'null' => false,
                'type' => 'VARCHAR',
                'constraint' => 48,
            ],
        ]);

        $this->forge->addKey(['idofi'], true);
        $this->forge->addKey(['idofi'], false, true); // pk_sgc_oficinas

        $this->forge->createTable('sgc_oficinas', true);
    }

    public function down()
    {
        $this->forge->dropTable('sgc_oficinas', true);
    }
}

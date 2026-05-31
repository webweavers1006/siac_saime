<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration for table: sgc_municipio
 * Columns: 3 | Rows in DB: 336
 * Generated from existing database schema
 */
class Municipio extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'municipioid' => [
                'null' => false,
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'municipionom' => [
                'null' => false,
                'type' => 'VARCHAR',
                'constraint' => 48,
            ],
            'estadoid' => [
                'null' => false,
                'type' => 'INT',
            ],
        ]);

        $this->forge->addKey(['municipioid'], true);
        $this->forge->addKey(['municipioid'], false, true); // pk_sgc_municipio
        $this->forge->createTable('sgc_municipio', true);
    }

    public function down()
    {
        // Drop foreign keys        $this->forge->dropTable('sgc_municipio', true);
    }
}

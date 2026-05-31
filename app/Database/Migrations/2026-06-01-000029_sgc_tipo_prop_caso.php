<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration for table: sgc_tipo_prop_caso
 * Columns: 3 | Rows in DB: 58278
 * Generated from existing database schema
 */
class TipoPropCaso extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'idtipopropcaso' => [
                'null' => false,
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'idtippropint' => [
                'null' => false,
                'type' => 'INT',
            ],
            'idcaso' => [
                'null' => false,
                'type' => 'INT',
            ],
        ]);

        $this->forge->addKey(['idtipopropcaso'], true);
        $this->forge->addKey(['idtipopropcaso'], false, true); // pk_sgc_tipo_prop_caso

        $this->forge->createTable('sgc_tipo_prop_caso', true);
    }

    public function down()
    {
        // Drop foreign keys        $this->forge->dropTable('sgc_tipo_prop_caso', true);
    }
}

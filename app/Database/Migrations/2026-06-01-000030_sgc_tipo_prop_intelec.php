<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration for table: sgc_tipo_prop_intelec
 * Columns: 3 | Rows in DB: 5
 * Generated from existing database schema
 */
class TipoPropIntelec extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'tipo_prop_id' => [
                'null' => false,
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'tipo_prop_nombre' => [
                'null' => false,
                'type' => 'VARCHAR',
                'constraint' => 48,
            ],
            'tipo_prop_borrado' => [
                'null' => true,
                'default' => false,
                'type' => 'BOOLEAN',
            ],
        ]);

        $this->forge->addKey(['tipo_prop_id'], true);
        $this->forge->addKey(['tipo_prop_id'], false, true); // pk_sgc_tipo_prop_intelec

        $this->forge->createTable('sgc_tipo_prop_intelec', true);
    }

    public function down()
    {
        $this->forge->dropTable('sgc_tipo_prop_intelec', true);
    }
}

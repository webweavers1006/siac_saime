<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration for table: sgc_red_social
 * Columns: 3 | Rows in DB: 9
 * Generated from existing database schema
 */
class RedSocial extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'red_s_id' => [
                'null' => false,
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'red_s_nom' => [
                'null' => false,
                'type' => 'VARCHAR',
                'constraint' => 48,
            ],
            'red_s_borrado' => [
                'null' => true,
                'default' => false,
                'type' => 'BOOLEAN',
            ],
        ]);

        $this->forge->addKey(['red_s_id'], true);
        $this->forge->addKey(['red_s_id'], false, true); // pk_sgc_red_social

        $this->forge->createTable('sgc_red_social', true);
    }

    public function down()
    {
        $this->forge->dropTable('sgc_red_social', true);
    }
}

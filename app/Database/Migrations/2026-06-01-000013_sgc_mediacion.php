<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration for table: sgc_mediacion
 * Columns: 5 | Rows in DB: 27
 * Generated from existing database schema
 */
class Mediacion extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'med_id' => [
                'null' => false,
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'med_caso_id' => [
                'null' => false,
                'type' => 'INT',
            ],
            'med_apo_sol_id' => [
                'null' => true,
                'type' => 'INT',
            ],
            'med_contra_id' => [
                'null' => false,
                'type' => 'INT',
            ],
            'med_apo_contra_id' => [
                'null' => true,
                'type' => 'INT',
            ],
        ]);

        $this->forge->addKey(['med_id'], true);


        $this->forge->createTable('sgc_mediacion', true);
    }

    public function down()
    {
        // Drop foreign keys        $this->forge->dropTable('sgc_mediacion', true);
    }
}

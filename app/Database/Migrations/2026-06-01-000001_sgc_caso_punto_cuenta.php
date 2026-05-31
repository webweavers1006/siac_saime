<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration for table: sgc_caso_punto_cuenta
 * Columns: 4 | Rows in DB: 0
 * Generated from existing database schema
 */
class CasoPuntoCuenta extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'null' => false,
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'id_punto_cuenta' => [
                'null' => false,
                'type' => 'INT',
            ],
            'id_caso' => [
                'null' => false,
                'type' => 'INT',
            ],
            'borrado' => [
                'null' => false,
                'default' => false,
                'type' => 'BOOLEAN',
            ],
        ]);

        $this->forge->addKey(['id'], true);

        $this->forge->createTable('sgc_caso_punto_cuenta', true);
    }

    public function down()
    {
        $this->forge->dropTable('sgc_caso_punto_cuenta', true);
    }
}

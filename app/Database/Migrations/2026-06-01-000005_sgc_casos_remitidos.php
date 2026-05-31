<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration for table: sgc_casos_remitidos
 * Columns: 7 | Rows in DB: 967
 * Generated from existing database schema
 */
class CasosRemitidos extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'casos_re_id' => [
                'null' => false,
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'casos_id' => [
                'null' => false,
                'type' => 'INT',
            ],
            'direccion_id' => [
                'null' => false,
                'type' => 'INT',
            ],
            'borrado' => [
                'null' => false,
                'default' => false,
                'type' => 'BOOLEAN',
            ],
            'idusuop' => [
                'null' => true,
                'type' => 'INT',
            ],
            'vigencia' => [
                'null' => true,
                'default' => true,
                'type' => 'BOOLEAN',
            ],
            'fecha' => [
                'null' => true,
                'type' => 'DATE',
            ],
        ]);

        $this->forge->addKey(['casos_re_id'], true);

        $this->forge->createTable('sgc_casos_remitidos', true);
    }

    public function down()
    {
        $this->forge->dropTable('sgc_casos_remitidos', true);
    }
}

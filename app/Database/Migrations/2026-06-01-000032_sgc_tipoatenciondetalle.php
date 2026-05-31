<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration for table: sgc_tipoatenciondetalle
 * Columns: 4 | Rows in DB: 7
 * Generated from existing database schema
 */
class Tipoatenciondetalle extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'tipo_atend_id' => [
                'null' => false,
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'tipo_atend_nombre' => [
                'null' => false,
                'type' => 'TEXT',
            ],
            'tipo_aten_id' => [
                'null' => false,
                'type' => 'INT',
            ],
            'tipo_atend_borrado' => [
                'null' => true,
                'default' => false,
                'type' => 'BOOLEAN',
            ],
        ]);

        $this->forge->addKey(['tipo_atend_id'], true);

        $this->forge->createTable('sgc_tipoatenciondetalle', true);
    }

    public function down()
    {
        $this->forge->dropTable('sgc_tipoatenciondetalle', true);
    }
}

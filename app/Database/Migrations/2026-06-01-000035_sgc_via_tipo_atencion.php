<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration for table: sgc_via_tipo_atencion
 * Columns: 4 | Rows in DB: 59
 * Generated from existing database schema
 */
class ViaTipoAtencion extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'null' => false,
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'via_atencion_id' => [
                'null' => false,
                'type' => 'INT',
            ],
            'tipo_atencion_id' => [
                'null' => false,
                'type' => 'INT',
            ],
            'borrado' => [
                'null' => false,
                'default' => false,
                'type' => 'BOOLEAN',
            ],
        ]);



        $this->forge->createTable('sgc_via_tipo_atencion', true);
    }

    public function down()
    {
        $this->forge->dropTable('sgc_via_tipo_atencion', true);
    }
}

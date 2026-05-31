<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration for table: sgc_direcciones_administrativas
 * Columns: 5 | Rows in DB: 27
 * Generated from existing database schema
 */
class DireccionesAdministrativas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'null' => false,
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'descripcion' => [
                'null' => false,
                'type' => 'TEXT',
            ],
            'borrado' => [
                'null' => false,
                'default' => false,
                'type' => 'BOOLEAN',
            ],
            'correo' => [
                'null' => true,
                'type' => 'TEXT',
            ],
            'act_aud' => [
                'null' => true,
                'default' => false,
                'type' => 'BOOLEAN',
            ],
        ]);

        $this->forge->addKey(['id'], true);

        $this->forge->createTable('sgc_direcciones_administrativas', true);
    }

    public function down()
    {
        $this->forge->dropTable('sgc_direcciones_administrativas', true);
    }
}

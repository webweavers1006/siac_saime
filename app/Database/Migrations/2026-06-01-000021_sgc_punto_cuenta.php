<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration for table: sgc_punto_cuenta
 * Columns: 8 | Rows in DB: 1
 * Generated from existing database schema
 */
class PuntoCuenta extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'null' => false,
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'numero_punto_cuenta' => [
                'null' => false,
                'type' => 'TEXT',
            ],
            'fecha_punto_cuenta' => [
                'null' => false,
                'type' => 'DATE',
            ],
            'nombre' => [
                'null' => false,
                'type' => 'TEXT',
            ],
            'apellido' => [
                'null' => false,
                'type' => 'TEXT',
            ],
            'monto_aprobado' => [
                'null' => false,
                'type' => 'TEXT',
            ],
            'causa_beneficio' => [
                'null' => false,
                'type' => 'TEXT',
            ],
            'borrado' => [
                'null' => false,
                'default' => false,
                'type' => 'BOOLEAN',
            ],
        ]);

        $this->forge->addKey(['id'], true);

        $this->forge->createTable('sgc_punto_cuenta', true);
    }

    public function down()
    {
        $this->forge->dropTable('sgc_punto_cuenta', true);
    }
}

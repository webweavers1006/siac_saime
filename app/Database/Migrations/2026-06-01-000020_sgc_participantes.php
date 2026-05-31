<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration for table: sgc_participantes
 * Columns: 14 | Rows in DB: 12339
 * Generated from existing database schema
 */
class Participantes extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'null' => false,
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'nombre' => [
                'null' => false,
                'type' => 'TEXT',
            ],
            'apellido' => [
                'null' => false,
                'type' => 'TEXT',
            ],
            'cedula' => [
                'null' => false,
                'type' => 'TEXT',
            ],
            'nacionalidad' => [
                'null' => false,
                'type' => 'CHAR',
                'constraint' => 1,
            ],
            'tipo_beneficiario' => [
                'null' => false,
                'type' => 'INT',
            ],
            'edad' => [
                'null' => true,
                'default' => 0,
                'type' => 'INT',
            ],
            'pais' => [
                'null' => false,
                'type' => 'INT',
            ],
            'estado' => [
                'null' => false,
                'type' => 'INT',
            ],
            'municipio' => [
                'null' => false,
                'type' => 'INT',
            ],
            'parroquia' => [
                'null' => false,
                'type' => 'INT',
            ],
            'telefono' => [
                'null' => false,
                'type' => 'TEXT',
            ],
            'sexo' => [
                'null' => false,
                'type' => 'CHAR',
                'constraint' => 1,
            ],
            'borrado' => [
                'null' => true,
                'default' => false,
                'type' => 'BOOLEAN',
            ],
        ]);

        $this->forge->addKey(['id'], true);

        $this->forge->createTable('sgc_participantes', true);
    }

    public function down()
    {
        $this->forge->dropTable('sgc_participantes', true);
    }
}

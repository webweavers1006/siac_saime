<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration for table: sgc_casos_coordenadas
 * Columns: 8 | Rows in DB: 26
 * Generated from existing database schema
 */
class CasosCoordenadas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_coord' => [
                'null' => false,
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'nombre' => [
                'null' => true,
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'latitud' => [
                'null' => true,
                'type' => 'DOUBLE',
            ],
            'longitud' => [
                'null' => true,
                'type' => 'DOUBLE',
            ],
            'fecha_creacion' => [
                'null' => true,
                'type' => 'TIMESTAMP',
            ],
            'idcaso' => [
                'null' => true,
                'type' => 'INT',
            ],
            'idusuopr' => [
                'null' => true,
                'type' => 'INT',
            ],
            'borrado' => [
                'null' => true,
                'default' => false,
                'type' => 'BOOLEAN',
            ],
        ]);

        $this->forge->addKey(['id_coord'], true);

        $this->forge->createTable('sgc_casos_coordenadas', true);
    }

    public function down()
    {
        $this->forge->dropTable('sgc_casos_coordenadas', true);
    }
}

<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration for table: sgc_terceros
 * Columns: 12 | Rows in DB: 8
 * Generated from existing database schema
 */
class Terceros extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'ter_id' => [
                'null' => false,
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'ter_nombre' => [
                'null' => false,
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'ter_tipo_per' => [
                'null' => true,
                'type' => 'VARCHAR',
                'constraint' => 1,
            ],
            'ter_identificacion' => [
                'null' => true,
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'ter_telefono' => [
                'null' => true,
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'ter_correo' => [
                'null' => true,
                'type' => 'TEXT',
            ],
            'ter_direccion' => [
                'null' => true,
                'type' => 'TEXT',
            ],
            'ter_pais' => [
                'null' => true,
                'type' => 'INT',
            ],
            'ter_estado' => [
                'null' => true,
                'type' => 'INT',
            ],
            'ter_municipio' => [
                'null' => true,
                'type' => 'INT',
            ],
            'ter_parroquia' => [
                'null' => true,
                'type' => 'INT',
            ],
            'ter_impre_abogado' => [
                'null' => true,
                'type' => 'TEXT',
            ],
        ]);

        $this->forge->addKey(['ter_id'], true);
        $this->forge->addKey(['ter_identificacion'], false, true); // sgc_sapi_terceros_ter_identificacion_key

        $this->forge->createTable('sgc_terceros', true);
    }

    public function down()
    {
        $this->forge->dropTable('sgc_terceros', true);
    }
}

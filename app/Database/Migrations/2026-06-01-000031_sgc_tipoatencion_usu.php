<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration for table: sgc_tipoatencion_usu
 * Columns: 9 | Rows in DB: 9
 * Generated from existing database schema
 */
class TipoatencionUsu extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'tipo_aten_id' => [
                'null' => false,
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'tipo_aten_nombre' => [
                'null' => false,
                'type' => 'TEXT',
            ],
            'tipo_aten_borrado' => [
                'null' => false,
                'default' => false,
                'type' => 'BOOLEAN',
            ],
            'act_pro_int' => [
                'null' => true,
                'default' => false,
                'type' => 'BOOLEAN',
            ],
            'acc_participantes' => [
                'null' => true,
                'default' => false,
                'type' => 'BOOLEAN',
            ],
            'env_correo' => [
                'null' => true,
                'default' => false,
                'type' => 'BOOLEAN',
            ],
            'organismo_pp' => [
                'null' => true,
                'default' => false,
                'type' => 'BOOLEAN',
            ],
            'act_coordenadas' => [
                'null' => true,
                'default' => false,
                'type' => 'BOOLEAN',
            ],
            'act_punto_cuenta' => [
                'null' => true,
                'default' => false,
                'type' => 'BOOLEAN',
            ],
        ]);

        $this->forge->addKey(['tipo_aten_id'], true);

        $this->forge->createTable('sgc_tipoatencion_usu', true);
    }

    public function down()
    {
        $this->forge->dropTable('sgc_tipoatencion_usu', true);
    }
}

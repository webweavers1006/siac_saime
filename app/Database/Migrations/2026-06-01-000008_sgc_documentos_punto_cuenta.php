<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration for table: sgc_documentos_punto_cuenta
 * Columns: 4 | Rows in DB: 1
 * Generated from existing database schema
 */
class DocumentosPuntoCuenta extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'docu_id' => [
                'null' => false,
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'docu_id_punto_cuenta' => [
                'null' => false,
                'type' => 'INT',
            ],
            'docu_ruta' => [
                'null' => false,
                'type' => 'TEXT',
            ],
            'docu_descripcion' => [
                'null' => true,
                'type' => 'TEXT',
            ],
        ]);

        $this->forge->addKey(['docu_id'], true);

        $this->forge->createTable('sgc_documentos_punto_cuenta', true);
    }

    public function down()
    {
        $this->forge->dropTable('sgc_documentos_punto_cuenta', true);
    }
}

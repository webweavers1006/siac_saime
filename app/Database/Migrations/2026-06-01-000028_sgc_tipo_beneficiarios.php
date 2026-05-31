<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration for table: sgc_tipo_beneficiarios
 * Columns: 3 | Rows in DB: 5
 * Generated from existing database schema
 */
class TipoBeneficiarios extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'tipo_beneficiario_id' => [
                'null' => false,
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'tipo_beneficiario_nombre' => [
                'null' => false,
                'type' => 'TEXT',
            ],
            'tipo_beneficiario_borrado' => [
                'null' => false,
                'default' => false,
                'type' => 'BOOLEAN',
            ],
        ]);



        $this->forge->createTable('sgc_tipo_beneficiarios', true);
    }

    public function down()
    {
        $this->forge->dropTable('sgc_tipo_beneficiarios', true);
    }
}

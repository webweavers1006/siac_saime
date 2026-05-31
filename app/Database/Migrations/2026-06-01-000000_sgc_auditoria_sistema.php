<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration for table: sgc_auditoria_sistema
 * Columns: 5 | Rows in DB: 67416
 * Generated from existing database schema
 */
class AuditoriaSistema extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'audi_id' => [
                'null' => false,
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'audi_user_id' => [
                'null' => false,
                'type' => 'INT',
            ],
            'audi_accion' => [
                'null' => false,
                'type' => 'TEXT',
            ],
            'audi_fecha' => [
                'null' => false,
                'type' => 'DATE',
            ],
            'audi_hora' => [
                'null' => true,
                'type' => 'VARCHAR',
                'constraint' => 11,
            ],
        ]);

        $this->forge->addKey(['audi_id'], true);

        $this->forge->createTable('sgc_auditoria_sistema', true);
    }

    public function down()
    {
        $this->forge->dropTable('sgc_auditoria_sistema', true);
    }
}

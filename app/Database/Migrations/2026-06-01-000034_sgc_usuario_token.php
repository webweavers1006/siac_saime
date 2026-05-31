<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration for table: sgc_usuario_token
 * Columns: 3 | Rows in DB: 1
 * Generated from existing database schema
 */
class UsuarioToken extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'null' => false,
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'id_usuario' => [
                'null' => false,
                'type' => 'INT',
            ],
            'token' => [
                'null' => true,
                'type' => 'TEXT',
            ],
        ]);

        $this->forge->addKey(['id_usuario'], true);

        $this->forge->createTable('sgc_usuario_token', true);
    }

    public function down()
    {
        $this->forge->dropTable('sgc_usuario_token', true);
    }
}

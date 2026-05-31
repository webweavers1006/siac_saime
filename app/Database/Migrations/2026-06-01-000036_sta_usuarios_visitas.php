<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration for table: sta_usuarios_visitas
 * Columns: 4 | Rows in DB: 141
 * Generated from existing database schema
 */
class UsuariosVisitas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'null' => false,
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'user_requests_ip' => [
                'null' => true,
                'type' => 'VARCHAR',
                'constraint' => 150,
            ],
            'fecha' => [
                'null' => true,
                'type' => 'DATE',
            ],
            'hora' => [
                'null' => true,
                'type' => 'VARCHAR',
                'constraint' => 11,
            ],
        ]);

        $this->forge->addKey(['id'], true);

        $this->forge->createTable('sta_usuarios_visitas', true);
    }

    public function down()
    {
        $this->forge->dropTable('sta_usuarios_visitas', true);
    }
}

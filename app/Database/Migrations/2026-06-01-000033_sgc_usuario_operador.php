<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration for table: sgc_usuario_operador
 * Columns: 10 | Rows in DB: 61
 * Generated from existing database schema
 */
class UsuarioOperador extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'idusuopr' => [
                'null' => false,
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'usuopnom' => [
                'null' => false,
                'type' => 'VARCHAR',
                'constraint' => 48,
            ],
            'usuopape' => [
                'null' => false,
                'type' => 'VARCHAR',
                'constraint' => 48,
            ],
            'usuoppass' => [
                'null' => false,
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'usuopemail' => [
                'null' => false,
                'type' => 'VARCHAR',
                'constraint' => 48,
            ],
            'idrol' => [
                'null' => false,
                'type' => 'INT',
            ],
            'usuopborrado' => [
                'null' => true,
                'default' => false,
                'type' => 'BOOLEAN',
            ],
            'usercargo' => [
                'null' => true,
                'type' => 'TEXT',
            ],
            'id_direccion_administrativa' => [
                'null' => true,
                'type' => 'INT',
            ],
            'acceso_audi' => [
                'null' => true,
                'default' => false,
                'type' => 'BOOLEAN',
            ],
        ]);

        $this->forge->addKey(['idusuopr'], true);
        $this->forge->addKey(['idusuopr'], false, true); // pk_sgc_usuario_operador
        $this->forge->createTable('sgc_usuario_operador', true);
    }

    public function down()
    {
        // Drop foreign keys        $this->forge->dropTable('sgc_usuario_operador', true);
    }
}

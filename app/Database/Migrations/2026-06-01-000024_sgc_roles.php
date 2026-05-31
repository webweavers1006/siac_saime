<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration for table: sgc_roles
 * Columns: 3 | Rows in DB: 8
 * Generated from existing database schema
 */
class Roles extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'idrol' => [
                'null' => false,
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'rolnom' => [
                'null' => false,
                'type' => 'VARCHAR',
                'constraint' => 48,
            ],
            'borrado' => [
                'null' => true,
                'default' => false,
                'type' => 'BOOLEAN',
            ],
        ]);

        $this->forge->addKey(['idrol'], true);
        $this->forge->addKey(['idrol'], false, true); // pk_sgc_roles

        $this->forge->createTable('sgc_roles', true);
    }

    public function down()
    {
        $this->forge->dropTable('sgc_roles', true);
    }
}

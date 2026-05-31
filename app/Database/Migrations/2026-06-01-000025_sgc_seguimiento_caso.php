<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration for table: sgc_seguimiento_caso
 * Columns: 7 | Rows in DB: 68997
 * Generated from existing database schema
 */
class SeguimientoCaso extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'idsegcas' => [
                'null' => false,
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'idcaso' => [
                'null' => false,
                'type' => 'INT',
            ],
            'idestllam' => [
                'null' => false,
                'type' => 'INT',
            ],
            'segcoment' => [
                'null' => false,
                'type' => 'VARCHAR',
                'constraint' => 512,
            ],
            'segfec' => [
                'null' => false,
                'type' => 'DATE',
            ],
            'idusuopr' => [
                'null' => false,
                'type' => 'INT',
            ],
            'borrado' => [
                'null' => true,
                'default' => false,
                'type' => 'BOOLEAN',
            ],
        ]);

        $this->forge->addKey(['idsegcas'], true);
        $this->forge->addKey(['idsegcas'], false, true); // pk_sgc_seguimiento_caso


        $this->forge->createTable('sgc_seguimiento_caso', true);
    }

    public function down()
    {
        // Drop foreign keys        $this->forge->dropTable('sgc_seguimiento_caso', true);
    }
}

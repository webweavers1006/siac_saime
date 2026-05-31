<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration for table: sgc_org_pod_popular
 * Columns: 3 | Rows in DB: 3
 * Generated from existing database schema
 */
class OrgPodPopular extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'org_id' => [
                'null' => false,
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'org_nombre' => [
                'null' => false,
                'type' => 'TEXT',
            ],
            'org_borrado' => [
                'null' => false,
                'default' => false,
                'type' => 'BOOLEAN',
            ],
        ]);

        $this->forge->addKey(['org_id'], true);

        $this->forge->createTable('sgc_org_pod_popular', true);
    }

    public function down()
    {
        $this->forge->dropTable('sgc_org_pod_popular', true);
    }
}

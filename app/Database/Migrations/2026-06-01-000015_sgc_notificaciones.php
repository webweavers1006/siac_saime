<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration for table: sgc_notificaciones
 * Columns: 11 | Rows in DB: 11687
 * Generated from existing database schema
 */
class Notificaciones extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'null' => false,
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'id_caso' => [
                'null' => true,
                'type' => 'INT',
            ],
            'tipo_notificacion' => [
                'null' => false,
                'default' => 'REMISION',
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'mensaje' => [
                'null' => false,
                'type' => 'TEXT',
            ],
            'leida' => [
                'null' => false,
                'default' => false,
                'type' => 'BOOLEAN',
            ],
            'fecha_creacion' => [
                'null' => false,
                'type' => 'TIMESTAMP',
            ],
            'id_usuario_destino' => [
                'null' => false,
                'type' => 'INT',
            ],
            'id_usuario_accion' => [
                'null' => false,
                'type' => 'INT',
            ],
            'id_rol_accion' => [
                'null' => false,
                'type' => 'INT',
            ],
            'id_caso_autor' => [
                'null' => false,
                'type' => 'INT',
            ],
            'direccion_origen' => [
                'null' => true,
                'type' => 'INT',
            ],
        ]);

        $this->forge->addKey(['id'], true);
        $this->forge->addKey(['id_usuario_accion', 'id_usuario_destino']); // idx_notif_evitar_autoaccion
        $this->forge->addKey(['id_caso_autor']); // idx_notif_reglas_rol2
        $this->forge->addKey(['fecha_creacion DESC']); // idx_notificaciones_fecha



        $this->forge->createTable('sgc_notificaciones', true);
    }

    public function down()
    {
        // Drop foreign keys        $this->forge->dropTable('sgc_notificaciones', true);
    }
}

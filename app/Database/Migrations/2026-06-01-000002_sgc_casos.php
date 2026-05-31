<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration for table: sgc_casos
 * Columns: 31 | Rows in DB: 58192
 * Generated from existing database schema
 */
class Casos extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'idcaso' => [
                'null' => false,
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'casofec' => [
                'null' => false,
                'type' => 'DATE',
            ],
            'casoced' => [
                'null' => false,
                'type' => 'VARCHAR',
                'constraint' => 48,
            ],
            'casonom' => [
                'null' => false,
                'type' => 'VARCHAR',
                'constraint' => 48,
            ],
            'casoape' => [
                'null' => false,
                'type' => 'VARCHAR',
                'constraint' => 48,
            ],
            'casotel' => [
                'null' => false,
                'type' => 'VARCHAR',
                'constraint' => 48,
            ],
            'casonumsol' => [
                'null' => false,
                'type' => 'VARCHAR',
                'constraint' => 48,
            ],
            'idest' => [
                'null' => false,
                'type' => 'INT',
            ],
            'idrrss' => [
                'null' => false,
                'type' => 'INT',
            ],
            'idusuopr' => [
                'null' => false,
                'type' => 'INT',
            ],
            'estadoid' => [
                'null' => false,
                'type' => 'INT',
            ],
            'municipioid' => [
                'null' => false,
                'type' => 'INT',
            ],
            'parroquiaid' => [
                'null' => false,
                'type' => 'INT',
            ],
            'ofiid' => [
                'null' => false,
                'type' => 'INT',
            ],
            'casodesc' => [
                'null' => false,
                'type' => 'VARCHAR',
                'constraint' => 4096,
            ],
            'id_tipo_atencion' => [
                'null' => true,
                'default' => 0,
                'type' => 'INT',
            ],
            'sexo' => [
                'null' => true,
                'type' => 'INT',
            ],
            'caso_nacionalidad' => [
                'null' => true,
                'type' => 'VARCHAR',
                'constraint' => 1,
            ],
            'borrado' => [
                'null' => true,
                'default' => false,
                'type' => 'BOOLEAN',
            ],
            'tipo_beneficiario' => [
                'null' => true,
                'default' => 1,
                'type' => 'INT',
            ],
            'direccion' => [
                'null' => true,
                'type' => 'TEXT',
            ],
            'correo' => [
                'null' => true,
                'type' => 'TEXT',
            ],
            'ente_adscrito_id' => [
                'null' => true,
                'type' => 'INT',
            ],
            'caso_hora' => [
                'null' => true,
                'type' => 'TEXT',
            ],
            'edad' => [
                'null' => true,
                'type' => 'INT',
            ],
            'fecha_nacimiento' => [
                'null' => true,
                'type' => 'DATE',
            ],
            'profesion' => [
                'null' => true,
                'type' => 'TEXT',
            ],
            'tipo_atend_id' => [
                'null' => true,
                'type' => 'INT',
            ],
            'pais' => [
                'null' => true,
                'default' => 1,
                'type' => 'INT',
            ],
            'caso_org_id' => [
                'null' => true,
                'type' => 'INT',
            ],
            'created_at' => [
                'null' => true,
                'type' => 'TIMESTAMP',
            ],
        ]);

        $this->forge->addKey(['idcaso'], true);
        $this->forge->addKey(['idcaso'], false, true); // pk_sgc_casos





        $this->forge->createTable('sgc_casos', true);
    }

    public function down()
    {
        // Drop foreign keys        $this->forge->dropTable('sgc_casos', true);
    }
}

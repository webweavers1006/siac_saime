<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration: Agrega columna tipo_beneficiario_requiere_cedula a sgc_tipo_beneficiarios
 * 
 * Permite indicar si un tipo de beneficiario requiere cédula obligatoria.
 * - true  → cédula requerida (Venezolano, Extranjero con cédula)
 * - false → cédula opcional  (Extranjero sin cédula)
 */
class AgregaRequiereCedulaBeneficiarios extends Migration
{
    public function up()
    {
        $this->forge->addColumn('sgc_tipo_beneficiarios', [
            'tipo_beneficiario_requiere_cedula' => [
                'type'       => 'BOOLEAN',
                'null'       => false,
                'default'    => true,
                'after'      => 'tipo_beneficiario_nombre',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('sgc_tipo_beneficiarios', 'tipo_beneficiario_requiere_cedula');
    }
}

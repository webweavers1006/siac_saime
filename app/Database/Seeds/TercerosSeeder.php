<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Seeder for table: sgc_terceros (8 rows)
 * Generated from existing database data
 */
class TercerosSeeder extends Seeder
{
    public function run()
    {
        $this->db->query('TRUNCATE TABLE sgc_terceros CASCADE');

        $this->db->table('sgc_terceros')->insertBatch([
            [
                'ter_id' => 0,
                'ter_nombre' => 'N/A',
                'ter_tipo_per' => 'V',
                'ter_identificacion' => 'N/A',
                'ter_telefono' => 'N/A',
                'ter_correo' => 'N/A',
                'ter_direccion' => 'N/A',
                'ter_pais' => 0,
                'ter_estado' => 0,
                'ter_municipio' => 0,
                'ter_parroquia' => 0,
                'ter_impre_abogado' => 'N/A',
            ],
            [
                'ter_id' => 1,
                'ter_nombre' => 'FREDDY TORRES PRUEBA ',
                'ter_tipo_per' => 'V',
                'ter_identificacion' => '19933177',
                'ter_telefono' => '04143995654',
                'ter_correo' => 'FREDDY@GMAIL.COM',
                'ter_direccion' => 'LA VEGA ',
                'ter_pais' => 1,
                'ter_estado' => 14,
                'ter_municipio' => 166,
                'ter_parroquia' => 571,
                'ter_impre_abogado' => null,
            ],
            [
                'ter_id' => 2,
                'ter_nombre' => 'MARIA MORRILLO',
                'ter_tipo_per' => 'V',
                'ter_identificacion' => '22912510',
                'ter_telefono' => '0412532045',
                'ter_correo' => 'MARIA@GMAIL.COM',
                'ter_direccion' => 'LA ZULIA ',
                'ter_pais' => 1,
                'ter_estado' => 16,
                'ter_municipio' => 200,
                'ter_parroquia' => 669,
                'ter_impre_abogado' => null,
            ],
            [
                'ter_id' => 3,
                'ter_nombre' => 'wdwdwdwdwdwd',
                'ter_tipo_per' => 'V',
                'ter_identificacion' => '27038431',
                'ter_telefono' => '2012221234',
                'ter_correo' => 'elychirivella10@gmail.com',
                'ter_direccion' => 'Carolinewdwdwdwdwddwdwdwd',
                'ter_pais' => 1,
                'ter_estado' => 17,
                'ter_municipio' => 222,
                'ter_parroquia' => 725,
                'ter_impre_abogado' => null,
            ],
            [
                'ter_id' => 4,
                'ter_nombre' => 'EDWIN FREITES',
                'ter_tipo_per' => 'V',
                'ter_identificacion' => '',
                'ter_telefono' => '04241916993',
                'ter_correo' => 'SOLOYOFREITES@GMAIL.COM',
                'ter_direccion' => '',
                'ter_pais' => 1,
                'ter_estado' => 24,
                'ter_municipio' => 1,
                'ter_parroquia' => 18,
                'ter_impre_abogado' => null,
            ],
            [
                'ter_id' => 5,
                'ter_nombre' => 'Lisandro Peña',
                'ter_tipo_per' => 'V',
                'ter_identificacion' => '23638763',
                'ter_telefono' => '04141874631',
                'ter_correo' => 'lisandro62796@gmail.com',
                'ter_direccion' => 'El paraiso',
                'ter_pais' => 1,
                'ter_estado' => 24,
                'ter_municipio' => 1,
                'ter_parroquia' => 22,
                'ter_impre_abogado' => null,
            ],
            [
                'ter_id' => 6,
                'ter_nombre' => 'EL DISCO DE MODA C.A.',
                'ter_tipo_per' => 'V',
                'ter_identificacion' => '5413884',
                'ter_telefono' => '4815627',
                'ter_correo' => 'DISCOMODA.MUSIC@GMAIL.COM',
                'ter_direccion' => 'PIEDRAS A PALMITA, RES. SANTA MARTA, MEZZ. A Y B, PARROQUIA STA. TERESA, QTA. CRESPO CARACAS, VENEZUELA',
                'ter_pais' => 1,
                'ter_estado' => null,
                'ter_municipio' => null,
                'ter_parroquia' => null,
                'ter_impre_abogado' => null,
            ],
            [
                'ter_id' => 7,
                'ter_nombre' => 'DISPOCERCA CA',
                'ter_tipo_per' => 'J',
                'ter_identificacion' => 'J309202006',
                'ter_telefono' => '02446616298',
                'ter_correo' => 'CONTABILIDADISPOCERCA@GMAIL.COM',
                'ter_direccion' => 'AV  INDUSTRIAL SUR  N° 58, ZONA INDUSTRIAL II TERCERA. URB RESIDENCIAL SAN PABLO ETAPA II',
                'ter_pais' => 1,
                'ter_estado' => null,
                'ter_municipio' => null,
                'ter_parroquia' => null,
                'ter_impre_abogado' => null,
            ],
        ]);

    }
}

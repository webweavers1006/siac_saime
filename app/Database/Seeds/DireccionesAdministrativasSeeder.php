<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Seeder for table: sgc_direcciones_administrativas (27 rows)
 * Generated from existing database data
 */
class DireccionesAdministrativasSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('sgc_direcciones_administrativas')->truncate();

        $this->db->table('sgc_direcciones_administrativas')->insertBatch([
            [
                'id' => 1,
                'descripcion' => 'DIVISIÓN DE INVENCIONES Y NUEVAS TECNOLOGIAS',
                'borrado' => false,
                'correo' => 'dint@sapi.gob.ve',
                'act_aud' => true,
            ],
            [
                'id' => 2,
                'descripcion' => 'DIRECCIÓN DE ATENCIÓN Y GESTIÓN ESTADAL',
                'borrado' => false,
                'correo' => 'dae@sapi.gob.ve',
                'act_aud' => false,
            ],
            [
                'id' => 3,
                'descripcion' => 'COORDINACIÒN DE INDICACIONES GEOGRÁFICAS PROTEGIDAS',
                'borrado' => false,
                'correo' => 'digp@sapi.gob.ve',
                'act_aud' => false,
            ],
            [
                'id' => 4,
                'descripcion' => 'DIRECCIÓN NACIONAL DE DERECHO DE AUTOR',
                'borrado' => false,
                'correo' => 'dnda@sapi.gob.ve',
                'act_aud' => false,
            ],
            [
                'id' => 5,
                'descripcion' => 'DIRECCIÓN DE  REGISTRO DE LA PROPIEDAD INDUSTRIAL',
                'borrado' => true,
                'correo' => 'drpi@sapi.gob.ve',
                'act_aud' => true,
            ],
            [
                'id' => 6,
                'descripcion' => 'COODINACIÓN DE MARCAS',
                'borrado' => true,
                'correo' => 'coordinacion.marcas@sapi.gob.ve',
                'act_aud' => false,
            ],
            [
                'id' => 7,
                'descripcion' => 'DIRECCIÓN GENERAL',
                'borrado' => false,
                'correo' => 'dg@sapi.gob.ve',
                'act_aud' => false,
            ],
            [
                'id' => 8,
                'descripcion' => 'OFICINA DE GESTIÓN HUMANA',
                'borrado' => true,
                'correo' => 'ogh@sapi.gob.ve',
                'act_aud' => false,
            ],
            [
                'id' => 9,
                'descripcion' => 'ASESORÍA JURÍDICA',
                'borrado' => false,
                'correo' => 'aj@sapi.gob.ve',
                'act_aud' => false,
            ],
            [
                'id' => 11,
                'descripcion' => 'OFICINA DE TECNOLOGÍAS DE LA INFORMACIÓN Y LA COMUNICACIÓN',
                'borrado' => true,
                'correo' => 'otic@sapi.gob.ve',
                'act_aud' => false,
            ],
            [
                'id' => 12,
                'descripcion' => 'OFICINA DE PLANIFICACIÓN Y PRESUPUESTO',
                'borrado' => true,
                'correo' => 'opp@sapi.gob.ve',
                'act_aud' => false,
            ],
            [
                'id' => 13,
                'descripcion' => 'OFICINA DE RELACIONES INTERNACIONALES',
                'borrado' => true,
                'correo' => 'ori@sapi.gob.ve',
                'act_aud' => false,
            ],
            [
                'id' => 14,
                'descripcion' => 'OFICINA DE GESTIÓN COMUNICACIONAL',
                'borrado' => true,
                'correo' => 'ogc@sapi.gob.ve',
                'act_aud' => false,
            ],
            [
                'id' => 15,
                'descripcion' => 'OFICINA DE ATENCIÓN CIUDADANA',
                'borrado' => false,
                'correo' => 'oac@sapi.gob.ve',
                'act_aud' => false,
            ],
            [
                'id' => 16,
                'descripcion' => 'OFICINA DE GESTIÓN ADMINISTRATIVA',
                'borrado' => false,
                'correo' => 'oga@sapi.gob.ve',
                'act_aud' => false,
            ],
            [
                'id' => 17,
                'descripcion' => 'OFICINA DE SEGUIMIENTO Y EVALUACIÓN DE POLÍTICAS PÚBLICAS',
                'borrado' => true,
                'correo' => 'osepp@sapi.gob.ve',
                'act_aud' => false,
            ],
            [
                'id' => 20,
                'descripcion' => 'DIRECCIÓN DE  DESPACHO',
                'borrado' => true,
                'correo' => 'dp@sapi.gob.ve',
                'act_aud' => false,
            ],
            [
                'id' => 21,
                'descripcion' => 'DIRECCIÓN DE INFORMATICA',
                'borrado' => true,
                'correo' => 'luis.giron@sapi.gob.ve',
                'act_aud' => false,
            ],
            [
                'id' => 22,
                'descripcion' => 'COORDINACIÓN DE RECEPCIÓN Y ATENCION AL USUARIO',
                'borrado' => false,
                'correo' => 'cti@sapi.gob.ve',
                'act_aud' => false,
            ],
            [
                'id' => 24,
                'descripcion' => 'DIVISIÓN TÉCNICA DE PROPIEDAD INDUSTRIAL ',
                'borrado' => false,
                'correo' => 'cr@sapi.gob.ve',
                'act_aud' => false,
            ],
            [
                'id' => 25,
                'descripcion' => 'DIVISIÓN DE SIGNOS DISTINTIVOS',
                'borrado' => false,
                'correo' => 'dmosd@sapi.gob.ve',
                'act_aud' => true,
            ],
            [
                'id' => 26,
                'descripcion' => 'COORDINACIÓN DE ARCHIVO GENERAL',
                'borrado' => true,
                'correo' => 'cag@sapi.gob.ve',
                'act_aud' => false,
            ],
            [
                'id' => 27,
                'descripcion' => 'COORDINACIÓN DE SEGURIDAD',
                'borrado' => true,
                'correo' => 'cs@sapi.gob.ve',
                'act_aud' => false,
            ],
            [
                'id' => 28,
                'descripcion' => 'COORDINACIÓN DE SERVICIOS GENERALES',
                'borrado' => true,
                'correo' => 'csg@sapi.gob.ve',
                'act_aud' => false,
            ],
            [
                'id' => 29,
                'descripcion' => 'COORDINACIÓN DE ALMACEN',
                'borrado' => true,
                'correo' => 'ca@sapi.gob.ve',
                'act_aud' => false,
            ],
            [
                'id' => 30,
                'descripcion' => 'COORDINACIÓN DE OPOSICIONES',
                'borrado' => true,
                'correo' => 'co@sapi.gob.ve',
                'act_aud' => false,
            ],
            [
                'id' => 31,
                'descripcion' => 'COORDINACIÓN DE SERVICIO MÉDICO',
                'borrado' => true,
                'correo' => 'csm@sapi.gob.ve',
                'act_aud' => false,
            ],
        ]);

    }
}

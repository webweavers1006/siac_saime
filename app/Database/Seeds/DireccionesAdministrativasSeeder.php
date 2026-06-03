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
        $this->db->query('TRUNCATE TABLE sgc_direcciones_administrativas CASCADE');

        $this->db->table('sgc_direcciones_administrativas')->insertBatch([
            [
                'id' => 3,
                'descripcion' => 'DIRECCIÓN GENERAL SAIME',
                'borrado' => false,
                'correo' => 'dg@saime.gob.ve',
                'act_aud' => false,
            ],
            [
                'id' => 4,
                'descripcion' => 'COMISIÓN NACIONAL DE MIGRACIÓN',
                'borrado' => false,
                'correo' => 'cnm@saime.gob.ve',
                'act_aud' => false,
            ],

            // --- NIVEL DE APOYO ---
            [
                'id' => 5,
                'descripcion' => 'ASESORÍA LEGAL',
                'borrado' => false,
                'correo' => 'al@saime.gob.ve',
                'act_aud' => false,
            ],
            [
                'id' => 6,
                'descripcion' => 'INSPECTORÍA GENERAL DE LOS SERVICIOS',
                'borrado' => false,
                'correo' => 'igs@saime.gob.ve',
                'act_aud' => false,
            ],
            [
                'id' => 7,
                'descripcion' => 'OFICINA DE GESTIÓN ADMINISTRACIÓN',
                'borrado' => false,
                'correo' => 'oga@saime.gob.ve',
                'act_aud' => false,
            ],
            [
                'id' => 8,
                'descripcion' => 'OFICINA DE PLANIFICACIÓN, PRESUPUESTO Y ORGANIZACIÓN',
                'borrado' => false,
                'correo' => 'oppo@saime.gob.ve',
                'act_aud' => false,
            ],
            [
                'id' => 9,
                'descripcion' => 'OFICINA DE COMUNICACIÓN Y RELACIONES INSTITUCIONALES',
                'borrado' => false,
                'correo' => 'ocri@saime.gob.ve',
                'act_aud' => false,
            ],
            [
                'id' => 10,
                'descripcion' => 'OFICINA DE ATENCIÓN AL CIUDADANO',
                'borrado' => false,
                'correo' => 'oac@saime.gob.ve',
                'act_aud' => false,
            ],
            [
                'id' => 11,
                'descripcion' => 'OFICINA DE GESTIÓN HUMANA',
                'borrado' => false,
                'correo' => 'ogh@saime.gob.ve',
                'act_aud' => false,
            ],
            [
                'id' => 12,
                'descripcion' => 'OFICINA DE PREVENCIÓN Y SEGURIDAD INTEGRAL',
                'borrado' => false,
                'correo' => 'opsi@saime.gob.ve',
                'act_aud' => false,
            ],
            [
                'id' => 13,
                'descripcion' => 'OFICINA DE TECNOLOGÍA DE LA INFORMACIÓN Y LA COMUNICACIÓN',
                'borrado' => false,
                'correo' => 'otic@saime.gob.ve',
                'act_aud' => false,
            ],
            [
                'id' => 14,
                'descripcion' => 'ATENCIÓN AL CIUDADANO',
                'borrado' => false,
                'correo' => 'atencion.ciudadano@saime.gob.ve',
                'act_aud' => false,
            ],

            // --- NIVEL SUSTANTIVO ---
            [
                'id' => 15,
                'descripcion' => 'DIRECCIÓN DE IDENTIFICACIÓN',
                'borrado' => false,
                'correo' => 'di@saime.gob.ve',
                'act_aud' => false,
            ],
            [
                'id' => 16,
                'descripcion' => 'DIRECCIÓN DE MIGRACIÓN',
                'borrado' => false,
                'correo' => 'dm@saime.gob.ve',
                'act_aud' => false,
            ],
            [
                'id' => 17,
                'descripcion' => 'DIRECCIÓN DE EXTRANJERÍA',
                'borrado' => false,
                'correo' => 'de@saime.gob.ve',
                'act_aud' => false,
            ],
            [
                'id' => 18,
                'descripcion' => 'DIRECCIÓN DE VERIFICACIÓN REGISTRO',
                'borrado' => false,
                'correo' => 'dvr@saime.gob.ve',
                'act_aud' => false,
            ],
            [
                'id' => 19,
                'descripcion' => 'DIRECCIÓN DE EMISIÓN DE DOCUMENTOS',
                'borrado' => false,
                'correo' => 'ded@saime.gob.ve',
                'act_aud' => false,
            ],
            [
                'id' => 20,
                'descripcion' => 'DIRECCIÓN DE REGIONES',
                'borrado' => false,
                'correo' => 'dr@saime.gob.ve',
                'act_aud' => false,
            ],

            // --- NIVEL OPERATIVO DESCONCENTRADO TERRITORIALMENTE ---
            [
                'id' => 21,
                'descripcion' => 'OFICINAS SAIME',
                'borrado' => false,
                'correo' => 'oficinas@saime.gob.ve',
                'act_aud' => false,
            ],
            [
                'id' => 22,
                'descripcion' => 'PUNTOS DE CONTROL MIGRATORIO',
                'borrado' => false,
                'correo' => 'pcm@saime.gob.ve',
                'act_aud' => false,
            ],
        ]);

    }
}

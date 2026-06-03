<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Seeder for table: sgc_motivos
 * Motivos agrupados por cabecera (tipo_prop_id → sgc_tipo_prop_intelec).
 * Cada motivo pertenece a una cabecera específica para filtrado dinámico.
 */
class MotivosSeeder extends Seeder
{
    public function run()
    {
        $this->db->query('TRUNCATE TABLE sgc_motivos CASCADE');

        $this->db->table('sgc_motivos')->insertBatch([
        // ============================================================
            // Caso Externo (tipo_prop_id = 2)
            // ============================================================
            ['motivo_id' => 1,   'tipo_prop_id' => 2, 'motivo_nombre' => 'Caso Externo (Otro Ente)',              'motivo_borrado' => false],

            // ============================================================
            // Extranjería (tipo_prop_id = 3) — 22 motivos
            // ============================================================
            ['motivo_id' => 2,   'tipo_prop_id' => 3, 'motivo_nombre' => 'Anulación de Prorroga (sistema)',        'motivo_borrado' => false],
            ['motivo_id' => 3,   'tipo_prop_id' => 3, 'motivo_nombre' => 'Cambio De Condición (Extranjero)',       'motivo_borrado' => false],
            ['motivo_id' => 4,   'tipo_prop_id' => 3, 'motivo_nombre' => 'Certificado de Naturalización',          'motivo_borrado' => false],
            ['motivo_id' => 5,   'tipo_prop_id' => 3, 'motivo_nombre' => 'Certificado de No Naturalización',       'motivo_borrado' => false],
            ['motivo_id' => 6,   'tipo_prop_id' => 3, 'motivo_nombre' => 'Constancia De No Naturalizados',         'motivo_borrado' => false],
            ['motivo_id' => 7,   'tipo_prop_id' => 3, 'motivo_nombre' => 'Estudio De Permanencia',                 'motivo_borrado' => false],
            ['motivo_id' => 8,   'tipo_prop_id' => 3, 'motivo_nombre' => 'Naturalización',                         'motivo_borrado' => false],
            ['motivo_id' => 9,   'tipo_prop_id' => 3, 'motivo_nombre' => 'Prorroga De Residente',                  'motivo_borrado' => false],
            ['motivo_id' => 10,  'tipo_prop_id' => 3, 'motivo_nombre' => 'Prorroga Visa Turista',                  'motivo_borrado' => false],
            ['motivo_id' => 11,  'tipo_prop_id' => 3, 'motivo_nombre' => 'Rechazado por Dirección / Visa',         'motivo_borrado' => false],
            ['motivo_id' => 12,  'tipo_prop_id' => 3, 'motivo_nombre' => 'Recuento',                               'motivo_borrado' => false],
            ['motivo_id' => 13,  'tipo_prop_id' => 3, 'motivo_nombre' => 'Requisitos para Naturalización',          'motivo_borrado' => false],
            ['motivo_id' => 14,  'tipo_prop_id' => 3, 'motivo_nombre' => 'Validación de Pago - Duplicado',          'motivo_borrado' => false],
            ['motivo_id' => 15,  'tipo_prop_id' => 3, 'motivo_nombre' => 'Validación de Pago - Visa',               'motivo_borrado' => false],
            ['motivo_id' => 16,  'tipo_prop_id' => 3, 'motivo_nombre' => 'Validación de Pago (Visa)',               'motivo_borrado' => false],
            ['motivo_id' => 17,  'tipo_prop_id' => 3, 'motivo_nombre' => 'Verificación de Datos',                  'motivo_borrado' => false],
            ['motivo_id' => 18,  'tipo_prop_id' => 3, 'motivo_nombre' => 'Visa Transeunte Estudiante',             'motivo_borrado' => false],
            ['motivo_id' => 19,  'tipo_prop_id' => 3, 'motivo_nombre' => 'Visa Transeunte Familiar Venezolano',    'motivo_borrado' => false],
            ['motivo_id' => 20,  'tipo_prop_id' => 3, 'motivo_nombre' => 'Visa Transeunte Laboral',                'motivo_borrado' => false],
            ['motivo_id' => 21,  'tipo_prop_id' => 3, 'motivo_nombre' => 'Visa Transeunte Rentista',               'motivo_borrado' => false],
            ['motivo_id' => 22,  'tipo_prop_id' => 3, 'motivo_nombre' => 'Visa Transeunte Simple',                 'motivo_borrado' => false],
            ['motivo_id' => 23,  'tipo_prop_id' => 3, 'motivo_nombre' => 'Visa Turista',                           'motivo_borrado' => false],

            // ============================================================
            // Identificación (tipo_prop_id = 4) — 102 motivos
            // ============================================================
            ['motivo_id' => 24,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Actualización de Datos',                                           'motivo_borrado' => false],
            ['motivo_id' => 25,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Actualización de Datos Civiles',                                    'motivo_borrado' => false],
            ['motivo_id' => 26,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Anulación de Pasaporte',                                            'motivo_borrado' => false],
            ['motivo_id' => 27,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Anulación de Pasaporte/Prórroga',                                   'motivo_borrado' => false],
            ['motivo_id' => 28,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Bloqueo Renovación De Cédula 6 Meses',                              'motivo_borrado' => false],
            ['motivo_id' => 29,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Cambio de Contraseña',                                              'motivo_borrado' => false],
            ['motivo_id' => 30,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Cambio de Correo',                                                  'motivo_borrado' => false],
            ['motivo_id' => 31,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Cambio de Correo/Consulado',                                        'motivo_borrado' => false],
            ['motivo_id' => 32,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Cambio de Estado Civil',                                            'motivo_borrado' => false],
            ['motivo_id' => 33,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Cambio de Número Telefónico',                                       'motivo_borrado' => false],
            ['motivo_id' => 34,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Cambio Modalidad de Pasaporte (Ordinario a Habilitado)',             'motivo_borrado' => false],
            ['motivo_id' => 35,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Cédula (Naturalizado)',                                             'motivo_borrado' => false],
            ['motivo_id' => 36,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Cedulación Extranjero',                                             'motivo_borrado' => false],
            ['motivo_id' => 37,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Cedulación Indígena',                                               'motivo_borrado' => false],
            ['motivo_id' => 38,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Cedulación Por Primera Vez',                                        'motivo_borrado' => false],
            ['motivo_id' => 39,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Cedulación por Primera Vez Para Mayor de 18 años Nacidos en Venezuela', 'motivo_borrado' => false],
            ['motivo_id' => 40,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Cedulación por Primera Vez Para Mayor de 18 Años Nacidos en Venezuela (Hijos de Madre Extranjera)', 'motivo_borrado' => false],
            ['motivo_id' => 41,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Certificación de Pasaporte',                                         'motivo_borrado' => false],
            ['motivo_id' => 42,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Certificación de Pasaporte, Recuento',                               'motivo_borrado' => false],
            ['motivo_id' => 43,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Colocacion Familiar',                                                'motivo_borrado' => false],
            ['motivo_id' => 44,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Congestión (Pago - Plataforma Saime)',                               'motivo_borrado' => false],
            ['motivo_id' => 45,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Consulta Certificación de Pasaporte',                                'motivo_borrado' => false],
            ['motivo_id' => 46,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Consulta de Prorroga de Pasaporte',                                  'motivo_borrado' => false],
            ['motivo_id' => 47,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Consulta Documento de Viaje (Salvoconducto)',                        'motivo_borrado' => false],
            ['motivo_id' => 48,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Consulta Pasaporte Habilitado',                                      'motivo_borrado' => false],
            ['motivo_id' => 49,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Consulta Pasaporte Ordinario',                                       'motivo_borrado' => false],
            ['motivo_id' => 50,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Consulta Ubicación de Pasaporte Consular (Argentina)',               'motivo_borrado' => false],
            ['motivo_id' => 51,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Consulta Ubicación de Pasaporte Consular (Chile)',                   'motivo_borrado' => false],
            ['motivo_id' => 52,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Consulta Ubicación de Pasaporte Consular (Colombia)',                'motivo_borrado' => false],
            ['motivo_id' => 53,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Consulta Ubicación de Pasaporte Consular (México)',                  'motivo_borrado' => false],
            ['motivo_id' => 54,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Correo/ Toquen Invalido',                                            'motivo_borrado' => false],
            ['motivo_id' => 55,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Creación de Usuario',                                                'motivo_borrado' => false],
            ['motivo_id' => 56,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Desbloqueo de Cita',                                                 'motivo_borrado' => false],
            ['motivo_id' => 57,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Doble Cedulación',                                                   'motivo_borrado' => false],
            ['motivo_id' => 58,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Doble Filiación',                                                    'motivo_borrado' => false],
            ['motivo_id' => 59,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Error en Cedulación (Fecha de Emisión Incorrecta)',                  'motivo_borrado' => false],
            ['motivo_id' => 60,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Error en Cédulación (Foto Errada)',                                  'motivo_borrado' => false],
            ['motivo_id' => 61,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Error en Manejo de Plataforma SAIME',                                'motivo_borrado' => false],
            ['motivo_id' => 62,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Error en Sistema (Pago Pasaporte)',                                  'motivo_borrado' => false],
            ['motivo_id' => 63,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Error en Sistema (Responsabilidad Legal)',                           'motivo_borrado' => false],
            ['motivo_id' => 64,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Error en Sistema / 24 horas',                                        'motivo_borrado' => false],
            ['motivo_id' => 65,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Error en Sistema/ Pago Pasaporte',                                   'motivo_borrado' => false],
            ['motivo_id' => 66,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Error en Sistema/ Responsabilidad legal',                            'motivo_borrado' => false],
            ['motivo_id' => 67,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Estatus de Pasaporte',                                               'motivo_borrado' => false],
            ['motivo_id' => 68,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Extravío de Cédula',                                                 'motivo_borrado' => false],
            ['motivo_id' => 69,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Homologación de Pago (Pasaporte)',                                   'motivo_borrado' => false],
            ['motivo_id' => 70,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Inclusión De Sistema',                                               'motivo_borrado' => false],
            ['motivo_id' => 71,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Inconsistencia (Plataforma Indica Fallecido)',                      'motivo_borrado' => false],
            ['motivo_id' => 72,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Inconsistencia de Datos',                                            'motivo_borrado' => false],
            ['motivo_id' => 73,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Inconsistencia en registro de NNA',                                  'motivo_borrado' => false],
            ['motivo_id' => 74,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Incosistencia Estado Civil',                                         'motivo_borrado' => false],
            ['motivo_id' => 75,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Información para Olvido de Contraseña',                              'motivo_borrado' => false],
            ['motivo_id' => 76,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Invasión de Serial',                                                 'motivo_borrado' => false],
            ['motivo_id' => 77,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Jornada de Cedulación',                                              'motivo_borrado' => false],
            ['motivo_id' => 78,  'tipo_prop_id' => 4, 'motivo_nombre' => 'No Aparece Centro Hospitalario',                                     'motivo_borrado' => false],
            ['motivo_id' => 79,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Objeción (Restriccion Militar)',                                     'motivo_borrado' => false],
            ['motivo_id' => 80,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Objetado por Físcalia CNE',                                          'motivo_borrado' => false],
            ['motivo_id' => 81,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Pago a Domicilio/Pasaporte Consular',                                'motivo_borrado' => false],
            ['motivo_id' => 82,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Pasaporte (Error de Concurrencia)',                                  'motivo_borrado' => false],
            ['motivo_id' => 83,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Pasaporte Consular',                                                 'motivo_borrado' => false],
            ['motivo_id' => 84,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Pasaporte Extranjero',                                               'motivo_borrado' => false],
            ['motivo_id' => 85,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Pasaporte Habilitado',                                               'motivo_borrado' => false],
            ['motivo_id' => 86,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Pasaporte Ordinario',                                                'motivo_borrado' => false],
            ['motivo_id' => 87,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Pasaporte Retenido Legalmente',                                      'motivo_borrado' => false],
            ['motivo_id' => 88,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Pasaporte sin Avance (Etiqueta Impresa)',                            'motivo_borrado' => false],
            ['motivo_id' => 89,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Pasaporte/Código de pago',                                           'motivo_borrado' => false],
            ['motivo_id' => 90,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Pasaporte/Error de concurrencia',                                    'motivo_borrado' => false],
            ['motivo_id' => 91,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Pérdida o Robo de Cedula',                                           'motivo_borrado' => false],
            ['motivo_id' => 92,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Pérdida o Robo de Pasaporte',                                        'motivo_borrado' => false],
            ['motivo_id' => 93,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Permiso de Viaje NNA',                                               'motivo_borrado' => false],
            ['motivo_id' => 94,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Precios de Pasaporte',                                               'motivo_borrado' => false],
            ['motivo_id' => 95,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Proceso de Cedulación Irregular',                                    'motivo_borrado' => false],
            ['motivo_id' => 96,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Reagendar Cita - Cedulación',                                        'motivo_borrado' => false],
            ['motivo_id' => 97,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Reagendar Cita (Pasaporte)',                                         'motivo_borrado' => false],
            ['motivo_id' => 98,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Reclamo Por Inclusión En Sistema Menor De Edad (Ingreso Opsu)',     'motivo_borrado' => false],
            ['motivo_id' => 99,  'tipo_prop_id' => 4, 'motivo_nombre' => 'Reintegro de Dinero / Pasaporte',                                    'motivo_borrado' => false],
            ['motivo_id' => 100, 'tipo_prop_id' => 4, 'motivo_nombre' => 'Renovación Adulto Mayor',                                            'motivo_borrado' => false],
            ['motivo_id' => 101, 'tipo_prop_id' => 4, 'motivo_nombre' => 'Renovación De Cédula',                                               'motivo_borrado' => false],
            ['motivo_id' => 102, 'tipo_prop_id' => 4, 'motivo_nombre' => 'Renovación de Pasaporte',                                            'motivo_borrado' => false],
            ['motivo_id' => 103, 'tipo_prop_id' => 4, 'motivo_nombre' => 'Requisitos para Emisión de Pasaporte',                               'motivo_borrado' => false],
            ['motivo_id' => 104, 'tipo_prop_id' => 4, 'motivo_nombre' => 'Requisitos Retiro Pasaporte Consular (Familiar Directo)',            'motivo_borrado' => false],
            ['motivo_id' => 105, 'tipo_prop_id' => 4, 'motivo_nombre' => 'Resguardo de pasaporte',                                             'motivo_borrado' => false],
            ['motivo_id' => 106, 'tipo_prop_id' => 4, 'motivo_nombre' => 'Restricción',                                                        'motivo_borrado' => false],
            ['motivo_id' => 107, 'tipo_prop_id' => 4, 'motivo_nombre' => 'Restriccion Militar',                                                'motivo_borrado' => false],
            ['motivo_id' => 108, 'tipo_prop_id' => 4, 'motivo_nombre' => 'Retiro de Cédula',                                                   'motivo_borrado' => false],
            ['motivo_id' => 109, 'tipo_prop_id' => 4, 'motivo_nombre' => 'Retiro de Pasaporte consular',                                       'motivo_borrado' => false],
            ['motivo_id' => 110, 'tipo_prop_id' => 4, 'motivo_nombre' => 'Retiro de Pasaporte por Apoderado',                                  'motivo_borrado' => false],
            ['motivo_id' => 111, 'tipo_prop_id' => 4, 'motivo_nombre' => 'Ruta José Gregorio Hernández',                                       'motivo_borrado' => false],
            ['motivo_id' => 112, 'tipo_prop_id' => 4, 'motivo_nombre' => 'Serial Anulado',                                                     'motivo_borrado' => false],
            ['motivo_id' => 113, 'tipo_prop_id' => 4, 'motivo_nombre' => 'Serial Flotante',                                                    'motivo_borrado' => false],
            ['motivo_id' => 114, 'tipo_prop_id' => 4, 'motivo_nombre' => 'Tramite Abierto (Cédula Impresa)',                                   'motivo_borrado' => false],
            ['motivo_id' => 115, 'tipo_prop_id' => 4, 'motivo_nombre' => 'Trámite Abierto (Cita de Cedulación)',                               'motivo_borrado' => false],
            ['motivo_id' => 116, 'tipo_prop_id' => 4, 'motivo_nombre' => 'Tramite de Pasaporte NNA',                                           'motivo_borrado' => false],
            ['motivo_id' => 117, 'tipo_prop_id' => 4, 'motivo_nombre' => 'Transferencia de Pago entre Usuarios (Pasaporte)',                   'motivo_borrado' => false],
            ['motivo_id' => 118, 'tipo_prop_id' => 4, 'motivo_nombre' => 'Usuario no Recibe Correo (Ingreso Plataforma Saime)',                'motivo_borrado' => false],
            ['motivo_id' => 119, 'tipo_prop_id' => 4, 'motivo_nombre' => 'Usuario no Recibe Token (Correo)',                                   'motivo_borrado' => false],
            ['motivo_id' => 120, 'tipo_prop_id' => 4, 'motivo_nombre' => 'Usurpación De Identidad',                                            'motivo_borrado' => false],
            ['motivo_id' => 121, 'tipo_prop_id' => 4, 'motivo_nombre' => 'Validación de Pago (Cédula Extranjero)',                             'motivo_borrado' => false],
            ['motivo_id' => 122, 'tipo_prop_id' => 4, 'motivo_nombre' => 'Validacion de Pago (pasaporte consular)',                            'motivo_borrado' => false],
            ['motivo_id' => 123, 'tipo_prop_id' => 4, 'motivo_nombre' => 'Validación de Pago (Pasaporte)',                                     'motivo_borrado' => false],
            ['motivo_id' => 124, 'tipo_prop_id' => 4, 'motivo_nombre' => 'Validación de Pago/Certificación de Pasaporte',                      'motivo_borrado' => false],
            ['motivo_id' => 125, 'tipo_prop_id' => 4, 'motivo_nombre' => 'Error de Concurrencia',                                              'motivo_borrado' => false],

            // ============================================================
            // Verificación y Registro (tipo_prop_id = 5) — 18 motivos
            // ============================================================
            ['motivo_id' => 126, 'tipo_prop_id' => 5, 'motivo_nombre' => 'Certificación de Datos',                              'motivo_borrado' => false],
            ['motivo_id' => 127, 'tipo_prop_id' => 5, 'motivo_nombre' => 'Chequeo Dactiloscópico Aprobado',                     'motivo_borrado' => false],
            ['motivo_id' => 128, 'tipo_prop_id' => 5, 'motivo_nombre' => 'Chequeo Dactiloscópico Rechazado',                    'motivo_borrado' => false],
            ['motivo_id' => 129, 'tipo_prop_id' => 5, 'motivo_nombre' => 'Consulta Certificación de Datos',                     'motivo_borrado' => false],
            ['motivo_id' => 130, 'tipo_prop_id' => 5, 'motivo_nombre' => 'Consulta Datos Filiatorios',                          'motivo_borrado' => false],
            ['motivo_id' => 131, 'tipo_prop_id' => 5, 'motivo_nombre' => 'Consulta Datos Filiatorios, Actividad Sospechosa',    'motivo_borrado' => false],
            ['motivo_id' => 132, 'tipo_prop_id' => 5, 'motivo_nombre' => 'Datos Filiatorios (Error en Actualización de Datos)', 'motivo_borrado' => false],
            ['motivo_id' => 133, 'tipo_prop_id' => 5, 'motivo_nombre' => 'Error en Impresión Dactilar',                         'motivo_borrado' => false],
            ['motivo_id' => 134, 'tipo_prop_id' => 5, 'motivo_nombre' => 'Error en Validación de Pago (Datos Filiatorios)',     'motivo_borrado' => false],
            ['motivo_id' => 135, 'tipo_prop_id' => 5, 'motivo_nombre' => 'Fallecimiento Fuera Del País',                        'motivo_borrado' => false],
            ['motivo_id' => 136, 'tipo_prop_id' => 5, 'motivo_nombre' => 'Por Chequeo Dactiloscópico',                          'motivo_borrado' => false],
            ['motivo_id' => 137, 'tipo_prop_id' => 5, 'motivo_nombre' => 'Recaptura de Huellas Visa',                           'motivo_borrado' => false],
            ['motivo_id' => 138, 'tipo_prop_id' => 5, 'motivo_nombre' => 'Reclamo Por Verificación De Datos',                   'motivo_borrado' => false],
            ['motivo_id' => 139, 'tipo_prop_id' => 5, 'motivo_nombre' => 'Reclamo Tramite Datos Filiatorios',                   'motivo_borrado' => false],
            ['motivo_id' => 140, 'tipo_prop_id' => 5, 'motivo_nombre' => 'Reclamo Trámite Datos Filiatorios',                   'motivo_borrado' => false],
            ['motivo_id' => 141, 'tipo_prop_id' => 5, 'motivo_nombre' => 'Tramite Datos Filiatorios (Oficina)',                 'motivo_borrado' => false],
            ['motivo_id' => 142, 'tipo_prop_id' => 5, 'motivo_nombre' => 'Validación de Impresión Dactilar',                    'motivo_borrado' => false],
            ['motivo_id' => 143, 'tipo_prop_id' => 5, 'motivo_nombre' => 'Validación de Pago - Certificación de Datos',         'motivo_borrado' => false],

            // ============================================================
            // Migración (tipo_prop_id = 6) — 16 motivos
            // ============================================================
            ['motivo_id' => 144, 'tipo_prop_id' => 6, 'motivo_nombre' => 'Error Migratorio',                                                    'motivo_borrado' => false],
            ['motivo_id' => 145, 'tipo_prop_id' => 6, 'motivo_nombre' => 'Error Migratorio - Extranjero',                                        'motivo_borrado' => false],
            ['motivo_id' => 146, 'tipo_prop_id' => 6, 'motivo_nombre' => 'Ingreso al País (Pasaporte Vencido)',                                  'motivo_borrado' => false],
            ['motivo_id' => 147, 'tipo_prop_id' => 6, 'motivo_nombre' => 'Ingreso al País de Extranjero (Padres Venezolanos)',                   'motivo_borrado' => false],
            ['motivo_id' => 148, 'tipo_prop_id' => 6, 'motivo_nombre' => 'Ingreso al país de Extranjeros',                                       'motivo_borrado' => false],
            ['motivo_id' => 149, 'tipo_prop_id' => 6, 'motivo_nombre' => 'Ingreso al País Irregular (Doble Nacionalidad)',                       'motivo_borrado' => false],
            ['motivo_id' => 150, 'tipo_prop_id' => 6, 'motivo_nombre' => 'Ingreso al País NNA (Doble Nacionalidad)',                             'motivo_borrado' => false],
            ['motivo_id' => 151, 'tipo_prop_id' => 6, 'motivo_nombre' => 'Ingreso por TSVC',                                                     'motivo_borrado' => false],
            ['motivo_id' => 152, 'tipo_prop_id' => 6, 'motivo_nombre' => 'Movimiento Migratorio',                                                'motivo_borrado' => false],
            ['motivo_id' => 153, 'tipo_prop_id' => 6, 'motivo_nombre' => 'Objeción - Bloqueo Salida del País',                                   'motivo_borrado' => false],
            ['motivo_id' => 154, 'tipo_prop_id' => 6, 'motivo_nombre' => 'Objeción (Bloqueo Salida del País)',                                   'motivo_borrado' => false],
            ['motivo_id' => 155, 'tipo_prop_id' => 6, 'motivo_nombre' => 'Retorno Voluntario',                                                   'motivo_borrado' => false],
            ['motivo_id' => 156, 'tipo_prop_id' => 6, 'motivo_nombre' => 'Salida del Territorio Venezolano - Extranjero Irregular (Condición Especial)', 'motivo_borrado' => false],
            ['motivo_id' => 157, 'tipo_prop_id' => 6, 'motivo_nombre' => 'Salida del Territorio Venezolano NNA (Doble Nacionalidad)',             'motivo_borrado' => false],
            ['motivo_id' => 158, 'tipo_prop_id' => 6, 'motivo_nombre' => 'Salvoconducto',                                                        'motivo_borrado' => false],
            ['motivo_id' => 159, 'tipo_prop_id' => 6, 'motivo_nombre' => 'Sedes Consulares',                                                     'motivo_borrado' => false],

            // ============================================================
            // Regiones (tipo_prop_id = 7) — 22 motivos
            // ============================================================
            ['motivo_id' => 160, 'tipo_prop_id' => 7, 'motivo_nombre' => 'Abuso de Poder',                                                'motivo_borrado' => false],
            ['motivo_id' => 161, 'tipo_prop_id' => 7, 'motivo_nombre' => 'Actividad Sospechosa',                                          'motivo_borrado' => false],
            ['motivo_id' => 162, 'tipo_prop_id' => 7, 'motivo_nombre' => 'Cobro por Trámite Gratuito',                                    'motivo_borrado' => false],
            ['motivo_id' => 163, 'tipo_prop_id' => 7, 'motivo_nombre' => 'Desvío de Llamada al Realizar Preguntas de Seguridad',          'motivo_borrado' => false],
            ['motivo_id' => 164, 'tipo_prop_id' => 7, 'motivo_nombre' => 'Dirección De Oficina',                                          'motivo_borrado' => false],
            ['motivo_id' => 165, 'tipo_prop_id' => 7, 'motivo_nombre' => 'Falta de Respuesta Adecuada',                                   'motivo_borrado' => false],
            ['motivo_id' => 166, 'tipo_prop_id' => 7, 'motivo_nombre' => 'Horario de Oficina',                                            'motivo_borrado' => false],
            ['motivo_id' => 167, 'tipo_prop_id' => 7, 'motivo_nombre' => 'Información Incorrecta, No Brindan Información',                'motivo_borrado' => false],
            ['motivo_id' => 168, 'tipo_prop_id' => 7, 'motivo_nombre' => 'Irregularidad en Horario de Oficina',                           'motivo_borrado' => false],
            ['motivo_id' => 169, 'tipo_prop_id' => 7, 'motivo_nombre' => 'Lenguage Inaproiado/Groserías',                                 'motivo_borrado' => false],
            ['motivo_id' => 170, 'tipo_prop_id' => 7, 'motivo_nombre' => 'Llamada Recibida de Tercero (No se Brinda Información)',        'motivo_borrado' => false],
            ['motivo_id' => 171, 'tipo_prop_id' => 7, 'motivo_nombre' => 'Mal trato',                                                     'motivo_borrado' => false],
            ['motivo_id' => 172, 'tipo_prop_id' => 7, 'motivo_nombre' => 'No Responde Satisfactoriamente Preguntas de Seguridad',         'motivo_borrado' => false],
            ['motivo_id' => 173, 'tipo_prop_id' => 7, 'motivo_nombre' => 'Oficina no Direcciona Caso de Usuario',                         'motivo_borrado' => false],
            ['motivo_id' => 174, 'tipo_prop_id' => 7, 'motivo_nombre' => 'Omisión de Tramite en Oficina',                                  'motivo_borrado' => false],
            ['motivo_id' => 175, 'tipo_prop_id' => 7, 'motivo_nombre' => 'Operatividad de Oficina',                                        'motivo_borrado' => false],
            ['motivo_id' => 176, 'tipo_prop_id' => 7, 'motivo_nombre' => 'Remisión Innecesaria a 0800 SAIME',                              'motivo_borrado' => false],
            ['motivo_id' => 177, 'tipo_prop_id' => 7, 'motivo_nombre' => 'Solicitud de Pago no Autorizado',                                'motivo_borrado' => false],
            ['motivo_id' => 178, 'tipo_prop_id' => 7, 'motivo_nombre' => 'Sugerencias',                                                   'motivo_borrado' => false],
            ['motivo_id' => 179, 'tipo_prop_id' => 7, 'motivo_nombre' => 'Suplantación de Identidad / Familiar Directo',                  'motivo_borrado' => false],
            ['motivo_id' => 180, 'tipo_prop_id' => 7, 'motivo_nombre' => 'Suplantación de Identidad a Ciudadano en el Exterior',          'motivo_borrado' => false],
            ['motivo_id' => 181, 'tipo_prop_id' => 7, 'motivo_nombre' => 'Tiempo Irregular en Entrega de Cédula',                         'motivo_borrado' => false],
        ]);

    }
}

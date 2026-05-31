<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Seeder for table: sgc_parroquias (1135 rows)
 * Generated from existing database data
 */
class ParroquiasSeeder extends Seeder
{
    public function run()
    {
        $this->db->query('TRUNCATE TABLE sgc_parroquias RESTART IDENTITY CASCADE');

        $this->db->table('sgc_parroquias')->insertBatch([
            [
                'parroquiaid' => 1,
                'parroquianom' => 'Altagracia',
                'municipioid' => 1,
            ],
            [
                'parroquiaid' => 2,
                'parroquianom' => 'Candelaria',
                'municipioid' => 1,
            ],
            [
                'parroquiaid' => 3,
                'parroquianom' => 'Catedral',
                'municipioid' => 1,
            ],
            [
                'parroquiaid' => 4,
                'parroquianom' => 'La Pastora',
                'municipioid' => 1,
            ],
            [
                'parroquiaid' => 5,
                'parroquianom' => 'San Agustin',
                'municipioid' => 1,
            ],
            [
                'parroquiaid' => 6,
                'parroquianom' => 'San Jose',
                'municipioid' => 1,
            ],
            [
                'parroquiaid' => 7,
                'parroquianom' => 'San Juan',
                'municipioid' => 1,
            ],
            [
                'parroquiaid' => 8,
                'parroquianom' => 'Santa Rosalia',
                'municipioid' => 1,
            ],
            [
                'parroquiaid' => 9,
                'parroquianom' => 'Santa Teresa',
                'municipioid' => 1,
            ],
            [
                'parroquiaid' => 10,
                'parroquianom' => 'Sucre',
                'municipioid' => 1,
            ],
            [
                'parroquiaid' => 11,
                'parroquianom' => '23 De Enero',
                'municipioid' => 1,
            ],
            [
                'parroquiaid' => 12,
                'parroquianom' => 'Antimano',
                'municipioid' => 1,
            ],
            [
                'parroquiaid' => 13,
                'parroquianom' => 'El Recreo',
                'municipioid' => 1,
            ],
            [
                'parroquiaid' => 14,
                'parroquianom' => 'El Valle',
                'municipioid' => 1,
            ],
            [
                'parroquiaid' => 15,
                'parroquianom' => 'La Vega',
                'municipioid' => 1,
            ],
            [
                'parroquiaid' => 16,
                'parroquianom' => 'Macarao',
                'municipioid' => 1,
            ],
            [
                'parroquiaid' => 17,
                'parroquianom' => 'Caricuao',
                'municipioid' => 1,
            ],
            [
                'parroquiaid' => 18,
                'parroquianom' => 'El Junquito',
                'municipioid' => 1,
            ],
            [
                'parroquiaid' => 19,
                'parroquianom' => 'Coche',
                'municipioid' => 1,
            ],
            [
                'parroquiaid' => 20,
                'parroquianom' => 'San Pedro',
                'municipioid' => 1,
            ],
            [
                'parroquiaid' => 21,
                'parroquianom' => 'San Bernardino',
                'municipioid' => 1,
            ],
            [
                'parroquiaid' => 22,
                'parroquianom' => 'El Paraiso',
                'municipioid' => 1,
            ],
            [
                'parroquiaid' => 23,
                'parroquianom' => 'Anaco',
                'municipioid' => 2,
            ],
            [
                'parroquiaid' => 24,
                'parroquianom' => 'San Joaquin',
                'municipioid' => 2,
            ],
            [
                'parroquiaid' => 25,
                'parroquianom' => 'Cm. Aragua De Barcelona',
                'municipioid' => 3,
            ],
            [
                'parroquiaid' => 26,
                'parroquianom' => 'Cachipo',
                'municipioid' => 3,
            ],
            [
                'parroquiaid' => 27,
                'parroquianom' => 'El Carmen',
                'municipioid' => 4,
            ],
            [
                'parroquiaid' => 28,
                'parroquianom' => 'San Cristobal',
                'municipioid' => 4,
            ],
            [
                'parroquiaid' => 29,
                'parroquianom' => 'Bergantin',
                'municipioid' => 4,
            ],
            [
                'parroquiaid' => 30,
                'parroquianom' => 'Caigua',
                'municipioid' => 4,
            ],
            [
                'parroquiaid' => 31,
                'parroquianom' => 'El Pilar',
                'municipioid' => 4,
            ],
            [
                'parroquiaid' => 32,
                'parroquianom' => 'Naricual',
                'municipioid' => 4,
            ],
            [
                'parroquiaid' => 33,
                'parroquianom' => 'Cm. Clarines',
                'municipioid' => 5,
            ],
            [
                'parroquiaid' => 34,
                'parroquianom' => 'Guanape',
                'municipioid' => 5,
            ],
            [
                'parroquiaid' => 35,
                'parroquianom' => 'Sabana De Uchire',
                'municipioid' => 5,
            ],
            [
                'parroquiaid' => 36,
                'parroquianom' => 'Cm. Onoto',
                'municipioid' => 6,
            ],
            [
                'parroquiaid' => 37,
                'parroquianom' => 'San Pablo',
                'municipioid' => 6,
            ],
            [
                'parroquiaid' => 38,
                'parroquianom' => 'Cm. Cantaura',
                'municipioid' => 7,
            ],
            [
                'parroquiaid' => 39,
                'parroquianom' => 'Libertador',
                'municipioid' => 7,
            ],
            [
                'parroquiaid' => 40,
                'parroquianom' => 'Santa Rosa',
                'municipioid' => 7,
            ],
            [
                'parroquiaid' => 41,
                'parroquianom' => 'Urica',
                'municipioid' => 7,
            ],
            [
                'parroquiaid' => 42,
                'parroquianom' => 'Cm. Soledad',
                'municipioid' => 8,
            ],
            [
                'parroquiaid' => 43,
                'parroquianom' => 'Mamo',
                'municipioid' => 8,
            ],
            [
                'parroquiaid' => 44,
                'parroquianom' => 'Cm. San Mateo',
                'municipioid' => 9,
            ],
            [
                'parroquiaid' => 45,
                'parroquianom' => 'El Carito',
                'municipioid' => 9,
            ],
            [
                'parroquiaid' => 46,
                'parroquianom' => 'Santa Ines',
                'municipioid' => 9,
            ],
            [
                'parroquiaid' => 47,
                'parroquianom' => 'Cm. Pariaguan',
                'municipioid' => 10,
            ],
            [
                'parroquiaid' => 48,
                'parroquianom' => 'Atapirire',
                'municipioid' => 10,
            ],
            [
                'parroquiaid' => 49,
                'parroquianom' => 'Boca Del Pao',
                'municipioid' => 10,
            ],
            [
                'parroquiaid' => 50,
                'parroquianom' => 'El Pao',
                'municipioid' => 10,
            ],
        ]);

        $this->db->table('sgc_parroquias')->insertBatch([
            [
                'parroquiaid' => 51,
                'parroquianom' => 'Cm. Mapire',
                'municipioid' => 11,
            ],
            [
                'parroquiaid' => 52,
                'parroquianom' => 'Piar',
                'municipioid' => 11,
            ],
            [
                'parroquiaid' => 53,
                'parroquianom' => 'Sn Diego De Cabrutica',
                'municipioid' => 11,
            ],
            [
                'parroquiaid' => 54,
                'parroquianom' => 'Santa Clara',
                'municipioid' => 11,
            ],
            [
                'parroquiaid' => 55,
                'parroquianom' => 'Uverito',
                'municipioid' => 11,
            ],
            [
                'parroquiaid' => 56,
                'parroquianom' => 'Zuata',
                'municipioid' => 11,
            ],
            [
                'parroquiaid' => 57,
                'parroquianom' => 'Cm. Puerto Piritu',
                'municipioid' => 12,
            ],
            [
                'parroquiaid' => 58,
                'parroquianom' => 'San Miguel',
                'municipioid' => 12,
            ],
            [
                'parroquiaid' => 59,
                'parroquianom' => 'Sucre',
                'municipioid' => 12,
            ],
            [
                'parroquiaid' => 60,
                'parroquianom' => 'Cm. El Tigre',
                'municipioid' => 13,
            ],
            [
                'parroquiaid' => 61,
                'parroquianom' => 'Pozuelos',
                'municipioid' => 14,
            ],
            [
                'parroquiaid' => 62,
                'parroquianom' => 'Cm Pto. La Cruz',
                'municipioid' => 14,
            ],
            [
                'parroquiaid' => 63,
                'parroquianom' => 'Cm. San Jose De Guanipa',
                'municipioid' => 15,
            ],
            [
                'parroquiaid' => 64,
                'parroquianom' => 'Guanta',
                'municipioid' => 16,
            ],
            [
                'parroquiaid' => 65,
                'parroquianom' => 'Chorreron',
                'municipioid' => 16,
            ],
            [
                'parroquiaid' => 66,
                'parroquianom' => 'Piritu',
                'municipioid' => 17,
            ],
            [
                'parroquiaid' => 67,
                'parroquianom' => 'San Francisco',
                'municipioid' => 17,
            ],
            [
                'parroquiaid' => 68,
                'parroquianom' => 'Lecherias',
                'municipioid' => 18,
            ],
            [
                'parroquiaid' => 69,
                'parroquianom' => 'El Morro',
                'municipioid' => 18,
            ],
            [
                'parroquiaid' => 70,
                'parroquianom' => 'Valle Guanape',
                'municipioid' => 19,
            ],
            [
                'parroquiaid' => 71,
                'parroquianom' => 'Santa Barbara',
                'municipioid' => 19,
            ],
            [
                'parroquiaid' => 72,
                'parroquianom' => 'Santa Ana',
                'municipioid' => 20,
            ],
            [
                'parroquiaid' => 73,
                'parroquianom' => 'Pueblo Nuevo',
                'municipioid' => 20,
            ],
            [
                'parroquiaid' => 74,
                'parroquianom' => 'El Chaparro',
                'municipioid' => 21,
            ],
            [
                'parroquiaid' => 75,
                'parroquianom' => 'Tomas Alfaro Calatrava',
                'municipioid' => 21,
            ],
            [
                'parroquiaid' => 76,
                'parroquianom' => 'Boca Uchire',
                'municipioid' => 22,
            ],
            [
                'parroquiaid' => 77,
                'parroquianom' => 'Boca De Chavez',
                'municipioid' => 22,
            ],
            [
                'parroquiaid' => 78,
                'parroquianom' => 'Achaguas',
                'municipioid' => 23,
            ],
            [
                'parroquiaid' => 79,
                'parroquianom' => 'Apurito',
                'municipioid' => 23,
            ],
            [
                'parroquiaid' => 80,
                'parroquianom' => 'El Yagual',
                'municipioid' => 23,
            ],
            [
                'parroquiaid' => 81,
                'parroquianom' => 'Guachara',
                'municipioid' => 23,
            ],
            [
                'parroquiaid' => 82,
                'parroquianom' => 'Mucuritas',
                'municipioid' => 23,
            ],
            [
                'parroquiaid' => 83,
                'parroquianom' => 'Queseras Del Medio',
                'municipioid' => 23,
            ],
            [
                'parroquiaid' => 84,
                'parroquianom' => 'Bruzual',
                'municipioid' => 24,
            ],
            [
                'parroquiaid' => 85,
                'parroquianom' => 'Mantecal',
                'municipioid' => 24,
            ],
            [
                'parroquiaid' => 86,
                'parroquianom' => 'Quintero',
                'municipioid' => 24,
            ],
            [
                'parroquiaid' => 87,
                'parroquianom' => 'San Vicente',
                'municipioid' => 24,
            ],
            [
                'parroquiaid' => 88,
                'parroquianom' => 'Rincon Hondo',
                'municipioid' => 24,
            ],
            [
                'parroquiaid' => 89,
                'parroquianom' => 'Guasdualito',
                'municipioid' => 25,
            ],
            [
                'parroquiaid' => 90,
                'parroquianom' => 'Aramendi',
                'municipioid' => 25,
            ],
            [
                'parroquiaid' => 91,
                'parroquianom' => 'El Amparo',
                'municipioid' => 25,
            ],
            [
                'parroquiaid' => 92,
                'parroquianom' => 'San Camilo',
                'municipioid' => 25,
            ],
            [
                'parroquiaid' => 93,
                'parroquianom' => 'Urdaneta',
                'municipioid' => 25,
            ],
            [
                'parroquiaid' => 94,
                'parroquianom' => 'San Juan De Payara',
                'municipioid' => 26,
            ],
            [
                'parroquiaid' => 95,
                'parroquianom' => 'Codazzi',
                'municipioid' => 26,
            ],
            [
                'parroquiaid' => 96,
                'parroquianom' => 'Cunaviche',
                'municipioid' => 26,
            ],
            [
                'parroquiaid' => 97,
                'parroquianom' => 'Elorza',
                'municipioid' => 27,
            ],
            [
                'parroquiaid' => 98,
                'parroquianom' => 'La Trinidad',
                'municipioid' => 27,
            ],
            [
                'parroquiaid' => 99,
                'parroquianom' => 'San Fernando',
                'municipioid' => 28,
            ],
            [
                'parroquiaid' => 100,
                'parroquianom' => 'Peñalver',
                'municipioid' => 28,
            ],
        ]);

        $this->db->table('sgc_parroquias')->insertBatch([
            [
                'parroquiaid' => 101,
                'parroquianom' => 'El Recreo',
                'municipioid' => 28,
            ],
            [
                'parroquiaid' => 102,
                'parroquianom' => 'Sn Rafael De Atamaica',
                'municipioid' => 28,
            ],
            [
                'parroquiaid' => 103,
                'parroquianom' => 'Biruaca',
                'municipioid' => 29,
            ],
            [
                'parroquiaid' => 104,
                'parroquianom' => 'Cm. Las Delicias',
                'municipioid' => 30,
            ],
            [
                'parroquiaid' => 105,
                'parroquianom' => 'Choroni',
                'municipioid' => 30,
            ],
            [
                'parroquiaid' => 106,
                'parroquianom' => 'Madre Ma De San Jose',
                'municipioid' => 30,
            ],
            [
                'parroquiaid' => 107,
                'parroquianom' => 'Joaquin Crespo',
                'municipioid' => 30,
            ],
            [
                'parroquiaid' => 108,
                'parroquianom' => 'Pedro Jose Ovalles',
                'municipioid' => 30,
            ],
            [
                'parroquiaid' => 109,
                'parroquianom' => 'Jose Casanova Godoy',
                'municipioid' => 30,
            ],
            [
                'parroquiaid' => 110,
                'parroquianom' => 'Andres Eloy Blanco',
                'municipioid' => 30,
            ],
            [
                'parroquiaid' => 111,
                'parroquianom' => 'Los Tacariguas',
                'municipioid' => 30,
            ],
            [
                'parroquiaid' => 112,
                'parroquianom' => 'Cm. Turmero',
                'municipioid' => 31,
            ],
            [
                'parroquiaid' => 113,
                'parroquianom' => 'Saman De Guere',
                'municipioid' => 31,
            ],
            [
                'parroquiaid' => 114,
                'parroquianom' => 'Alfredo Pacheco M',
                'municipioid' => 31,
            ],
            [
                'parroquiaid' => 115,
                'parroquianom' => 'Chuao',
                'municipioid' => 31,
            ],
            [
                'parroquiaid' => 116,
                'parroquianom' => 'Arevalo Aponte',
                'municipioid' => 31,
            ],
            [
                'parroquiaid' => 117,
                'parroquianom' => 'Cm. La Victoria',
                'municipioid' => 32,
            ],
            [
                'parroquiaid' => 118,
                'parroquianom' => 'Zuata',
                'municipioid' => 32,
            ],
            [
                'parroquiaid' => 119,
                'parroquianom' => 'Pao De Zarate',
                'municipioid' => 32,
            ],
            [
                'parroquiaid' => 120,
                'parroquianom' => 'Castor Nieves Rios',
                'municipioid' => 32,
            ],
            [
                'parroquiaid' => 121,
                'parroquianom' => 'Las Guacamayas',
                'municipioid' => 32,
            ],
            [
                'parroquiaid' => 122,
                'parroquianom' => 'Cm. San Casimiro',
                'municipioid' => 33,
            ],
            [
                'parroquiaid' => 123,
                'parroquianom' => 'Valle Morin',
                'municipioid' => 33,
            ],
            [
                'parroquiaid' => 124,
                'parroquianom' => 'Guiripa',
                'municipioid' => 33,
            ],
            [
                'parroquiaid' => 125,
                'parroquianom' => 'Ollas De Caramacate',
                'municipioid' => 33,
            ],
            [
                'parroquiaid' => 126,
                'parroquianom' => 'Cm. San Sebastian',
                'municipioid' => 34,
            ],
            [
                'parroquiaid' => 127,
                'parroquianom' => 'Cm. Cagua',
                'municipioid' => 35,
            ],
            [
                'parroquiaid' => 128,
                'parroquianom' => 'Bella Vista',
                'municipioid' => 35,
            ],
            [
                'parroquiaid' => 129,
                'parroquianom' => 'Cm. Barbacoas',
                'municipioid' => 36,
            ],
            [
                'parroquiaid' => 130,
                'parroquianom' => 'San Francisco De Cara',
                'municipioid' => 36,
            ],
            [
                'parroquiaid' => 131,
                'parroquianom' => 'Taguay',
                'municipioid' => 36,
            ],
            [
                'parroquiaid' => 132,
                'parroquianom' => 'Las Peñitas',
                'municipioid' => 36,
            ],
            [
                'parroquiaid' => 133,
                'parroquianom' => 'Cm. Villa De Cura',
                'municipioid' => 37,
            ],
            [
                'parroquiaid' => 134,
                'parroquianom' => 'Magdaleno',
                'municipioid' => 37,
            ],
            [
                'parroquiaid' => 135,
                'parroquianom' => 'San Francisco De Asis',
                'municipioid' => 37,
            ],
            [
                'parroquiaid' => 136,
                'parroquianom' => 'Valles De Tucutunemo',
                'municipioid' => 37,
            ],
            [
                'parroquiaid' => 137,
                'parroquianom' => 'Pq Augusto Mijares',
                'municipioid' => 37,
            ],
            [
                'parroquiaid' => 138,
                'parroquianom' => 'Cm. Palo Negro',
                'municipioid' => 38,
            ],
            [
                'parroquiaid' => 139,
                'parroquianom' => 'San Martin De Porres',
                'municipioid' => 38,
            ],
            [
                'parroquiaid' => 140,
                'parroquianom' => 'Cm. Santa Cruz',
                'municipioid' => 39,
            ],
            [
                'parroquiaid' => 141,
                'parroquianom' => 'Cm. San Mateo',
                'municipioid' => 40,
            ],
            [
                'parroquiaid' => 142,
                'parroquianom' => 'Cm. Las Tejerias',
                'municipioid' => 41,
            ],
            [
                'parroquiaid' => 143,
                'parroquianom' => 'Tiara',
                'municipioid' => 41,
            ],
            [
                'parroquiaid' => 144,
                'parroquianom' => 'Cm. El Limon',
                'municipioid' => 42,
            ],
            [
                'parroquiaid' => 145,
                'parroquianom' => 'Ca A De Azucar',
                'municipioid' => 42,
            ],
            [
                'parroquiaid' => 146,
                'parroquianom' => 'Cm. Colonia Tovar',
                'municipioid' => 43,
            ],
            [
                'parroquiaid' => 147,
                'parroquianom' => 'Cm. Camatagua',
                'municipioid' => 44,
            ],
            [
                'parroquiaid' => 148,
                'parroquianom' => 'Carmen De Cura',
                'municipioid' => 44,
            ],
            [
                'parroquiaid' => 149,
                'parroquianom' => 'Cm. El Consejo',
                'municipioid' => 45,
            ],
            [
                'parroquiaid' => 150,
                'parroquianom' => 'Cm. Santa Rita',
                'municipioid' => 46,
            ],
        ]);

        $this->db->table('sgc_parroquias')->insertBatch([
            [
                'parroquiaid' => 151,
                'parroquianom' => 'Francisco De Miranda',
                'municipioid' => 46,
            ],
            [
                'parroquiaid' => 152,
                'parroquianom' => 'Mons Feliciano G',
                'municipioid' => 46,
            ],
            [
                'parroquiaid' => 153,
                'parroquianom' => 'Ocumare De La Costa',
                'municipioid' => 47,
            ],
            [
                'parroquiaid' => 154,
                'parroquianom' => 'Arismendi',
                'municipioid' => 48,
            ],
            [
                'parroquiaid' => 155,
                'parroquianom' => 'Guadarrama',
                'municipioid' => 48,
            ],
            [
                'parroquiaid' => 156,
                'parroquianom' => 'La Union',
                'municipioid' => 48,
            ],
            [
                'parroquiaid' => 157,
                'parroquianom' => 'San Antonio',
                'municipioid' => 48,
            ],
            [
                'parroquiaid' => 158,
                'parroquianom' => 'Alfredo A Larriva',
                'municipioid' => 49,
            ],
            [
                'parroquiaid' => 159,
                'parroquianom' => 'Barinas',
                'municipioid' => 49,
            ],
            [
                'parroquiaid' => 160,
                'parroquianom' => 'San Silvestre',
                'municipioid' => 49,
            ],
            [
                'parroquiaid' => 161,
                'parroquianom' => 'Santa Ines',
                'municipioid' => 49,
            ],
            [
                'parroquiaid' => 162,
                'parroquianom' => 'Santa Lucia',
                'municipioid' => 49,
            ],
            [
                'parroquiaid' => 163,
                'parroquianom' => 'Torunos',
                'municipioid' => 49,
            ],
            [
                'parroquiaid' => 164,
                'parroquianom' => 'El Carmen',
                'municipioid' => 49,
            ],
            [
                'parroquiaid' => 165,
                'parroquianom' => 'Romulo Betancourt',
                'municipioid' => 49,
            ],
            [
                'parroquiaid' => 166,
                'parroquianom' => 'Corazon De Jesus',
                'municipioid' => 49,
            ],
            [
                'parroquiaid' => 167,
                'parroquianom' => 'Ramon I Mendez',
                'municipioid' => 49,
            ],
            [
                'parroquiaid' => 168,
                'parroquianom' => 'Alto Barinas',
                'municipioid' => 49,
            ],
            [
                'parroquiaid' => 169,
                'parroquianom' => 'Manuel P Fajardo',
                'municipioid' => 49,
            ],
            [
                'parroquiaid' => 170,
                'parroquianom' => 'Juan A Rodriguez D',
                'municipioid' => 49,
            ],
            [
                'parroquiaid' => 171,
                'parroquianom' => 'Dominga Ortiz P',
                'municipioid' => 49,
            ],
            [
                'parroquiaid' => 172,
                'parroquianom' => 'Altamira',
                'municipioid' => 50,
            ],
            [
                'parroquiaid' => 173,
                'parroquianom' => 'Barinitas',
                'municipioid' => 50,
            ],
            [
                'parroquiaid' => 174,
                'parroquianom' => 'Calderas',
                'municipioid' => 50,
            ],
            [
                'parroquiaid' => 175,
                'parroquianom' => 'Santa Barbara',
                'municipioid' => 51,
            ],
            [
                'parroquiaid' => 176,
                'parroquianom' => 'Jose Ignacio Del Pumar',
                'municipioid' => 51,
            ],
            [
                'parroquiaid' => 177,
                'parroquianom' => 'Ramon Ignacio Mendez',
                'municipioid' => 51,
            ],
            [
                'parroquiaid' => 178,
                'parroquianom' => 'Pedro Briceño Mendez',
                'municipioid' => 51,
            ],
            [
                'parroquiaid' => 179,
                'parroquianom' => 'El Real',
                'municipioid' => 52,
            ],
            [
                'parroquiaid' => 180,
                'parroquianom' => 'La Luz',
                'municipioid' => 52,
            ],
            [
                'parroquiaid' => 181,
                'parroquianom' => 'Obispos',
                'municipioid' => 52,
            ],
            [
                'parroquiaid' => 182,
                'parroquianom' => 'Los Guasimitos',
                'municipioid' => 52,
            ],
            [
                'parroquiaid' => 183,
                'parroquianom' => 'Ciudad Bolivia',
                'municipioid' => 53,
            ],
            [
                'parroquiaid' => 184,
                'parroquianom' => 'Ignacio Briceño',
                'municipioid' => 53,
            ],
            [
                'parroquiaid' => 185,
                'parroquianom' => 'Paez',
                'municipioid' => 53,
            ],
            [
                'parroquiaid' => 186,
                'parroquianom' => 'Jose Felix Ribas',
                'municipioid' => 53,
            ],
            [
                'parroquiaid' => 187,
                'parroquianom' => 'Dolores',
                'municipioid' => 54,
            ],
            [
                'parroquiaid' => 188,
                'parroquianom' => 'Libertad',
                'municipioid' => 54,
            ],
            [
                'parroquiaid' => 189,
                'parroquianom' => 'Palacio Fajardo',
                'municipioid' => 54,
            ],
            [
                'parroquiaid' => 190,
                'parroquianom' => 'Santa Rosa',
                'municipioid' => 54,
            ],
            [
                'parroquiaid' => 191,
                'parroquianom' => 'Ciudad De Nutrias',
                'municipioid' => 55,
            ],
            [
                'parroquiaid' => 192,
                'parroquianom' => 'El Regalo',
                'municipioid' => 55,
            ],
            [
                'parroquiaid' => 193,
                'parroquianom' => 'Puerto De Nutrias',
                'municipioid' => 55,
            ],
            [
                'parroquiaid' => 194,
                'parroquianom' => 'Santa Catalina',
                'municipioid' => 55,
            ],
            [
                'parroquiaid' => 195,
                'parroquianom' => 'Rodriguez Dominguez',
                'municipioid' => 56,
            ],
            [
                'parroquiaid' => 196,
                'parroquianom' => 'Sabaneta',
                'municipioid' => 56,
            ],
            [
                'parroquiaid' => 197,
                'parroquianom' => 'Ticoporo',
                'municipioid' => 57,
            ],
            [
                'parroquiaid' => 198,
                'parroquianom' => 'Nicolas Pulido',
                'municipioid' => 57,
            ],
            [
                'parroquiaid' => 199,
                'parroquianom' => 'Andres Bello',
                'municipioid' => 57,
            ],
            [
                'parroquiaid' => 200,
                'parroquianom' => 'Barrancas',
                'municipioid' => 58,
            ],
        ]);

        $this->db->table('sgc_parroquias')->insertBatch([
            [
                'parroquiaid' => 201,
                'parroquianom' => 'El Socorro',
                'municipioid' => 58,
            ],
            [
                'parroquiaid' => 202,
                'parroquianom' => 'Masparrito',
                'municipioid' => 58,
            ],
            [
                'parroquiaid' => 203,
                'parroquianom' => 'El Canton',
                'municipioid' => 59,
            ],
            [
                'parroquiaid' => 204,
                'parroquianom' => 'Santa Cruz De Guacas',
                'municipioid' => 59,
            ],
            [
                'parroquiaid' => 205,
                'parroquianom' => 'Puerto Vivas',
                'municipioid' => 59,
            ],
            [
                'parroquiaid' => 206,
                'parroquianom' => 'Simon Bolivar',
                'municipioid' => 60,
            ],
            [
                'parroquiaid' => 207,
                'parroquianom' => 'Once De Abril',
                'municipioid' => 60,
            ],
            [
                'parroquiaid' => 208,
                'parroquianom' => 'Vista Al Sol',
                'municipioid' => 60,
            ],
            [
                'parroquiaid' => 209,
                'parroquianom' => 'Chirica',
                'municipioid' => 60,
            ],
            [
                'parroquiaid' => 210,
                'parroquianom' => 'Dalla Costa',
                'municipioid' => 60,
            ],
            [
                'parroquiaid' => 211,
                'parroquianom' => 'Cachamay',
                'municipioid' => 60,
            ],
            [
                'parroquiaid' => 212,
                'parroquianom' => 'Universidad',
                'municipioid' => 60,
            ],
            [
                'parroquiaid' => 213,
                'parroquianom' => 'Unare',
                'municipioid' => 60,
            ],
            [
                'parroquiaid' => 214,
                'parroquianom' => 'Yocoima',
                'municipioid' => 60,
            ],
            [
                'parroquiaid' => 215,
                'parroquianom' => 'Pozo Verde',
                'municipioid' => 60,
            ],
            [
                'parroquiaid' => 216,
                'parroquianom' => 'Cm. Caicara Del Orinoco',
                'municipioid' => 61,
            ],
            [
                'parroquiaid' => 217,
                'parroquianom' => 'Ascension Farreras',
                'municipioid' => 61,
            ],
            [
                'parroquiaid' => 218,
                'parroquianom' => 'Altagracia',
                'municipioid' => 61,
            ],
            [
                'parroquiaid' => 219,
                'parroquianom' => 'La Urbana',
                'municipioid' => 61,
            ],
            [
                'parroquiaid' => 220,
                'parroquianom' => 'Guaniamo',
                'municipioid' => 61,
            ],
            [
                'parroquiaid' => 221,
                'parroquianom' => 'Pijiguaos',
                'municipioid' => 61,
            ],
            [
                'parroquiaid' => 222,
                'parroquianom' => 'Catedral',
                'municipioid' => 62,
            ],
            [
                'parroquiaid' => 223,
                'parroquianom' => 'Agua Salada',
                'municipioid' => 62,
            ],
            [
                'parroquiaid' => 224,
                'parroquianom' => 'La Sabanita',
                'municipioid' => 62,
            ],
            [
                'parroquiaid' => 225,
                'parroquianom' => 'Vista Hermosa',
                'municipioid' => 62,
            ],
            [
                'parroquiaid' => 226,
                'parroquianom' => 'Marhuanta',
                'municipioid' => 62,
            ],
            [
                'parroquiaid' => 227,
                'parroquianom' => 'Jose Antonio Paez',
                'municipioid' => 62,
            ],
            [
                'parroquiaid' => 228,
                'parroquianom' => 'Orinoco',
                'municipioid' => 62,
            ],
            [
                'parroquiaid' => 229,
                'parroquianom' => 'Panapana',
                'municipioid' => 62,
            ],
            [
                'parroquiaid' => 230,
                'parroquianom' => 'Zea',
                'municipioid' => 62,
            ],
            [
                'parroquiaid' => 231,
                'parroquianom' => 'Cm. Upata',
                'municipioid' => 63,
            ],
            [
                'parroquiaid' => 232,
                'parroquianom' => 'Andres Eloy Blanco',
                'municipioid' => 63,
            ],
            [
                'parroquiaid' => 233,
                'parroquianom' => 'Pedro Cova',
                'municipioid' => 63,
            ],
            [
                'parroquiaid' => 234,
                'parroquianom' => 'Cm. Guasipati',
                'municipioid' => 64,
            ],
            [
                'parroquiaid' => 235,
                'parroquianom' => 'Salom',
                'municipioid' => 64,
            ],
            [
                'parroquiaid' => 236,
                'parroquianom' => 'Cm. Maripa',
                'municipioid' => 65,
            ],
            [
                'parroquiaid' => 237,
                'parroquianom' => 'Aripao',
                'municipioid' => 65,
            ],
            [
                'parroquiaid' => 238,
                'parroquianom' => 'Las Majadas',
                'municipioid' => 65,
            ],
            [
                'parroquiaid' => 239,
                'parroquianom' => 'Moitaco',
                'municipioid' => 65,
            ],
            [
                'parroquiaid' => 240,
                'parroquianom' => 'Guarataro',
                'municipioid' => 65,
            ],
            [
                'parroquiaid' => 241,
                'parroquianom' => 'Cm. Tumeremo',
                'municipioid' => 66,
            ],
            [
                'parroquiaid' => 242,
                'parroquianom' => 'Dalla Costa',
                'municipioid' => 66,
            ],
            [
                'parroquiaid' => 243,
                'parroquianom' => 'San Isidro',
                'municipioid' => 66,
            ],
            [
                'parroquiaid' => 244,
                'parroquianom' => 'Cm. Ciudad Piar',
                'municipioid' => 67,
            ],
            [
                'parroquiaid' => 245,
                'parroquianom' => 'San Francisco',
                'municipioid' => 67,
            ],
            [
                'parroquiaid' => 246,
                'parroquianom' => 'Barceloneta',
                'municipioid' => 67,
            ],
            [
                'parroquiaid' => 247,
                'parroquianom' => 'Santa Barbara',
                'municipioid' => 67,
            ],
            [
                'parroquiaid' => 248,
                'parroquianom' => 'Cm. Santa Elena De Uairen',
                'municipioid' => 68,
            ],
            [
                'parroquiaid' => 249,
                'parroquianom' => 'Ikabaru',
                'municipioid' => 68,
            ],
            [
                'parroquiaid' => 250,
                'parroquianom' => 'Cm. El Callao',
                'municipioid' => 69,
            ],
        ]);

        $this->db->table('sgc_parroquias')->insertBatch([
            [
                'parroquiaid' => 251,
                'parroquianom' => 'Cm. El Palmar',
                'municipioid' => 70,
            ],
            [
                'parroquiaid' => 252,
                'parroquianom' => 'Bejuma',
                'municipioid' => 71,
            ],
            [
                'parroquiaid' => 253,
                'parroquianom' => 'Canoabo',
                'municipioid' => 71,
            ],
            [
                'parroquiaid' => 254,
                'parroquianom' => 'Simon Bolivar',
                'municipioid' => 71,
            ],
            [
                'parroquiaid' => 255,
                'parroquianom' => 'Guigue',
                'municipioid' => 72,
            ],
            [
                'parroquiaid' => 256,
                'parroquianom' => 'Belen',
                'municipioid' => 72,
            ],
            [
                'parroquiaid' => 257,
                'parroquianom' => 'Tacarigua',
                'municipioid' => 72,
            ],
            [
                'parroquiaid' => 258,
                'parroquianom' => 'Mariara',
                'municipioid' => 73,
            ],
            [
                'parroquiaid' => 259,
                'parroquianom' => 'Aguas Calientes',
                'municipioid' => 73,
            ],
            [
                'parroquiaid' => 260,
                'parroquianom' => 'Guacara',
                'municipioid' => 74,
            ],
            [
                'parroquiaid' => 261,
                'parroquianom' => 'Ciudad Alianza',
                'municipioid' => 74,
            ],
            [
                'parroquiaid' => 262,
                'parroquianom' => 'Yagua',
                'municipioid' => 74,
            ],
            [
                'parroquiaid' => 263,
                'parroquianom' => 'Montalban',
                'municipioid' => 75,
            ],
            [
                'parroquiaid' => 264,
                'parroquianom' => 'Moron',
                'municipioid' => 76,
            ],
            [
                'parroquiaid' => 265,
                'parroquianom' => 'Urama',
                'municipioid' => 76,
            ],
            [
                'parroquiaid' => 266,
                'parroquianom' => 'Democracia',
                'municipioid' => 77,
            ],
            [
                'parroquiaid' => 267,
                'parroquianom' => 'Fraternidad',
                'municipioid' => 77,
            ],
            [
                'parroquiaid' => 268,
                'parroquianom' => 'Goaigoaza',
                'municipioid' => 77,
            ],
            [
                'parroquiaid' => 269,
                'parroquianom' => 'Juan Jose Flores',
                'municipioid' => 77,
            ],
            [
                'parroquiaid' => 270,
                'parroquianom' => 'Bartolome Salom',
                'municipioid' => 77,
            ],
            [
                'parroquiaid' => 271,
                'parroquianom' => 'Union',
                'municipioid' => 77,
            ],
            [
                'parroquiaid' => 272,
                'parroquianom' => 'Borburata',
                'municipioid' => 77,
            ],
            [
                'parroquiaid' => 273,
                'parroquianom' => 'Patanemo',
                'municipioid' => 77,
            ],
            [
                'parroquiaid' => 274,
                'parroquianom' => 'San Joaquin',
                'municipioid' => 78,
            ],
            [
                'parroquiaid' => 275,
                'parroquianom' => 'Candelaria',
                'municipioid' => 79,
            ],
            [
                'parroquiaid' => 276,
                'parroquianom' => 'Catedral',
                'municipioid' => 79,
            ],
            [
                'parroquiaid' => 277,
                'parroquianom' => 'El Socorro',
                'municipioid' => 79,
            ],
            [
                'parroquiaid' => 278,
                'parroquianom' => 'Miguel Peña',
                'municipioid' => 79,
            ],
            [
                'parroquiaid' => 279,
                'parroquianom' => 'San Blas',
                'municipioid' => 79,
            ],
            [
                'parroquiaid' => 280,
                'parroquianom' => 'San Jose',
                'municipioid' => 79,
            ],
            [
                'parroquiaid' => 281,
                'parroquianom' => 'Santa Rosa',
                'municipioid' => 79,
            ],
            [
                'parroquiaid' => 282,
                'parroquianom' => 'Rafael Urdaneta',
                'municipioid' => 79,
            ],
            [
                'parroquiaid' => 283,
                'parroquianom' => 'Negro Primero',
                'municipioid' => 79,
            ],
            [
                'parroquiaid' => 284,
                'parroquianom' => 'Miranda',
                'municipioid' => 80,
            ],
            [
                'parroquiaid' => 285,
                'parroquianom' => 'U Los Guayos',
                'municipioid' => 81,
            ],
            [
                'parroquiaid' => 286,
                'parroquianom' => 'Naguanagua',
                'municipioid' => 82,
            ],
            [
                'parroquiaid' => 287,
                'parroquianom' => 'Urb San Diego',
                'municipioid' => 83,
            ],
            [
                'parroquiaid' => 288,
                'parroquianom' => 'U Tocuyito',
                'municipioid' => 84,
            ],
            [
                'parroquiaid' => 289,
                'parroquianom' => 'U Independencia',
                'municipioid' => 84,
            ],
            [
                'parroquiaid' => 290,
                'parroquianom' => 'Cojedes',
                'municipioid' => 85,
            ],
            [
                'parroquiaid' => 291,
                'parroquianom' => 'Juan De Mata Suarez',
                'municipioid' => 85,
            ],
            [
                'parroquiaid' => 292,
                'parroquianom' => 'Tinaquillo',
                'municipioid' => 86,
            ],
            [
                'parroquiaid' => 293,
                'parroquianom' => 'El Baul',
                'municipioid' => 87,
            ],
            [
                'parroquiaid' => 294,
                'parroquianom' => 'Sucre',
                'municipioid' => 87,
            ],
            [
                'parroquiaid' => 295,
                'parroquianom' => 'El Pao',
                'municipioid' => 88,
            ],
            [
                'parroquiaid' => 296,
                'parroquianom' => 'Libertad De Cojedes',
                'municipioid' => 89,
            ],
            [
                'parroquiaid' => 297,
                'parroquianom' => 'El Amparo',
                'municipioid' => 89,
            ],
            [
                'parroquiaid' => 298,
                'parroquianom' => 'San Carlos De Austria',
                'municipioid' => 90,
            ],
            [
                'parroquiaid' => 299,
                'parroquianom' => 'Juan Angel Bravo',
                'municipioid' => 90,
            ],
            [
                'parroquiaid' => 300,
                'parroquianom' => 'Manuel Manrique',
                'municipioid' => 90,
            ],
        ]);

        $this->db->table('sgc_parroquias')->insertBatch([
            [
                'parroquiaid' => 301,
                'parroquianom' => 'Grl/Jefe Jose L Silva',
                'municipioid' => 91,
            ],
            [
                'parroquiaid' => 302,
                'parroquianom' => 'Macapo',
                'municipioid' => 92,
            ],
            [
                'parroquiaid' => 303,
                'parroquianom' => 'La Aguadita',
                'municipioid' => 92,
            ],
            [
                'parroquiaid' => 304,
                'parroquianom' => 'Romulo Gallegos',
                'municipioid' => 93,
            ],
            [
                'parroquiaid' => 305,
                'parroquianom' => 'San Juan De Los Cayos',
                'municipioid' => 94,
            ],
            [
                'parroquiaid' => 306,
                'parroquianom' => 'Capadare',
                'municipioid' => 94,
            ],
            [
                'parroquiaid' => 307,
                'parroquianom' => 'La Pastora',
                'municipioid' => 94,
            ],
            [
                'parroquiaid' => 308,
                'parroquianom' => 'Libertador',
                'municipioid' => 94,
            ],
            [
                'parroquiaid' => 309,
                'parroquianom' => 'San Luis',
                'municipioid' => 95,
            ],
            [
                'parroquiaid' => 310,
                'parroquianom' => 'Aracua',
                'municipioid' => 95,
            ],
            [
                'parroquiaid' => 311,
                'parroquianom' => 'La Peña',
                'municipioid' => 95,
            ],
            [
                'parroquiaid' => 312,
                'parroquianom' => 'Capatarida',
                'municipioid' => 96,
            ],
            [
                'parroquiaid' => 313,
                'parroquianom' => 'Borojo',
                'municipioid' => 96,
            ],
            [
                'parroquiaid' => 314,
                'parroquianom' => 'Seque',
                'municipioid' => 96,
            ],
            [
                'parroquiaid' => 315,
                'parroquianom' => 'Zazarida',
                'municipioid' => 96,
            ],
            [
                'parroquiaid' => 316,
                'parroquianom' => 'Bariro',
                'municipioid' => 96,
            ],
            [
                'parroquiaid' => 317,
                'parroquianom' => 'Guajiro',
                'municipioid' => 96,
            ],
            [
                'parroquiaid' => 318,
                'parroquianom' => 'Norte',
                'municipioid' => 97,
            ],
            [
                'parroquiaid' => 319,
                'parroquianom' => 'Carirubana',
                'municipioid' => 97,
            ],
            [
                'parroquiaid' => 320,
                'parroquianom' => 'Punta Cardon',
                'municipioid' => 97,
            ],
            [
                'parroquiaid' => 321,
                'parroquianom' => 'Santa Ana',
                'municipioid' => 97,
            ],
            [
                'parroquiaid' => 322,
                'parroquianom' => 'La Vela De Coro',
                'municipioid' => 98,
            ],
            [
                'parroquiaid' => 323,
                'parroquianom' => 'Acurigua',
                'municipioid' => 98,
            ],
            [
                'parroquiaid' => 324,
                'parroquianom' => 'Guaibacoa',
                'municipioid' => 98,
            ],
            [
                'parroquiaid' => 325,
                'parroquianom' => 'Macoruca',
                'municipioid' => 98,
            ],
            [
                'parroquiaid' => 326,
                'parroquianom' => 'Las Calderas',
                'municipioid' => 98,
            ],
            [
                'parroquiaid' => 327,
                'parroquianom' => 'Pedregal',
                'municipioid' => 99,
            ],
            [
                'parroquiaid' => 328,
                'parroquianom' => 'Agua Clara',
                'municipioid' => 99,
            ],
            [
                'parroquiaid' => 329,
                'parroquianom' => 'Avaria',
                'municipioid' => 99,
            ],
            [
                'parroquiaid' => 330,
                'parroquianom' => 'Piedra Grande',
                'municipioid' => 99,
            ],
            [
                'parroquiaid' => 331,
                'parroquianom' => 'Purureche',
                'municipioid' => 99,
            ],
            [
                'parroquiaid' => 332,
                'parroquianom' => 'Pueblo Nuevo',
                'municipioid' => 100,
            ],
            [
                'parroquiaid' => 333,
                'parroquianom' => 'Adicora',
                'municipioid' => 100,
            ],
            [
                'parroquiaid' => 334,
                'parroquianom' => 'Baraived',
                'municipioid' => 100,
            ],
            [
                'parroquiaid' => 335,
                'parroquianom' => 'Buena Vista',
                'municipioid' => 100,
            ],
            [
                'parroquiaid' => 336,
                'parroquianom' => 'Jadacaquiva',
                'municipioid' => 100,
            ],
            [
                'parroquiaid' => 337,
                'parroquianom' => 'Moruy',
                'municipioid' => 100,
            ],
            [
                'parroquiaid' => 338,
                'parroquianom' => 'El Vinculo',
                'municipioid' => 100,
            ],
            [
                'parroquiaid' => 339,
                'parroquianom' => 'El Hato',
                'municipioid' => 100,
            ],
            [
                'parroquiaid' => 340,
                'parroquianom' => 'Adaure',
                'municipioid' => 100,
            ],
            [
                'parroquiaid' => 341,
                'parroquianom' => 'Churuguara',
                'municipioid' => 101,
            ],
            [
                'parroquiaid' => 342,
                'parroquianom' => 'Agua Larga',
                'municipioid' => 101,
            ],
            [
                'parroquiaid' => 343,
                'parroquianom' => 'Independencia',
                'municipioid' => 101,
            ],
            [
                'parroquiaid' => 344,
                'parroquianom' => 'Maparari',
                'municipioid' => 101,
            ],
            [
                'parroquiaid' => 345,
                'parroquianom' => 'El Pauji',
                'municipioid' => 101,
            ],
            [
                'parroquiaid' => 346,
                'parroquianom' => 'Mene De Mauroa',
                'municipioid' => 102,
            ],
            [
                'parroquiaid' => 347,
                'parroquianom' => 'Casigua',
                'municipioid' => 102,
            ],
            [
                'parroquiaid' => 348,
                'parroquianom' => 'San Felix',
                'municipioid' => 102,
            ],
            [
                'parroquiaid' => 349,
                'parroquianom' => 'San Antonio',
                'municipioid' => 103,
            ],
            [
                'parroquiaid' => 350,
                'parroquianom' => 'San Gabriel',
                'municipioid' => 103,
            ],
        ]);

        $this->db->table('sgc_parroquias')->insertBatch([
            [
                'parroquiaid' => 351,
                'parroquianom' => 'Santa Ana',
                'municipioid' => 103,
            ],
            [
                'parroquiaid' => 352,
                'parroquianom' => 'Guzman Guillermo',
                'municipioid' => 103,
            ],
            [
                'parroquiaid' => 353,
                'parroquianom' => 'Mitare',
                'municipioid' => 103,
            ],
            [
                'parroquiaid' => 354,
                'parroquianom' => 'Sabaneta',
                'municipioid' => 103,
            ],
            [
                'parroquiaid' => 355,
                'parroquianom' => 'Rio Seco',
                'municipioid' => 103,
            ],
            [
                'parroquiaid' => 356,
                'parroquianom' => 'Cabure',
                'municipioid' => 104,
            ],
            [
                'parroquiaid' => 357,
                'parroquianom' => 'Curimagua',
                'municipioid' => 104,
            ],
            [
                'parroquiaid' => 358,
                'parroquianom' => 'Colina',
                'municipioid' => 104,
            ],
            [
                'parroquiaid' => 359,
                'parroquianom' => 'Tucacas',
                'municipioid' => 105,
            ],
            [
                'parroquiaid' => 360,
                'parroquianom' => 'Boca De Aroa',
                'municipioid' => 105,
            ],
            [
                'parroquiaid' => 361,
                'parroquianom' => 'Puerto Cumarebo',
                'municipioid' => 106,
            ],
            [
                'parroquiaid' => 362,
                'parroquianom' => 'La Cienaga',
                'municipioid' => 106,
            ],
            [
                'parroquiaid' => 363,
                'parroquianom' => 'La Soledad',
                'municipioid' => 106,
            ],
            [
                'parroquiaid' => 364,
                'parroquianom' => 'Pueblo Cumarebo',
                'municipioid' => 106,
            ],
            [
                'parroquiaid' => 365,
                'parroquianom' => 'Zazarida',
                'municipioid' => 106,
            ],
            [
                'parroquiaid' => 366,
                'parroquianom' => 'Cm. Dabajuro',
                'municipioid' => 107,
            ],
            [
                'parroquiaid' => 367,
                'parroquianom' => 'Chichiriviche',
                'municipioid' => 108,
            ],
            [
                'parroquiaid' => 368,
                'parroquianom' => 'Boca De Tocuyo',
                'municipioid' => 108,
            ],
            [
                'parroquiaid' => 369,
                'parroquianom' => 'Tocuyo De La Costa',
                'municipioid' => 108,
            ],
            [
                'parroquiaid' => 370,
                'parroquianom' => 'Los Taques',
                'municipioid' => 109,
            ],
            [
                'parroquiaid' => 371,
                'parroquianom' => 'Judibana',
                'municipioid' => 109,
            ],
            [
                'parroquiaid' => 372,
                'parroquianom' => 'Piritu',
                'municipioid' => 110,
            ],
            [
                'parroquiaid' => 373,
                'parroquianom' => 'San Jose De La Costa',
                'municipioid' => 110,
            ],
            [
                'parroquiaid' => 374,
                'parroquianom' => 'Sta.Cruz De Bucaral',
                'municipioid' => 111,
            ],
            [
                'parroquiaid' => 375,
                'parroquianom' => 'El Charal',
                'municipioid' => 111,
            ],
            [
                'parroquiaid' => 376,
                'parroquianom' => 'Las Vegas Del Tuy',
                'municipioid' => 111,
            ],
            [
                'parroquiaid' => 377,
                'parroquianom' => 'Cm. Mirimire',
                'municipioid' => 112,
            ],
            [
                'parroquiaid' => 378,
                'parroquianom' => 'Jacura',
                'municipioid' => 113,
            ],
            [
                'parroquiaid' => 379,
                'parroquianom' => 'Agua Linda',
                'municipioid' => 113,
            ],
            [
                'parroquiaid' => 380,
                'parroquianom' => 'Araurima',
                'municipioid' => 113,
            ],
            [
                'parroquiaid' => 381,
                'parroquianom' => 'Cm. Yaracal',
                'municipioid' => 114,
            ],
            [
                'parroquiaid' => 382,
                'parroquianom' => 'Cm. Palma Sola',
                'municipioid' => 115,
            ],
            [
                'parroquiaid' => 383,
                'parroquianom' => 'Sucre',
                'municipioid' => 116,
            ],
            [
                'parroquiaid' => 384,
                'parroquianom' => 'Pecaya',
                'municipioid' => 116,
            ],
            [
                'parroquiaid' => 385,
                'parroquianom' => 'Urumaco',
                'municipioid' => 117,
            ],
            [
                'parroquiaid' => 386,
                'parroquianom' => 'Bruzual',
                'municipioid' => 117,
            ],
            [
                'parroquiaid' => 387,
                'parroquianom' => 'Cm. Tocopero',
                'municipioid' => 118,
            ],
            [
                'parroquiaid' => 388,
                'parroquianom' => 'Valle De La Pascua',
                'municipioid' => 119,
            ],
            [
                'parroquiaid' => 389,
                'parroquianom' => 'Espino',
                'municipioid' => 119,
            ],
            [
                'parroquiaid' => 390,
                'parroquianom' => 'El Sombrero',
                'municipioid' => 120,
            ],
            [
                'parroquiaid' => 391,
                'parroquianom' => 'Sosa',
                'municipioid' => 120,
            ],
            [
                'parroquiaid' => 392,
                'parroquianom' => 'Calabozo',
                'municipioid' => 121,
            ],
            [
                'parroquiaid' => 393,
                'parroquianom' => 'El Calvario',
                'municipioid' => 121,
            ],
            [
                'parroquiaid' => 394,
                'parroquianom' => 'El Rastro',
                'municipioid' => 121,
            ],
            [
                'parroquiaid' => 395,
                'parroquianom' => 'Guardatinajas',
                'municipioid' => 121,
            ],
            [
                'parroquiaid' => 396,
                'parroquianom' => 'Altagracia De Orituco',
                'municipioid' => 122,
            ],
            [
                'parroquiaid' => 397,
                'parroquianom' => 'Lezama',
                'municipioid' => 122,
            ],
            [
                'parroquiaid' => 398,
                'parroquianom' => 'Libertad De Orituco',
                'municipioid' => 122,
            ],
            [
                'parroquiaid' => 399,
                'parroquianom' => 'San Fco De Macaira',
                'municipioid' => 122,
            ],
            [
                'parroquiaid' => 400,
                'parroquianom' => 'San Rafael De Orituco',
                'municipioid' => 122,
            ],
        ]);

        $this->db->table('sgc_parroquias')->insertBatch([
            [
                'parroquiaid' => 401,
                'parroquianom' => 'Soublette',
                'municipioid' => 122,
            ],
            [
                'parroquiaid' => 402,
                'parroquianom' => 'Paso Real De Macaira',
                'municipioid' => 122,
            ],
            [
                'parroquiaid' => 403,
                'parroquianom' => 'Tucupido',
                'municipioid' => 123,
            ],
            [
                'parroquiaid' => 404,
                'parroquianom' => 'San Rafael De Laya',
                'municipioid' => 123,
            ],
            [
                'parroquiaid' => 405,
                'parroquianom' => 'San Juan De Los Morros',
                'municipioid' => 124,
            ],
            [
                'parroquiaid' => 406,
                'parroquianom' => 'Parapara',
                'municipioid' => 124,
            ],
            [
                'parroquiaid' => 407,
                'parroquianom' => 'Cantagallo',
                'municipioid' => 124,
            ],
            [
                'parroquiaid' => 408,
                'parroquianom' => 'Zaraza',
                'municipioid' => 125,
            ],
            [
                'parroquiaid' => 409,
                'parroquianom' => 'San Jose De Unare',
                'municipioid' => 125,
            ],
            [
                'parroquiaid' => 410,
                'parroquianom' => 'Camaguan',
                'municipioid' => 126,
            ],
            [
                'parroquiaid' => 411,
                'parroquianom' => 'Puerto Miranda',
                'municipioid' => 126,
            ],
            [
                'parroquiaid' => 412,
                'parroquianom' => 'Uverito',
                'municipioid' => 126,
            ],
            [
                'parroquiaid' => 413,
                'parroquianom' => 'San Jose De Guaribe',
                'municipioid' => 127,
            ],
            [
                'parroquiaid' => 414,
                'parroquianom' => 'Las Mercedes',
                'municipioid' => 128,
            ],
            [
                'parroquiaid' => 415,
                'parroquianom' => 'Sta Rita De Manapire',
                'municipioid' => 128,
            ],
            [
                'parroquiaid' => 416,
                'parroquianom' => 'Cabruta',
                'municipioid' => 128,
            ],
            [
                'parroquiaid' => 417,
                'parroquianom' => 'El Socorro',
                'municipioid' => 129,
            ],
            [
                'parroquiaid' => 418,
                'parroquianom' => 'Ortiz',
                'municipioid' => 130,
            ],
            [
                'parroquiaid' => 419,
                'parroquianom' => 'San Fco. De Tiznados',
                'municipioid' => 130,
            ],
            [
                'parroquiaid' => 420,
                'parroquianom' => 'San Jose De Tiznados',
                'municipioid' => 130,
            ],
            [
                'parroquiaid' => 421,
                'parroquianom' => 'S Lorenzo De Tiznados',
                'municipioid' => 130,
            ],
            [
                'parroquiaid' => 422,
                'parroquianom' => 'Santa Maria De Ipire',
                'municipioid' => 131,
            ],
            [
                'parroquiaid' => 423,
                'parroquianom' => 'Altamira',
                'municipioid' => 131,
            ],
            [
                'parroquiaid' => 424,
                'parroquianom' => 'Chaguaramas',
                'municipioid' => 132,
            ],
            [
                'parroquiaid' => 425,
                'parroquianom' => 'Guayabal',
                'municipioid' => 133,
            ],
            [
                'parroquiaid' => 426,
                'parroquianom' => 'Cazorla',
                'municipioid' => 133,
            ],
            [
                'parroquiaid' => 427,
                'parroquianom' => 'Freitez',
                'municipioid' => 134,
            ],
            [
                'parroquiaid' => 428,
                'parroquianom' => 'Jose Maria Blanco',
                'municipioid' => 134,
            ],
            [
                'parroquiaid' => 429,
                'parroquianom' => 'Catedral',
                'municipioid' => 135,
            ],
            [
                'parroquiaid' => 430,
                'parroquianom' => 'La Concepcion',
                'municipioid' => 135,
            ],
            [
                'parroquiaid' => 431,
                'parroquianom' => 'Santa Rosa',
                'municipioid' => 135,
            ],
            [
                'parroquiaid' => 432,
                'parroquianom' => 'Union',
                'municipioid' => 135,
            ],
            [
                'parroquiaid' => 433,
                'parroquianom' => 'El Cuji',
                'municipioid' => 135,
            ],
            [
                'parroquiaid' => 434,
                'parroquianom' => 'Tamaca',
                'municipioid' => 135,
            ],
            [
                'parroquiaid' => 435,
                'parroquianom' => 'Juan De Villegas',
                'municipioid' => 135,
            ],
            [
                'parroquiaid' => 436,
                'parroquianom' => 'Aguedo F. Alvarado',
                'municipioid' => 135,
            ],
            [
                'parroquiaid' => 437,
                'parroquianom' => 'Buena Vista',
                'municipioid' => 135,
            ],
            [
                'parroquiaid' => 438,
                'parroquianom' => 'Juarez',
                'municipioid' => 135,
            ],
            [
                'parroquiaid' => 439,
                'parroquianom' => 'Juan B Rodriguez',
                'municipioid' => 136,
            ],
            [
                'parroquiaid' => 440,
                'parroquianom' => 'Diego De Lozada',
                'municipioid' => 136,
            ],
            [
                'parroquiaid' => 441,
                'parroquianom' => 'San Miguel',
                'municipioid' => 136,
            ],
            [
                'parroquiaid' => 442,
                'parroquianom' => 'Cuara',
                'municipioid' => 136,
            ],
            [
                'parroquiaid' => 443,
                'parroquianom' => 'Paraiso De San Jose',
                'municipioid' => 136,
            ],
            [
                'parroquiaid' => 444,
                'parroquianom' => 'Tintorero',
                'municipioid' => 136,
            ],
            [
                'parroquiaid' => 445,
                'parroquianom' => 'Jose Bernardo Dorante',
                'municipioid' => 136,
            ],
            [
                'parroquiaid' => 446,
                'parroquianom' => 'Crnel. Mariano Peraza',
                'municipioid' => 136,
            ],
            [
                'parroquiaid' => 447,
                'parroquianom' => 'Bolivar',
                'municipioid' => 137,
            ],
            [
                'parroquiaid' => 448,
                'parroquianom' => 'Anzoategui',
                'municipioid' => 137,
            ],
            [
                'parroquiaid' => 449,
                'parroquianom' => 'Guarico',
                'municipioid' => 137,
            ],
            [
                'parroquiaid' => 450,
                'parroquianom' => 'Humocaro Alto',
                'municipioid' => 137,
            ],
        ]);

        $this->db->table('sgc_parroquias')->insertBatch([
            [
                'parroquiaid' => 451,
                'parroquianom' => 'Humocaro Bajo',
                'municipioid' => 137,
            ],
            [
                'parroquiaid' => 452,
                'parroquianom' => 'Moran',
                'municipioid' => 137,
            ],
            [
                'parroquiaid' => 453,
                'parroquianom' => 'Hilario Luna Y Luna',
                'municipioid' => 137,
            ],
            [
                'parroquiaid' => 454,
                'parroquianom' => 'La Candelaria',
                'municipioid' => 137,
            ],
            [
                'parroquiaid' => 455,
                'parroquianom' => 'Cabudare',
                'municipioid' => 138,
            ],
            [
                'parroquiaid' => 456,
                'parroquianom' => 'Jose G. Bastidas',
                'municipioid' => 138,
            ],
            [
                'parroquiaid' => 457,
                'parroquianom' => 'Agua Viva',
                'municipioid' => 138,
            ],
            [
                'parroquiaid' => 458,
                'parroquianom' => 'Trinidad Samuel',
                'municipioid' => 139,
            ],
            [
                'parroquiaid' => 459,
                'parroquianom' => 'Antonio Diaz',
                'municipioid' => 139,
            ],
            [
                'parroquiaid' => 460,
                'parroquianom' => 'Camacaro',
                'municipioid' => 139,
            ],
            [
                'parroquiaid' => 461,
                'parroquianom' => 'Castañeda',
                'municipioid' => 139,
            ],
            [
                'parroquiaid' => 462,
                'parroquianom' => 'Chiquinquira',
                'municipioid' => 139,
            ],
            [
                'parroquiaid' => 463,
                'parroquianom' => 'Espinoza Los Monteros',
                'municipioid' => 139,
            ],
            [
                'parroquiaid' => 464,
                'parroquianom' => 'Lara',
                'municipioid' => 139,
            ],
            [
                'parroquiaid' => 465,
                'parroquianom' => 'Manuel Morillo',
                'municipioid' => 139,
            ],
            [
                'parroquiaid' => 466,
                'parroquianom' => 'Montes De Oca',
                'municipioid' => 139,
            ],
            [
                'parroquiaid' => 467,
                'parroquianom' => 'Torres',
                'municipioid' => 139,
            ],
            [
                'parroquiaid' => 468,
                'parroquianom' => 'El Blanco',
                'municipioid' => 139,
            ],
            [
                'parroquiaid' => 469,
                'parroquianom' => 'Monta A Verde',
                'municipioid' => 139,
            ],
            [
                'parroquiaid' => 470,
                'parroquianom' => 'Heriberto Arroyo',
                'municipioid' => 139,
            ],
            [
                'parroquiaid' => 471,
                'parroquianom' => 'Las Mercedes',
                'municipioid' => 139,
            ],
            [
                'parroquiaid' => 472,
                'parroquianom' => 'Cecilio Zubillaga',
                'municipioid' => 139,
            ],
            [
                'parroquiaid' => 473,
                'parroquianom' => 'Reyes Vargas',
                'municipioid' => 139,
            ],
            [
                'parroquiaid' => 474,
                'parroquianom' => 'Altagracia',
                'municipioid' => 139,
            ],
            [
                'parroquiaid' => 475,
                'parroquianom' => 'Siquisique',
                'municipioid' => 140,
            ],
            [
                'parroquiaid' => 476,
                'parroquianom' => 'San Miguel',
                'municipioid' => 140,
            ],
            [
                'parroquiaid' => 477,
                'parroquianom' => 'Xaguas',
                'municipioid' => 140,
            ],
            [
                'parroquiaid' => 478,
                'parroquianom' => 'Moroturo',
                'municipioid' => 140,
            ],
            [
                'parroquiaid' => 479,
                'parroquianom' => 'Pio Tamayo',
                'municipioid' => 141,
            ],
            [
                'parroquiaid' => 480,
                'parroquianom' => 'Yacambu',
                'municipioid' => 141,
            ],
            [
                'parroquiaid' => 481,
                'parroquianom' => 'Qbda. Honda De Guache',
                'municipioid' => 141,
            ],
            [
                'parroquiaid' => 482,
                'parroquianom' => 'Sarare',
                'municipioid' => 142,
            ],
            [
                'parroquiaid' => 483,
                'parroquianom' => 'Gustavo Vegas Leon',
                'municipioid' => 142,
            ],
            [
                'parroquiaid' => 484,
                'parroquianom' => 'Buria',
                'municipioid' => 142,
            ],
            [
                'parroquiaid' => 485,
                'parroquianom' => 'Gabriel Picon G.',
                'municipioid' => 143,
            ],
            [
                'parroquiaid' => 486,
                'parroquianom' => 'Hector Amable Mora',
                'municipioid' => 143,
            ],
            [
                'parroquiaid' => 487,
                'parroquianom' => 'Jose Nucete Sardi',
                'municipioid' => 143,
            ],
            [
                'parroquiaid' => 488,
                'parroquianom' => 'Pulido Mendez',
                'municipioid' => 143,
            ],
            [
                'parroquiaid' => 489,
                'parroquianom' => 'Pte. Romulo Gallegos',
                'municipioid' => 143,
            ],
            [
                'parroquiaid' => 490,
                'parroquianom' => 'Presidente Betancourt',
                'municipioid' => 143,
            ],
            [
                'parroquiaid' => 491,
                'parroquianom' => 'Presidente Paez',
                'municipioid' => 143,
            ],
            [
                'parroquiaid' => 492,
                'parroquianom' => 'Cm. La Azulita',
                'municipioid' => 144,
            ],
            [
                'parroquiaid' => 493,
                'parroquianom' => 'Cm. Canagua',
                'municipioid' => 145,
            ],
            [
                'parroquiaid' => 494,
                'parroquianom' => 'Capuri',
                'municipioid' => 145,
            ],
            [
                'parroquiaid' => 495,
                'parroquianom' => 'Chacanta',
                'municipioid' => 145,
            ],
            [
                'parroquiaid' => 496,
                'parroquianom' => 'El Molino',
                'municipioid' => 145,
            ],
            [
                'parroquiaid' => 497,
                'parroquianom' => 'Guaimaral',
                'municipioid' => 145,
            ],
            [
                'parroquiaid' => 498,
                'parroquianom' => 'Mucutuy',
                'municipioid' => 145,
            ],
            [
                'parroquiaid' => 499,
                'parroquianom' => 'Mucuchachi',
                'municipioid' => 145,
            ],
            [
                'parroquiaid' => 500,
                'parroquianom' => 'Acequias',
                'municipioid' => 146,
            ],
        ]);

        $this->db->table('sgc_parroquias')->insertBatch([
            [
                'parroquiaid' => 501,
                'parroquianom' => 'Jaji',
                'municipioid' => 146,
            ],
            [
                'parroquiaid' => 502,
                'parroquianom' => 'La Mesa',
                'municipioid' => 146,
            ],
            [
                'parroquiaid' => 503,
                'parroquianom' => 'San Jose',
                'municipioid' => 146,
            ],
            [
                'parroquiaid' => 504,
                'parroquianom' => 'Montalban',
                'municipioid' => 146,
            ],
            [
                'parroquiaid' => 505,
                'parroquianom' => 'Matriz',
                'municipioid' => 146,
            ],
            [
                'parroquiaid' => 506,
                'parroquianom' => 'Fernandez Peña',
                'municipioid' => 146,
            ],
            [
                'parroquiaid' => 507,
                'parroquianom' => 'Cm. Guaraque',
                'municipioid' => 147,
            ],
            [
                'parroquiaid' => 508,
                'parroquianom' => 'Mesa De Quintero',
                'municipioid' => 147,
            ],
            [
                'parroquiaid' => 509,
                'parroquianom' => 'Rio Negro',
                'municipioid' => 147,
            ],
            [
                'parroquiaid' => 510,
                'parroquianom' => 'Cm. Arapuey',
                'municipioid' => 148,
            ],
            [
                'parroquiaid' => 511,
                'parroquianom' => 'Palmira',
                'municipioid' => 148,
            ],
            [
                'parroquiaid' => 512,
                'parroquianom' => 'Cm. Torondoy',
                'municipioid' => 149,
            ],
            [
                'parroquiaid' => 513,
                'parroquianom' => 'San Cristobal De T',
                'municipioid' => 149,
            ],
            [
                'parroquiaid' => 514,
                'parroquianom' => 'Arias',
                'municipioid' => 150,
            ],
            [
                'parroquiaid' => 515,
                'parroquianom' => 'Sagrario',
                'municipioid' => 150,
            ],
            [
                'parroquiaid' => 516,
                'parroquianom' => 'Milla',
                'municipioid' => 150,
            ],
            [
                'parroquiaid' => 517,
                'parroquianom' => 'El Llano',
                'municipioid' => 150,
            ],
            [
                'parroquiaid' => 518,
                'parroquianom' => 'Juan Rodriguez Suarez',
                'municipioid' => 150,
            ],
            [
                'parroquiaid' => 519,
                'parroquianom' => 'Jacinto Plaza',
                'municipioid' => 150,
            ],
            [
                'parroquiaid' => 520,
                'parroquianom' => 'Domingo Peña',
                'municipioid' => 150,
            ],
            [
                'parroquiaid' => 521,
                'parroquianom' => 'Gonzalo Picon Febres',
                'municipioid' => 150,
            ],
            [
                'parroquiaid' => 522,
                'parroquianom' => 'Osuna Rodriguez',
                'municipioid' => 150,
            ],
            [
                'parroquiaid' => 523,
                'parroquianom' => 'Lasso De La Vega',
                'municipioid' => 150,
            ],
            [
                'parroquiaid' => 524,
                'parroquianom' => 'Caracciolo Parra P',
                'municipioid' => 150,
            ],
            [
                'parroquiaid' => 525,
                'parroquianom' => 'Mariano Picon Salas',
                'municipioid' => 150,
            ],
            [
                'parroquiaid' => 526,
                'parroquianom' => 'Antonio Spinetti Dini',
                'municipioid' => 150,
            ],
            [
                'parroquiaid' => 527,
                'parroquianom' => 'El Morro',
                'municipioid' => 150,
            ],
            [
                'parroquiaid' => 528,
                'parroquianom' => 'Los Nevados',
                'municipioid' => 150,
            ],
            [
                'parroquiaid' => 529,
                'parroquianom' => 'Cm. Tabay',
                'municipioid' => 151,
            ],
            [
                'parroquiaid' => 530,
                'parroquianom' => 'Cm. Timotes',
                'municipioid' => 152,
            ],
            [
                'parroquiaid' => 531,
                'parroquianom' => 'Andres Eloy Blanco',
                'municipioid' => 152,
            ],
            [
                'parroquiaid' => 532,
                'parroquianom' => 'Piñango',
                'municipioid' => 152,
            ],
            [
                'parroquiaid' => 533,
                'parroquianom' => 'La Venta',
                'municipioid' => 152,
            ],
            [
                'parroquiaid' => 534,
                'parroquianom' => 'Cm. Sta Cruz De Mora',
                'municipioid' => 153,
            ],
            [
                'parroquiaid' => 535,
                'parroquianom' => 'Mesa Bolivar',
                'municipioid' => 153,
            ],
            [
                'parroquiaid' => 536,
                'parroquianom' => 'Mesa De Las Palmas',
                'municipioid' => 153,
            ],
            [
                'parroquiaid' => 537,
                'parroquianom' => 'Cm. Sta Elena De Arenales',
                'municipioid' => 154,
            ],
            [
                'parroquiaid' => 538,
                'parroquianom' => 'Eloy Paredes',
                'municipioid' => 154,
            ],
            [
                'parroquiaid' => 539,
                'parroquianom' => 'Pq R De Alcazar',
                'municipioid' => 154,
            ],
            [
                'parroquiaid' => 540,
                'parroquianom' => 'Cm. Tucani',
                'municipioid' => 155,
            ],
            [
                'parroquiaid' => 541,
                'parroquianom' => 'Florencio Ramirez',
                'municipioid' => 155,
            ],
            [
                'parroquiaid' => 542,
                'parroquianom' => 'Cm. Santo Domingo',
                'municipioid' => 156,
            ],
            [
                'parroquiaid' => 543,
                'parroquianom' => 'Las Piedras',
                'municipioid' => 156,
            ],
            [
                'parroquiaid' => 544,
                'parroquianom' => 'Cm. Pueblo Llano',
                'municipioid' => 157,
            ],
            [
                'parroquiaid' => 545,
                'parroquianom' => 'Cm. Mucuchies',
                'municipioid' => 158,
            ],
            [
                'parroquiaid' => 546,
                'parroquianom' => 'Mucuruba',
                'municipioid' => 158,
            ],
            [
                'parroquiaid' => 547,
                'parroquianom' => 'San Rafael',
                'municipioid' => 158,
            ],
            [
                'parroquiaid' => 548,
                'parroquianom' => 'Cacute',
                'municipioid' => 158,
            ],
            [
                'parroquiaid' => 549,
                'parroquianom' => 'La Toma',
                'municipioid' => 158,
            ],
            [
                'parroquiaid' => 550,
                'parroquianom' => 'Cm. Bailadores',
                'municipioid' => 159,
            ],
        ]);

        $this->db->table('sgc_parroquias')->insertBatch([
            [
                'parroquiaid' => 551,
                'parroquianom' => 'Geronimo Maldonado',
                'municipioid' => 159,
            ],
            [
                'parroquiaid' => 552,
                'parroquianom' => 'Cm. Lagunillas',
                'municipioid' => 160,
            ],
            [
                'parroquiaid' => 553,
                'parroquianom' => 'Chiguara',
                'municipioid' => 160,
            ],
            [
                'parroquiaid' => 554,
                'parroquianom' => 'Estanques',
                'municipioid' => 160,
            ],
            [
                'parroquiaid' => 555,
                'parroquianom' => 'San Juan',
                'municipioid' => 160,
            ],
            [
                'parroquiaid' => 556,
                'parroquianom' => 'Pueblo Nuevo Del Sur',
                'municipioid' => 160,
            ],
            [
                'parroquiaid' => 557,
                'parroquianom' => 'La Trampa',
                'municipioid' => 160,
            ],
            [
                'parroquiaid' => 558,
                'parroquianom' => 'El Llano',
                'municipioid' => 161,
            ],
            [
                'parroquiaid' => 559,
                'parroquianom' => 'Tovar',
                'municipioid' => 161,
            ],
            [
                'parroquiaid' => 560,
                'parroquianom' => 'El Amparo',
                'municipioid' => 161,
            ],
            [
                'parroquiaid' => 561,
                'parroquianom' => 'San Francisco',
                'municipioid' => 161,
            ],
            [
                'parroquiaid' => 562,
                'parroquianom' => 'Cm. Nueva Bolivia',
                'municipioid' => 162,
            ],
            [
                'parroquiaid' => 563,
                'parroquianom' => 'Independencia',
                'municipioid' => 162,
            ],
            [
                'parroquiaid' => 564,
                'parroquianom' => 'Maria C Palacios',
                'municipioid' => 162,
            ],
            [
                'parroquiaid' => 565,
                'parroquianom' => 'Santa Apolonia',
                'municipioid' => 162,
            ],
            [
                'parroquiaid' => 566,
                'parroquianom' => 'Cm. Sta Maria De Caparo',
                'municipioid' => 163,
            ],
            [
                'parroquiaid' => 567,
                'parroquianom' => 'Cm. Aricagua',
                'municipioid' => 164,
            ],
            [
                'parroquiaid' => 568,
                'parroquianom' => 'San Antonio',
                'municipioid' => 164,
            ],
            [
                'parroquiaid' => 569,
                'parroquianom' => 'Cm. Zea',
                'municipioid' => 165,
            ],
            [
                'parroquiaid' => 570,
                'parroquianom' => 'Caño El Tigre',
                'municipioid' => 165,
            ],
            [
                'parroquiaid' => 571,
                'parroquianom' => 'Caucagua',
                'municipioid' => 166,
            ],
            [
                'parroquiaid' => 572,
                'parroquianom' => 'Araguita',
                'municipioid' => 166,
            ],
            [
                'parroquiaid' => 573,
                'parroquianom' => 'Arevalo Gonzalez',
                'municipioid' => 166,
            ],
            [
                'parroquiaid' => 574,
                'parroquianom' => 'Capaya',
                'municipioid' => 166,
            ],
            [
                'parroquiaid' => 575,
                'parroquianom' => 'Panaquire',
                'municipioid' => 166,
            ],
            [
                'parroquiaid' => 576,
                'parroquianom' => 'Ribas',
                'municipioid' => 166,
            ],
            [
                'parroquiaid' => 577,
                'parroquianom' => 'El Cafe',
                'municipioid' => 166,
            ],
            [
                'parroquiaid' => 578,
                'parroquianom' => 'Marizapa',
                'municipioid' => 166,
            ],
            [
                'parroquiaid' => 579,
                'parroquianom' => 'Higuerote',
                'municipioid' => 167,
            ],
            [
                'parroquiaid' => 580,
                'parroquianom' => 'Curiepe',
                'municipioid' => 167,
            ],
            [
                'parroquiaid' => 581,
                'parroquianom' => 'Tacarigua',
                'municipioid' => 167,
            ],
            [
                'parroquiaid' => 582,
                'parroquianom' => 'Los Teques',
                'municipioid' => 168,
            ],
            [
                'parroquiaid' => 583,
                'parroquianom' => 'Cecilio Acosta',
                'municipioid' => 168,
            ],
            [
                'parroquiaid' => 584,
                'parroquianom' => 'Paracotos',
                'municipioid' => 168,
            ],
            [
                'parroquiaid' => 585,
                'parroquianom' => 'San Pedro',
                'municipioid' => 168,
            ],
            [
                'parroquiaid' => 586,
                'parroquianom' => 'Tacata',
                'municipioid' => 168,
            ],
            [
                'parroquiaid' => 587,
                'parroquianom' => 'El Jarillo',
                'municipioid' => 168,
            ],
            [
                'parroquiaid' => 588,
                'parroquianom' => 'Altagracia De La M',
                'municipioid' => 168,
            ],
            [
                'parroquiaid' => 589,
                'parroquianom' => 'Sta Teresa Del Tuy',
                'municipioid' => 169,
            ],
            [
                'parroquiaid' => 590,
                'parroquianom' => 'El Cartanal',
                'municipioid' => 169,
            ],
            [
                'parroquiaid' => 591,
                'parroquianom' => 'Ocumare Del Tuy',
                'municipioid' => 170,
            ],
            [
                'parroquiaid' => 592,
                'parroquianom' => 'La Democracia',
                'municipioid' => 170,
            ],
            [
                'parroquiaid' => 593,
                'parroquianom' => 'Santa Barbara',
                'municipioid' => 170,
            ],
            [
                'parroquiaid' => 594,
                'parroquianom' => 'Rio Chico',
                'municipioid' => 171,
            ],
            [
                'parroquiaid' => 595,
                'parroquianom' => 'El Guapo',
                'municipioid' => 171,
            ],
            [
                'parroquiaid' => 596,
                'parroquianom' => 'Tacarigua De La Laguna',
                'municipioid' => 171,
            ],
            [
                'parroquiaid' => 597,
                'parroquianom' => 'Paparo',
                'municipioid' => 171,
            ],
            [
                'parroquiaid' => 598,
                'parroquianom' => 'Sn Fernando Del Guapo',
                'municipioid' => 171,
            ],
            [
                'parroquiaid' => 599,
                'parroquianom' => 'Santa Lucia',
                'municipioid' => 172,
            ],
            [
                'parroquiaid' => 600,
                'parroquianom' => 'Guarenas',
                'municipioid' => 173,
            ],
        ]);

        $this->db->table('sgc_parroquias')->insertBatch([
            [
                'parroquiaid' => 601,
                'parroquianom' => 'Petare',
                'municipioid' => 174,
            ],
            [
                'parroquiaid' => 602,
                'parroquianom' => 'Leoncio Martinez',
                'municipioid' => 174,
            ],
            [
                'parroquiaid' => 603,
                'parroquianom' => 'Caucaguita',
                'municipioid' => 174,
            ],
            [
                'parroquiaid' => 604,
                'parroquianom' => 'Filas De Mariches',
                'municipioid' => 174,
            ],
            [
                'parroquiaid' => 605,
                'parroquianom' => 'La Dolorita',
                'municipioid' => 174,
            ],
            [
                'parroquiaid' => 606,
                'parroquianom' => 'Cua',
                'municipioid' => 175,
            ],
            [
                'parroquiaid' => 607,
                'parroquianom' => 'Nueva Cua',
                'municipioid' => 175,
            ],
            [
                'parroquiaid' => 608,
                'parroquianom' => 'Guatire',
                'municipioid' => 176,
            ],
            [
                'parroquiaid' => 609,
                'parroquianom' => 'Bolivar',
                'municipioid' => 176,
            ],
            [
                'parroquiaid' => 610,
                'parroquianom' => 'Charallave',
                'municipioid' => 177,
            ],
            [
                'parroquiaid' => 611,
                'parroquianom' => 'Las Brisas',
                'municipioid' => 177,
            ],
            [
                'parroquiaid' => 612,
                'parroquianom' => 'San Antonio Los Altos',
                'municipioid' => 178,
            ],
            [
                'parroquiaid' => 613,
                'parroquianom' => 'San Jose De Barlovento',
                'municipioid' => 179,
            ],
            [
                'parroquiaid' => 614,
                'parroquianom' => 'Cumbo',
                'municipioid' => 179,
            ],
            [
                'parroquiaid' => 615,
                'parroquianom' => 'San Fco De Yare',
                'municipioid' => 180,
            ],
            [
                'parroquiaid' => 616,
                'parroquianom' => 'S Antonio De Yare',
                'municipioid' => 180,
            ],
            [
                'parroquiaid' => 617,
                'parroquianom' => 'Baruta',
                'municipioid' => 181,
            ],
            [
                'parroquiaid' => 618,
                'parroquianom' => 'El Cafetal',
                'municipioid' => 181,
            ],
            [
                'parroquiaid' => 619,
                'parroquianom' => 'Las Minas De Baruta',
                'municipioid' => 181,
            ],
            [
                'parroquiaid' => 620,
                'parroquianom' => 'Carrizal',
                'municipioid' => 182,
            ],
            [
                'parroquiaid' => 621,
                'parroquianom' => 'Chacao',
                'municipioid' => 183,
            ],
            [
                'parroquiaid' => 622,
                'parroquianom' => 'El Hatillo',
                'municipioid' => 184,
            ],
            [
                'parroquiaid' => 623,
                'parroquianom' => 'Mamporal',
                'municipioid' => 185,
            ],
            [
                'parroquiaid' => 624,
                'parroquianom' => 'Cupira',
                'municipioid' => 186,
            ],
            [
                'parroquiaid' => 625,
                'parroquianom' => 'Machurucuto',
                'municipioid' => 186,
            ],
            [
                'parroquiaid' => 626,
                'parroquianom' => 'Cm. San Antonio',
                'municipioid' => 187,
            ],
            [
                'parroquiaid' => 627,
                'parroquianom' => 'San Francisco',
                'municipioid' => 187,
            ],
            [
                'parroquiaid' => 628,
                'parroquianom' => 'Cm. Caripito',
                'municipioid' => 188,
            ],
            [
                'parroquiaid' => 629,
                'parroquianom' => 'Cm. Caripe',
                'municipioid' => 189,
            ],
            [
                'parroquiaid' => 630,
                'parroquianom' => 'Teresen',
                'municipioid' => 189,
            ],
            [
                'parroquiaid' => 631,
                'parroquianom' => 'El Guacharo',
                'municipioid' => 189,
            ],
            [
                'parroquiaid' => 632,
                'parroquianom' => 'San Agustin',
                'municipioid' => 189,
            ],
            [
                'parroquiaid' => 633,
                'parroquianom' => 'La Guanota',
                'municipioid' => 189,
            ],
            [
                'parroquiaid' => 634,
                'parroquianom' => 'Sabana De Piedra',
                'municipioid' => 189,
            ],
            [
                'parroquiaid' => 635,
                'parroquianom' => 'Cm. Caicara',
                'municipioid' => 190,
            ],
            [
                'parroquiaid' => 636,
                'parroquianom' => 'Areo',
                'municipioid' => 190,
            ],
            [
                'parroquiaid' => 637,
                'parroquianom' => 'San Felix',
                'municipioid' => 190,
            ],
            [
                'parroquiaid' => 638,
                'parroquianom' => 'Viento Fresco',
                'municipioid' => 190,
            ],
            [
                'parroquiaid' => 639,
                'parroquianom' => 'Cm. Punta De Mata',
                'municipioid' => 191,
            ],
            [
                'parroquiaid' => 640,
                'parroquianom' => 'El Tejero',
                'municipioid' => 191,
            ],
            [
                'parroquiaid' => 641,
                'parroquianom' => 'Cm. Temblador',
                'municipioid' => 192,
            ],
            [
                'parroquiaid' => 642,
                'parroquianom' => 'Tabasca',
                'municipioid' => 192,
            ],
            [
                'parroquiaid' => 643,
                'parroquianom' => 'Las Alhuacas',
                'municipioid' => 192,
            ],
            [
                'parroquiaid' => 644,
                'parroquianom' => 'Chaguaramas',
                'municipioid' => 192,
            ],
            [
                'parroquiaid' => 645,
                'parroquianom' => 'El Furrial',
                'municipioid' => 193,
            ],
            [
                'parroquiaid' => 646,
                'parroquianom' => 'Jusepin',
                'municipioid' => 193,
            ],
            [
                'parroquiaid' => 647,
                'parroquianom' => 'El Corozo',
                'municipioid' => 193,
            ],
            [
                'parroquiaid' => 648,
                'parroquianom' => 'San Vicente',
                'municipioid' => 193,
            ],
            [
                'parroquiaid' => 649,
                'parroquianom' => 'La Pica',
                'municipioid' => 193,
            ],
            [
                'parroquiaid' => 650,
                'parroquianom' => 'Alto De Los Godos',
                'municipioid' => 193,
            ],
        ]);

        $this->db->table('sgc_parroquias')->insertBatch([
            [
                'parroquiaid' => 651,
                'parroquianom' => 'Boqueron',
                'municipioid' => 193,
            ],
            [
                'parroquiaid' => 652,
                'parroquianom' => 'Las Cocuizas',
                'municipioid' => 193,
            ],
            [
                'parroquiaid' => 653,
                'parroquianom' => 'Santa Cruz',
                'municipioid' => 193,
            ],
            [
                'parroquiaid' => 654,
                'parroquianom' => 'San Simon',
                'municipioid' => 193,
            ],
            [
                'parroquiaid' => 655,
                'parroquianom' => 'Cm. Aragua',
                'municipioid' => 194,
            ],
            [
                'parroquiaid' => 656,
                'parroquianom' => 'Chaguaramal',
                'municipioid' => 194,
            ],
            [
                'parroquiaid' => 657,
                'parroquianom' => 'Guanaguana',
                'municipioid' => 194,
            ],
            [
                'parroquiaid' => 658,
                'parroquianom' => 'Aparicio',
                'municipioid' => 194,
            ],
            [
                'parroquiaid' => 659,
                'parroquianom' => 'Taguaya',
                'municipioid' => 194,
            ],
            [
                'parroquiaid' => 660,
                'parroquianom' => 'El Pinto',
                'municipioid' => 194,
            ],
            [
                'parroquiaid' => 661,
                'parroquianom' => 'La Toscana',
                'municipioid' => 194,
            ],
            [
                'parroquiaid' => 662,
                'parroquianom' => 'Cm. Quiriquire',
                'municipioid' => 195,
            ],
            [
                'parroquiaid' => 663,
                'parroquianom' => 'Cachipo',
                'municipioid' => 195,
            ],
            [
                'parroquiaid' => 664,
                'parroquianom' => 'Cm. Barrancas',
                'municipioid' => 196,
            ],
            [
                'parroquiaid' => 665,
                'parroquianom' => 'Los Barrancos De Fajardo',
                'municipioid' => 196,
            ],
            [
                'parroquiaid' => 666,
                'parroquianom' => 'Cm. Aguasay',
                'municipioid' => 197,
            ],
            [
                'parroquiaid' => 667,
                'parroquianom' => 'Cm. Santa Barbara',
                'municipioid' => 198,
            ],
            [
                'parroquiaid' => 668,
                'parroquianom' => 'Cm. Uracoa',
                'municipioid' => 199,
            ],
            [
                'parroquiaid' => 669,
                'parroquianom' => 'Cm. La Asuncion',
                'municipioid' => 200,
            ],
            [
                'parroquiaid' => 670,
                'parroquianom' => 'Cm. San Juan Bautista',
                'municipioid' => 201,
            ],
            [
                'parroquiaid' => 671,
                'parroquianom' => 'Zabala',
                'municipioid' => 201,
            ],
            [
                'parroquiaid' => 672,
                'parroquianom' => 'Cm. Santa Ana',
                'municipioid' => 202,
            ],
            [
                'parroquiaid' => 673,
                'parroquianom' => 'Guevara',
                'municipioid' => 202,
            ],
            [
                'parroquiaid' => 674,
                'parroquianom' => 'Matasiete',
                'municipioid' => 202,
            ],
            [
                'parroquiaid' => 675,
                'parroquianom' => 'Bolivar',
                'municipioid' => 202,
            ],
            [
                'parroquiaid' => 676,
                'parroquianom' => 'Sucre',
                'municipioid' => 202,
            ],
            [
                'parroquiaid' => 677,
                'parroquianom' => 'Cm. Pampatar',
                'municipioid' => 203,
            ],
            [
                'parroquiaid' => 678,
                'parroquianom' => 'Aguirre',
                'municipioid' => 203,
            ],
            [
                'parroquiaid' => 679,
                'parroquianom' => 'Cm. Juan Griego',
                'municipioid' => 204,
            ],
            [
                'parroquiaid' => 680,
                'parroquianom' => 'Adrian',
                'municipioid' => 204,
            ],
            [
                'parroquiaid' => 681,
                'parroquianom' => 'Cm. Porlamar',
                'municipioid' => 205,
            ],
            [
                'parroquiaid' => 682,
                'parroquianom' => 'Cm. Boca Del Rio',
                'municipioid' => 206,
            ],
            [
                'parroquiaid' => 683,
                'parroquianom' => 'San Francisco',
                'municipioid' => 206,
            ],
            [
                'parroquiaid' => 684,
                'parroquianom' => 'Cm. San Pedro De Coche',
                'municipioid' => 207,
            ],
            [
                'parroquiaid' => 685,
                'parroquianom' => 'Vicente Fuentes',
                'municipioid' => 207,
            ],
            [
                'parroquiaid' => 686,
                'parroquianom' => 'Cm. Punta De Piedras',
                'municipioid' => 208,
            ],
            [
                'parroquiaid' => 687,
                'parroquianom' => 'Los Barales',
                'municipioid' => 208,
            ],
            [
                'parroquiaid' => 688,
                'parroquianom' => 'Cm.La Plaza De Paraguachi',
                'municipioid' => 209,
            ],
            [
                'parroquiaid' => 689,
                'parroquianom' => 'Cm. Valle Esp Santo',
                'municipioid' => 210,
            ],
            [
                'parroquiaid' => 690,
                'parroquianom' => 'Francisco Fajardo',
                'municipioid' => 210,
            ],
            [
                'parroquiaid' => 691,
                'parroquianom' => 'Cm. Araure',
                'municipioid' => 211,
            ],
            [
                'parroquiaid' => 692,
                'parroquianom' => 'Rio Acarigua',
                'municipioid' => 211,
            ],
            [
                'parroquiaid' => 693,
                'parroquianom' => 'Cm. Piritu',
                'municipioid' => 212,
            ],
            [
                'parroquiaid' => 694,
                'parroquianom' => 'Uveral',
                'municipioid' => 212,
            ],
            [
                'parroquiaid' => 695,
                'parroquianom' => 'Cm. Guanare',
                'municipioid' => 213,
            ],
            [
                'parroquiaid' => 696,
                'parroquianom' => 'Cordoba',
                'municipioid' => 213,
            ],
            [
                'parroquiaid' => 697,
                'parroquianom' => 'San Juan Guanaguanare',
                'municipioid' => 213,
            ],
            [
                'parroquiaid' => 698,
                'parroquianom' => 'Virgen De La Coromoto',
                'municipioid' => 213,
            ],
            [
                'parroquiaid' => 699,
                'parroquianom' => 'San Jose De La Montaña',
                'municipioid' => 213,
            ],
            [
                'parroquiaid' => 700,
                'parroquianom' => 'Cm. Guanarito',
                'municipioid' => 214,
            ],
        ]);

        $this->db->table('sgc_parroquias')->insertBatch([
            [
                'parroquiaid' => 701,
                'parroquianom' => 'Trinidad De La Capilla',
                'municipioid' => 214,
            ],
            [
                'parroquiaid' => 702,
                'parroquianom' => 'Divina Pastora',
                'municipioid' => 214,
            ],
            [
                'parroquiaid' => 703,
                'parroquianom' => 'Cm. Ospino',
                'municipioid' => 215,
            ],
            [
                'parroquiaid' => 704,
                'parroquianom' => 'Aparicion',
                'municipioid' => 215,
            ],
            [
                'parroquiaid' => 705,
                'parroquianom' => 'La Estacion',
                'municipioid' => 215,
            ],
            [
                'parroquiaid' => 706,
                'parroquianom' => 'Cm. Acarigua',
                'municipioid' => 216,
            ],
            [
                'parroquiaid' => 707,
                'parroquianom' => 'Payara',
                'municipioid' => 216,
            ],
            [
                'parroquiaid' => 708,
                'parroquianom' => 'Pimpinela',
                'municipioid' => 216,
            ],
            [
                'parroquiaid' => 709,
                'parroquianom' => 'Ramon Peraza',
                'municipioid' => 216,
            ],
            [
                'parroquiaid' => 710,
                'parroquianom' => 'Cm. Biscucuy',
                'municipioid' => 217,
            ],
            [
                'parroquiaid' => 711,
                'parroquianom' => 'Concepcion',
                'municipioid' => 217,
            ],
            [
                'parroquiaid' => 712,
                'parroquianom' => 'San Rafael Palo Alzado',
                'municipioid' => 217,
            ],
            [
                'parroquiaid' => 713,
                'parroquianom' => 'Uvencio A Velasquez',
                'municipioid' => 217,
            ],
            [
                'parroquiaid' => 714,
                'parroquianom' => 'San Jose De Saguaz',
                'municipioid' => 217,
            ],
            [
                'parroquiaid' => 715,
                'parroquianom' => 'Villa Rosa',
                'municipioid' => 217,
            ],
            [
                'parroquiaid' => 716,
                'parroquianom' => 'Cm. Villa Bruzual',
                'municipioid' => 218,
            ],
            [
                'parroquiaid' => 717,
                'parroquianom' => 'Canelones',
                'municipioid' => 218,
            ],
            [
                'parroquiaid' => 718,
                'parroquianom' => 'Santa Cruz',
                'municipioid' => 218,
            ],
            [
                'parroquiaid' => 719,
                'parroquianom' => 'San Isidro Labrador',
                'municipioid' => 218,
            ],
            [
                'parroquiaid' => 720,
                'parroquianom' => 'Cm. Chabasquen',
                'municipioid' => 219,
            ],
            [
                'parroquiaid' => 721,
                'parroquianom' => 'Peña Blanca',
                'municipioid' => 219,
            ],
            [
                'parroquiaid' => 722,
                'parroquianom' => 'Cm. Agua Blanca',
                'municipioid' => 220,
            ],
            [
                'parroquiaid' => 723,
                'parroquianom' => 'Cm. Papelon',
                'municipioid' => 221,
            ],
            [
                'parroquiaid' => 724,
                'parroquianom' => 'Caño Delgadito',
                'municipioid' => 221,
            ],
            [
                'parroquiaid' => 725,
                'parroquianom' => 'Cm. Boconoito',
                'municipioid' => 222,
            ],
            [
                'parroquiaid' => 726,
                'parroquianom' => 'Antolin Tovar Aquino',
                'municipioid' => 222,
            ],
            [
                'parroquiaid' => 727,
                'parroquianom' => 'Cm. San Rafael De Onoto',
                'municipioid' => 223,
            ],
            [
                'parroquiaid' => 728,
                'parroquianom' => 'Santa Fe',
                'municipioid' => 223,
            ],
            [
                'parroquiaid' => 729,
                'parroquianom' => 'Thermo Morles',
                'municipioid' => 223,
            ],
            [
                'parroquiaid' => 730,
                'parroquianom' => 'Cm. El Playon',
                'municipioid' => 224,
            ],
            [
                'parroquiaid' => 731,
                'parroquianom' => 'Florida',
                'municipioid' => 224,
            ],
            [
                'parroquiaid' => 732,
                'parroquianom' => 'Rio Caribe',
                'municipioid' => 225,
            ],
            [
                'parroquiaid' => 733,
                'parroquianom' => 'San Juan Galdonas',
                'municipioid' => 225,
            ],
            [
                'parroquiaid' => 734,
                'parroquianom' => 'Puerto Santo',
                'municipioid' => 225,
            ],
            [
                'parroquiaid' => 735,
                'parroquianom' => 'El Morro De Pto Santo',
                'municipioid' => 225,
            ],
            [
                'parroquiaid' => 736,
                'parroquianom' => 'Antonio Jose De Sucre',
                'municipioid' => 225,
            ],
            [
                'parroquiaid' => 737,
                'parroquianom' => 'El Pilar',
                'municipioid' => 226,
            ],
            [
                'parroquiaid' => 738,
                'parroquianom' => 'El Rincon',
                'municipioid' => 226,
            ],
            [
                'parroquiaid' => 739,
                'parroquianom' => 'Guaraunos',
                'municipioid' => 226,
            ],
            [
                'parroquiaid' => 740,
                'parroquianom' => 'Tunapuicito',
                'municipioid' => 226,
            ],
            [
                'parroquiaid' => 741,
                'parroquianom' => 'Union',
                'municipioid' => 226,
            ],
            [
                'parroquiaid' => 742,
                'parroquianom' => 'Gral Fco. A Vasquez',
                'municipioid' => 226,
            ],
            [
                'parroquiaid' => 743,
                'parroquianom' => 'Santa Catalina',
                'municipioid' => 227,
            ],
            [
                'parroquiaid' => 744,
                'parroquianom' => 'Santa Rosa',
                'municipioid' => 227,
            ],
            [
                'parroquiaid' => 745,
                'parroquianom' => 'Santa Teresa',
                'municipioid' => 227,
            ],
            [
                'parroquiaid' => 746,
                'parroquianom' => 'Bolivar',
                'municipioid' => 227,
            ],
            [
                'parroquiaid' => 747,
                'parroquianom' => 'Macarapana',
                'municipioid' => 227,
            ],
            [
                'parroquiaid' => 748,
                'parroquianom' => 'Yaguaraparo',
                'municipioid' => 228,
            ],
            [
                'parroquiaid' => 749,
                'parroquianom' => 'Libertad',
                'municipioid' => 228,
            ],
            [
                'parroquiaid' => 750,
                'parroquianom' => 'Paujil',
                'municipioid' => 228,
            ],
        ]);

        $this->db->table('sgc_parroquias')->insertBatch([
            [
                'parroquiaid' => 751,
                'parroquianom' => 'Irapa',
                'municipioid' => 229,
            ],
            [
                'parroquiaid' => 752,
                'parroquianom' => 'Campo Claro',
                'municipioid' => 229,
            ],
            [
                'parroquiaid' => 753,
                'parroquianom' => 'Soro',
                'municipioid' => 229,
            ],
            [
                'parroquiaid' => 754,
                'parroquianom' => 'San Antonio De Irapa',
                'municipioid' => 229,
            ],
            [
                'parroquiaid' => 755,
                'parroquianom' => 'Marabal',
                'municipioid' => 229,
            ],
            [
                'parroquiaid' => 756,
                'parroquianom' => 'Cm. San Ant Del Golfo',
                'municipioid' => 230,
            ],
            [
                'parroquiaid' => 757,
                'parroquianom' => 'Cumanacoa',
                'municipioid' => 231,
            ],
            [
                'parroquiaid' => 758,
                'parroquianom' => 'Arenas',
                'municipioid' => 231,
            ],
            [
                'parroquiaid' => 759,
                'parroquianom' => 'Aricagua',
                'municipioid' => 231,
            ],
            [
                'parroquiaid' => 760,
                'parroquianom' => 'Cocollar',
                'municipioid' => 231,
            ],
            [
                'parroquiaid' => 761,
                'parroquianom' => 'San Fernando',
                'municipioid' => 231,
            ],
            [
                'parroquiaid' => 762,
                'parroquianom' => 'San Lorenzo',
                'municipioid' => 231,
            ],
            [
                'parroquiaid' => 763,
                'parroquianom' => 'Cariaco',
                'municipioid' => 232,
            ],
            [
                'parroquiaid' => 764,
                'parroquianom' => 'Catuaro',
                'municipioid' => 232,
            ],
            [
                'parroquiaid' => 765,
                'parroquianom' => 'Rendon',
                'municipioid' => 232,
            ],
            [
                'parroquiaid' => 766,
                'parroquianom' => 'Santa Cruz',
                'municipioid' => 232,
            ],
            [
                'parroquiaid' => 767,
                'parroquianom' => 'Santa Maria',
                'municipioid' => 232,
            ],
            [
                'parroquiaid' => 768,
                'parroquianom' => 'Altagracia',
                'municipioid' => 233,
            ],
            [
                'parroquiaid' => 769,
                'parroquianom' => 'Ayacucho',
                'municipioid' => 233,
            ],
            [
                'parroquiaid' => 770,
                'parroquianom' => 'Santa Ines',
                'municipioid' => 233,
            ],
            [
                'parroquiaid' => 771,
                'parroquianom' => 'Valentin Valiente',
                'municipioid' => 233,
            ],
            [
                'parroquiaid' => 772,
                'parroquianom' => 'San Juan',
                'municipioid' => 233,
            ],
            [
                'parroquiaid' => 773,
                'parroquianom' => 'Gran Mariscal',
                'municipioid' => 233,
            ],
            [
                'parroquiaid' => 774,
                'parroquianom' => 'Raul Leoni',
                'municipioid' => 233,
            ],
            [
                'parroquiaid' => 775,
                'parroquianom' => 'Guiria',
                'municipioid' => 234,
            ],
            [
                'parroquiaid' => 776,
                'parroquianom' => 'Cristobal Colon',
                'municipioid' => 234,
            ],
            [
                'parroquiaid' => 777,
                'parroquianom' => 'Punta De Piedra',
                'municipioid' => 234,
            ],
            [
                'parroquiaid' => 778,
                'parroquianom' => 'Bideau',
                'municipioid' => 234,
            ],
            [
                'parroquiaid' => 779,
                'parroquianom' => 'Mariño',
                'municipioid' => 235,
            ],
            [
                'parroquiaid' => 780,
                'parroquianom' => 'Romulo Gallegos',
                'municipioid' => 235,
            ],
            [
                'parroquiaid' => 781,
                'parroquianom' => 'Tunapuy',
                'municipioid' => 236,
            ],
            [
                'parroquiaid' => 782,
                'parroquianom' => 'Campo Elias',
                'municipioid' => 236,
            ],
            [
                'parroquiaid' => 783,
                'parroquianom' => 'San Jose De Areocuar',
                'municipioid' => 237,
            ],
            [
                'parroquiaid' => 784,
                'parroquianom' => 'Tavera Acosta',
                'municipioid' => 237,
            ],
            [
                'parroquiaid' => 785,
                'parroquianom' => 'Cm. Mariguitar',
                'municipioid' => 238,
            ],
            [
                'parroquiaid' => 786,
                'parroquianom' => 'Araya',
                'municipioid' => 239,
            ],
            [
                'parroquiaid' => 787,
                'parroquianom' => 'Manicuare',
                'municipioid' => 239,
            ],
            [
                'parroquiaid' => 788,
                'parroquianom' => 'Chacopata',
                'municipioid' => 239,
            ],
            [
                'parroquiaid' => 789,
                'parroquianom' => 'Cm. Colon',
                'municipioid' => 240,
            ],
            [
                'parroquiaid' => 790,
                'parroquianom' => 'Rivas Berti',
                'municipioid' => 240,
            ],
            [
                'parroquiaid' => 791,
                'parroquianom' => 'San Pedro Del Rio',
                'municipioid' => 240,
            ],
            [
                'parroquiaid' => 792,
                'parroquianom' => 'Cm. San Ant Del Tachira',
                'municipioid' => 241,
            ],
            [
                'parroquiaid' => 793,
                'parroquianom' => 'Palotal',
                'municipioid' => 241,
            ],
            [
                'parroquiaid' => 794,
                'parroquianom' => 'Juan Vicente Gomez',
                'municipioid' => 241,
            ],
            [
                'parroquiaid' => 795,
                'parroquianom' => 'Isaias Medina Angarit',
                'municipioid' => 241,
            ],
            [
                'parroquiaid' => 796,
                'parroquianom' => 'Cm. Capacho Nuevo',
                'municipioid' => 242,
            ],
            [
                'parroquiaid' => 797,
                'parroquianom' => 'Juan German Roscio',
                'municipioid' => 242,
            ],
            [
                'parroquiaid' => 798,
                'parroquianom' => 'Roman Cardenas',
                'municipioid' => 242,
            ],
            [
                'parroquiaid' => 799,
                'parroquianom' => 'Cm. Tariba',
                'municipioid' => 243,
            ],
            [
                'parroquiaid' => 800,
                'parroquianom' => 'La Florida',
                'municipioid' => 243,
            ],
        ]);

        $this->db->table('sgc_parroquias')->insertBatch([
            [
                'parroquiaid' => 801,
                'parroquianom' => 'Amenodoro Rangel Lamu',
                'municipioid' => 243,
            ],
            [
                'parroquiaid' => 802,
                'parroquianom' => 'Cm. La Grita',
                'municipioid' => 244,
            ],
            [
                'parroquiaid' => 803,
                'parroquianom' => 'Emilio C. Guerrero',
                'municipioid' => 244,
            ],
            [
                'parroquiaid' => 804,
                'parroquianom' => 'Mons. Miguel A Salas',
                'municipioid' => 244,
            ],
            [
                'parroquiaid' => 805,
                'parroquianom' => 'Cm. Rubio',
                'municipioid' => 245,
            ],
            [
                'parroquiaid' => 806,
                'parroquianom' => 'Bramon',
                'municipioid' => 245,
            ],
            [
                'parroquiaid' => 807,
                'parroquianom' => 'La Petrolea',
                'municipioid' => 245,
            ],
            [
                'parroquiaid' => 808,
                'parroquianom' => 'Quinimari',
                'municipioid' => 245,
            ],
            [
                'parroquiaid' => 809,
                'parroquianom' => 'Cm. Lobatera',
                'municipioid' => 246,
            ],
            [
                'parroquiaid' => 810,
                'parroquianom' => 'Constitucion',
                'municipioid' => 246,
            ],
            [
                'parroquiaid' => 811,
                'parroquianom' => 'La Concordia',
                'municipioid' => 247,
            ],
            [
                'parroquiaid' => 812,
                'parroquianom' => 'Pedro Maria Morantes',
                'municipioid' => 247,
            ],
            [
                'parroquiaid' => 813,
                'parroquianom' => 'Sn Juan Bautista',
                'municipioid' => 247,
            ],
            [
                'parroquiaid' => 814,
                'parroquianom' => 'San Sebastian',
                'municipioid' => 247,
            ],
            [
                'parroquiaid' => 815,
                'parroquianom' => 'Dr. Fco. Romero Lobo',
                'municipioid' => 247,
            ],
            [
                'parroquiaid' => 816,
                'parroquianom' => 'Cm. Pregonero',
                'municipioid' => 248,
            ],
            [
                'parroquiaid' => 817,
                'parroquianom' => 'Cardenas',
                'municipioid' => 248,
            ],
            [
                'parroquiaid' => 818,
                'parroquianom' => 'Potosi',
                'municipioid' => 248,
            ],
            [
                'parroquiaid' => 819,
                'parroquianom' => 'Juan Pablo Peñaloza',
                'municipioid' => 248,
            ],
            [
                'parroquiaid' => 820,
                'parroquianom' => 'Cm. Sta. Ana  Del Tachira',
                'municipioid' => 249,
            ],
            [
                'parroquiaid' => 821,
                'parroquianom' => 'Cm. La Fria',
                'municipioid' => 250,
            ],
            [
                'parroquiaid' => 822,
                'parroquianom' => 'Boca De Grita',
                'municipioid' => 250,
            ],
            [
                'parroquiaid' => 823,
                'parroquianom' => 'Jose Antonio Paez',
                'municipioid' => 250,
            ],
            [
                'parroquiaid' => 824,
                'parroquianom' => 'Cm. Palmira',
                'municipioid' => 251,
            ],
            [
                'parroquiaid' => 825,
                'parroquianom' => 'Cm. Michelena',
                'municipioid' => 252,
            ],
            [
                'parroquiaid' => 826,
                'parroquianom' => 'Cm. Abejales',
                'municipioid' => 253,
            ],
            [
                'parroquiaid' => 827,
                'parroquianom' => 'San Joaquin De Navay',
                'municipioid' => 253,
            ],
            [
                'parroquiaid' => 828,
                'parroquianom' => 'Doradas',
                'municipioid' => 253,
            ],
            [
                'parroquiaid' => 829,
                'parroquianom' => 'Emeterio Ochoa',
                'municipioid' => 253,
            ],
            [
                'parroquiaid' => 830,
                'parroquianom' => 'Cm. Coloncito',
                'municipioid' => 254,
            ],
            [
                'parroquiaid' => 831,
                'parroquianom' => 'La Palmita',
                'municipioid' => 254,
            ],
            [
                'parroquiaid' => 832,
                'parroquianom' => 'Cm. Ureña',
                'municipioid' => 255,
            ],
            [
                'parroquiaid' => 833,
                'parroquianom' => 'Nueva Arcadia',
                'municipioid' => 255,
            ],
            [
                'parroquiaid' => 834,
                'parroquianom' => 'Cm. Queniquea',
                'municipioid' => 256,
            ],
            [
                'parroquiaid' => 835,
                'parroquianom' => 'San Pablo',
                'municipioid' => 256,
            ],
            [
                'parroquiaid' => 836,
                'parroquianom' => 'Eleazar Lopez Contrera',
                'municipioid' => 256,
            ],
            [
                'parroquiaid' => 837,
                'parroquianom' => 'Cm. Cordero',
                'municipioid' => 257,
            ],
            [
                'parroquiaid' => 838,
                'parroquianom' => 'Cm.San Rafael Del Pinal',
                'municipioid' => 258,
            ],
            [
                'parroquiaid' => 839,
                'parroquianom' => 'Santo Domingo',
                'municipioid' => 258,
            ],
            [
                'parroquiaid' => 840,
                'parroquianom' => 'Alberto Adriani',
                'municipioid' => 258,
            ],
            [
                'parroquiaid' => 841,
                'parroquianom' => 'Cm. Capacho Viejo',
                'municipioid' => 259,
            ],
            [
                'parroquiaid' => 842,
                'parroquianom' => 'Cipriano Castro',
                'municipioid' => 259,
            ],
            [
                'parroquiaid' => 843,
                'parroquianom' => 'Manuel Felipe Rugeles',
                'municipioid' => 259,
            ],
            [
                'parroquiaid' => 844,
                'parroquianom' => 'Cm. La Tendida',
                'municipioid' => 260,
            ],
            [
                'parroquiaid' => 845,
                'parroquianom' => 'Bocono',
                'municipioid' => 260,
            ],
            [
                'parroquiaid' => 846,
                'parroquianom' => 'Hernandez',
                'municipioid' => 260,
            ],
            [
                'parroquiaid' => 847,
                'parroquianom' => 'Cm. Seboruco',
                'municipioid' => 261,
            ],
            [
                'parroquiaid' => 848,
                'parroquianom' => 'Cm. Las Mesas',
                'municipioid' => 262,
            ],
            [
                'parroquiaid' => 849,
                'parroquianom' => 'Cm. San Jose De Bolivar',
                'municipioid' => 263,
            ],
            [
                'parroquiaid' => 850,
                'parroquianom' => 'Cm. El Cobre',
                'municipioid' => 264,
            ],
        ]);

        $this->db->table('sgc_parroquias')->insertBatch([
            [
                'parroquiaid' => 851,
                'parroquianom' => 'Cm. Delicias',
                'municipioid' => 265,
            ],
            [
                'parroquiaid' => 852,
                'parroquianom' => 'Cm. San Simon',
                'municipioid' => 266,
            ],
            [
                'parroquiaid' => 853,
                'parroquianom' => 'Cm. San Josecito',
                'municipioid' => 267,
            ],
            [
                'parroquiaid' => 854,
                'parroquianom' => 'Cm. Umuquena',
                'municipioid' => 268,
            ],
            [
                'parroquiaid' => 855,
                'parroquianom' => 'Betijoque',
                'municipioid' => 269,
            ],
            [
                'parroquiaid' => 856,
                'parroquianom' => 'Jose G Hernandez',
                'municipioid' => 269,
            ],
            [
                'parroquiaid' => 857,
                'parroquianom' => 'La Pueblita',
                'municipioid' => 269,
            ],
            [
                'parroquiaid' => 858,
                'parroquianom' => 'El Cedro',
                'municipioid' => 269,
            ],
            [
                'parroquiaid' => 859,
                'parroquianom' => 'Bocono',
                'municipioid' => 270,
            ],
            [
                'parroquiaid' => 860,
                'parroquianom' => 'El Carmen',
                'municipioid' => 270,
            ],
            [
                'parroquiaid' => 861,
                'parroquianom' => 'Mosquey',
                'municipioid' => 270,
            ],
            [
                'parroquiaid' => 862,
                'parroquianom' => 'Ayacucho',
                'municipioid' => 270,
            ],
            [
                'parroquiaid' => 863,
                'parroquianom' => 'Burbusay',
                'municipioid' => 270,
            ],
            [
                'parroquiaid' => 864,
                'parroquianom' => 'General Rivas',
                'municipioid' => 270,
            ],
            [
                'parroquiaid' => 865,
                'parroquianom' => 'Monseñor Jauregui',
                'municipioid' => 270,
            ],
            [
                'parroquiaid' => 866,
                'parroquianom' => 'Rafael Rangel',
                'municipioid' => 270,
            ],
            [
                'parroquiaid' => 867,
                'parroquianom' => 'San Jose',
                'municipioid' => 270,
            ],
            [
                'parroquiaid' => 868,
                'parroquianom' => 'San Miguel',
                'municipioid' => 270,
            ],
            [
                'parroquiaid' => 869,
                'parroquianom' => 'Guaramacal',
                'municipioid' => 270,
            ],
            [
                'parroquiaid' => 870,
                'parroquianom' => 'La Vega De Guaramacal',
                'municipioid' => 270,
            ],
            [
                'parroquiaid' => 871,
                'parroquianom' => 'Carache',
                'municipioid' => 271,
            ],
            [
                'parroquiaid' => 872,
                'parroquianom' => 'La Concepcion',
                'municipioid' => 271,
            ],
            [
                'parroquiaid' => 873,
                'parroquianom' => 'Cuicas',
                'municipioid' => 271,
            ],
            [
                'parroquiaid' => 874,
                'parroquianom' => 'Panamericana',
                'municipioid' => 271,
            ],
            [
                'parroquiaid' => 875,
                'parroquianom' => 'Santa Cruz',
                'municipioid' => 271,
            ],
            [
                'parroquiaid' => 876,
                'parroquianom' => 'Escuque',
                'municipioid' => 272,
            ],
            [
                'parroquiaid' => 877,
                'parroquianom' => 'Sabana Libre',
                'municipioid' => 272,
            ],
            [
                'parroquiaid' => 878,
                'parroquianom' => 'La Union',
                'municipioid' => 272,
            ],
            [
                'parroquiaid' => 879,
                'parroquianom' => 'Santa Rita',
                'municipioid' => 272,
            ],
            [
                'parroquiaid' => 880,
                'parroquianom' => 'Cristobal Mendoza',
                'municipioid' => 273,
            ],
            [
                'parroquiaid' => 881,
                'parroquianom' => 'Chiquinquira',
                'municipioid' => 273,
            ],
            [
                'parroquiaid' => 882,
                'parroquianom' => 'Matriz',
                'municipioid' => 273,
            ],
            [
                'parroquiaid' => 883,
                'parroquianom' => 'Monseñor Carrillo',
                'municipioid' => 273,
            ],
            [
                'parroquiaid' => 884,
                'parroquianom' => 'Cruz Carrillo',
                'municipioid' => 273,
            ],
            [
                'parroquiaid' => 885,
                'parroquianom' => 'Andres Linares',
                'municipioid' => 273,
            ],
            [
                'parroquiaid' => 886,
                'parroquianom' => 'Tres Esquinas',
                'municipioid' => 273,
            ],
            [
                'parroquiaid' => 887,
                'parroquianom' => 'La Quebrada',
                'municipioid' => 274,
            ],
            [
                'parroquiaid' => 888,
                'parroquianom' => 'Jajo',
                'municipioid' => 274,
            ],
            [
                'parroquiaid' => 889,
                'parroquianom' => 'La Mesa',
                'municipioid' => 274,
            ],
            [
                'parroquiaid' => 890,
                'parroquianom' => 'Santiago',
                'municipioid' => 274,
            ],
            [
                'parroquiaid' => 891,
                'parroquianom' => 'Cabimbu',
                'municipioid' => 274,
            ],
            [
                'parroquiaid' => 892,
                'parroquianom' => 'Tuñame',
                'municipioid' => 274,
            ],
            [
                'parroquiaid' => 893,
                'parroquianom' => 'Mercedes Diaz',
                'municipioid' => 275,
            ],
            [
                'parroquiaid' => 894,
                'parroquianom' => 'Juan Ignacio Montilla',
                'municipioid' => 275,
            ],
            [
                'parroquiaid' => 895,
                'parroquianom' => 'La Beatriz',
                'municipioid' => 275,
            ],
            [
                'parroquiaid' => 896,
                'parroquianom' => 'Mendoza',
                'municipioid' => 275,
            ],
            [
                'parroquiaid' => 897,
                'parroquianom' => 'La Puerta',
                'municipioid' => 275,
            ],
            [
                'parroquiaid' => 898,
                'parroquianom' => 'San Luis',
                'municipioid' => 275,
            ],
            [
                'parroquiaid' => 899,
                'parroquianom' => 'Chejende',
                'municipioid' => 276,
            ],
            [
                'parroquiaid' => 900,
                'parroquianom' => 'Carrillo',
                'municipioid' => 276,
            ],
        ]);

        $this->db->table('sgc_parroquias')->insertBatch([
            [
                'parroquiaid' => 901,
                'parroquianom' => 'Cegarra',
                'municipioid' => 276,
            ],
            [
                'parroquiaid' => 902,
                'parroquianom' => 'Bolivia',
                'municipioid' => 276,
            ],
            [
                'parroquiaid' => 903,
                'parroquianom' => 'Manuel Salvador Ulloa',
                'municipioid' => 276,
            ],
            [
                'parroquiaid' => 904,
                'parroquianom' => 'San Jose',
                'municipioid' => 276,
            ],
            [
                'parroquiaid' => 905,
                'parroquianom' => 'Arnoldo Gabaldon',
                'municipioid' => 276,
            ],
            [
                'parroquiaid' => 906,
                'parroquianom' => 'El Dividive',
                'municipioid' => 277,
            ],
            [
                'parroquiaid' => 907,
                'parroquianom' => 'Agua Caliente',
                'municipioid' => 277,
            ],
            [
                'parroquiaid' => 908,
                'parroquianom' => 'El Cenizo',
                'municipioid' => 277,
            ],
            [
                'parroquiaid' => 909,
                'parroquianom' => 'Agua Santa',
                'municipioid' => 277,
            ],
            [
                'parroquiaid' => 910,
                'parroquianom' => 'Valerita',
                'municipioid' => 277,
            ],
            [
                'parroquiaid' => 911,
                'parroquianom' => 'Monte Carmelo',
                'municipioid' => 278,
            ],
            [
                'parroquiaid' => 912,
                'parroquianom' => 'Buena Vista',
                'municipioid' => 278,
            ],
            [
                'parroquiaid' => 913,
                'parroquianom' => 'Sta Maria Del Horcon',
                'municipioid' => 278,
            ],
            [
                'parroquiaid' => 914,
                'parroquianom' => 'Motatan',
                'municipioid' => 279,
            ],
            [
                'parroquiaid' => 915,
                'parroquianom' => 'El Baño',
                'municipioid' => 279,
            ],
            [
                'parroquiaid' => 916,
                'parroquianom' => 'Jalisco',
                'municipioid' => 279,
            ],
            [
                'parroquiaid' => 917,
                'parroquianom' => 'Pampan',
                'municipioid' => 280,
            ],
            [
                'parroquiaid' => 918,
                'parroquianom' => 'Santa Ana',
                'municipioid' => 280,
            ],
            [
                'parroquiaid' => 919,
                'parroquianom' => 'La Paz',
                'municipioid' => 280,
            ],
            [
                'parroquiaid' => 920,
                'parroquianom' => 'Flor De Patria',
                'municipioid' => 280,
            ],
            [
                'parroquiaid' => 921,
                'parroquianom' => 'Carvajal',
                'municipioid' => 281,
            ],
            [
                'parroquiaid' => 922,
                'parroquianom' => 'Antonio N Briceño',
                'municipioid' => 281,
            ],
            [
                'parroquiaid' => 923,
                'parroquianom' => 'Campo Alegre',
                'municipioid' => 281,
            ],
            [
                'parroquiaid' => 924,
                'parroquianom' => 'Jose Leonardo Suarez',
                'municipioid' => 281,
            ],
            [
                'parroquiaid' => 925,
                'parroquianom' => 'Sabana De Mendoza',
                'municipioid' => 282,
            ],
            [
                'parroquiaid' => 926,
                'parroquianom' => 'Junin',
                'municipioid' => 282,
            ],
            [
                'parroquiaid' => 927,
                'parroquianom' => 'Valmore Rodriguez',
                'municipioid' => 282,
            ],
            [
                'parroquiaid' => 928,
                'parroquianom' => 'El Paraiso',
                'municipioid' => 282,
            ],
            [
                'parroquiaid' => 929,
                'parroquianom' => 'Santa Isabel',
                'municipioid' => 283,
            ],
            [
                'parroquiaid' => 930,
                'parroquianom' => 'Araguaney',
                'municipioid' => 283,
            ],
            [
                'parroquiaid' => 931,
                'parroquianom' => 'El Jaguito',
                'municipioid' => 283,
            ],
            [
                'parroquiaid' => 932,
                'parroquianom' => 'La Esperanza',
                'municipioid' => 283,
            ],
            [
                'parroquiaid' => 933,
                'parroquianom' => 'Sabana Grande',
                'municipioid' => 284,
            ],
            [
                'parroquiaid' => 934,
                'parroquianom' => 'Cheregue',
                'municipioid' => 284,
            ],
            [
                'parroquiaid' => 935,
                'parroquianom' => 'Granados',
                'municipioid' => 284,
            ],
            [
                'parroquiaid' => 936,
                'parroquianom' => 'El Socorro',
                'municipioid' => 285,
            ],
            [
                'parroquiaid' => 937,
                'parroquianom' => 'Los Caprichos',
                'municipioid' => 285,
            ],
            [
                'parroquiaid' => 938,
                'parroquianom' => 'Antonio Jose De Sucre',
                'municipioid' => 285,
            ],
            [
                'parroquiaid' => 939,
                'parroquianom' => 'Campo Elias',
                'municipioid' => 286,
            ],
            [
                'parroquiaid' => 940,
                'parroquianom' => 'Arnoldo Gabaldon',
                'municipioid' => 286,
            ],
            [
                'parroquiaid' => 941,
                'parroquianom' => 'Santa Apolonia',
                'municipioid' => 287,
            ],
            [
                'parroquiaid' => 942,
                'parroquianom' => 'La Ceiba',
                'municipioid' => 287,
            ],
            [
                'parroquiaid' => 943,
                'parroquianom' => 'El Progreso',
                'municipioid' => 287,
            ],
            [
                'parroquiaid' => 944,
                'parroquianom' => 'Tres De Febrero',
                'municipioid' => 287,
            ],
            [
                'parroquiaid' => 945,
                'parroquianom' => 'Pampanito',
                'municipioid' => 288,
            ],
            [
                'parroquiaid' => 946,
                'parroquianom' => 'Pampanito Ii',
                'municipioid' => 288,
            ],
            [
                'parroquiaid' => 947,
                'parroquianom' => 'La Concepcion',
                'municipioid' => 288,
            ],
            [
                'parroquiaid' => 948,
                'parroquianom' => 'Cm. Aroa',
                'municipioid' => 289,
            ],
            [
                'parroquiaid' => 949,
                'parroquianom' => 'Cm. Chivacoa',
                'municipioid' => 290,
            ],
            [
                'parroquiaid' => 950,
                'parroquianom' => 'Campo Elias',
                'municipioid' => 290,
            ],
        ]);

        $this->db->table('sgc_parroquias')->insertBatch([
            [
                'parroquiaid' => 951,
                'parroquianom' => 'Cm. Nirgua',
                'municipioid' => 291,
            ],
            [
                'parroquiaid' => 952,
                'parroquianom' => 'Salom',
                'municipioid' => 291,
            ],
            [
                'parroquiaid' => 953,
                'parroquianom' => 'Temerla',
                'municipioid' => 291,
            ],
            [
                'parroquiaid' => 954,
                'parroquianom' => 'Cm. San Felipe',
                'municipioid' => 292,
            ],
            [
                'parroquiaid' => 955,
                'parroquianom' => 'Albarico',
                'municipioid' => 292,
            ],
            [
                'parroquiaid' => 956,
                'parroquianom' => 'San Javier',
                'municipioid' => 292,
            ],
            [
                'parroquiaid' => 957,
                'parroquianom' => 'Cm. Guama',
                'municipioid' => 293,
            ],
            [
                'parroquiaid' => 958,
                'parroquianom' => 'Cm. Urachiche',
                'municipioid' => 294,
            ],
            [
                'parroquiaid' => 959,
                'parroquianom' => 'Cm. Yaritagua',
                'municipioid' => 295,
            ],
            [
                'parroquiaid' => 960,
                'parroquianom' => 'San Andres',
                'municipioid' => 295,
            ],
            [
                'parroquiaid' => 961,
                'parroquianom' => 'Cm. Sabana De Parra',
                'municipioid' => 296,
            ],
            [
                'parroquiaid' => 962,
                'parroquianom' => 'Cm. Boraure',
                'municipioid' => 297,
            ],
            [
                'parroquiaid' => 963,
                'parroquianom' => 'Cm. Cocorote',
                'municipioid' => 298,
            ],
            [
                'parroquiaid' => 964,
                'parroquianom' => 'Cm. Independencia',
                'municipioid' => 299,
            ],
            [
                'parroquiaid' => 965,
                'parroquianom' => 'Cm. San Pablo',
                'municipioid' => 300,
            ],
            [
                'parroquiaid' => 966,
                'parroquianom' => 'Cm. Yumare',
                'municipioid' => 301,
            ],
            [
                'parroquiaid' => 967,
                'parroquianom' => 'Cm. Farriar',
                'municipioid' => 302,
            ],
            [
                'parroquiaid' => 968,
                'parroquianom' => 'El Guayabo',
                'municipioid' => 302,
            ],
            [
                'parroquiaid' => 969,
                'parroquianom' => 'General Urdaneta',
                'municipioid' => 303,
            ],
            [
                'parroquiaid' => 970,
                'parroquianom' => 'Libertador',
                'municipioid' => 303,
            ],
            [
                'parroquiaid' => 971,
                'parroquianom' => 'Manuel Guanipa Matos',
                'municipioid' => 303,
            ],
            [
                'parroquiaid' => 972,
                'parroquianom' => 'Marcelino Briceño',
                'municipioid' => 303,
            ],
            [
                'parroquiaid' => 973,
                'parroquianom' => 'San Timoteo',
                'municipioid' => 303,
            ],
            [
                'parroquiaid' => 974,
                'parroquianom' => 'Pueblo Nuevo',
                'municipioid' => 303,
            ],
            [
                'parroquiaid' => 975,
                'parroquianom' => 'Pedro Lucas Urribarri',
                'municipioid' => 304,
            ],
            [
                'parroquiaid' => 976,
                'parroquianom' => 'Santa Rita',
                'municipioid' => 304,
            ],
            [
                'parroquiaid' => 977,
                'parroquianom' => 'Jose Cenovio Urribarr',
                'municipioid' => 304,
            ],
            [
                'parroquiaid' => 978,
                'parroquianom' => 'El Mene',
                'municipioid' => 304,
            ],
            [
                'parroquiaid' => 979,
                'parroquianom' => 'Santa Cruz Del Zulia',
                'municipioid' => 305,
            ],
            [
                'parroquiaid' => 980,
                'parroquianom' => 'Urribarri',
                'municipioid' => 305,
            ],
            [
                'parroquiaid' => 981,
                'parroquianom' => 'Moralito',
                'municipioid' => 305,
            ],
            [
                'parroquiaid' => 982,
                'parroquianom' => 'San Carlos Del Zulia',
                'municipioid' => 305,
            ],
            [
                'parroquiaid' => 983,
                'parroquianom' => 'Santa Barbara',
                'municipioid' => 305,
            ],
            [
                'parroquiaid' => 984,
                'parroquianom' => 'Luis De Vicente',
                'municipioid' => 306,
            ],
            [
                'parroquiaid' => 985,
                'parroquianom' => 'Ricaurte',
                'municipioid' => 306,
            ],
            [
                'parroquiaid' => 986,
                'parroquianom' => 'Mons.Marcos Sergio G',
                'municipioid' => 306,
            ],
            [
                'parroquiaid' => 987,
                'parroquianom' => 'San Rafael',
                'municipioid' => 306,
            ],
            [
                'parroquiaid' => 988,
                'parroquianom' => 'Las Parcelas',
                'municipioid' => 306,
            ],
            [
                'parroquiaid' => 989,
                'parroquianom' => 'Tamare',
                'municipioid' => 306,
            ],
            [
                'parroquiaid' => 990,
                'parroquianom' => 'La Sierrita',
                'municipioid' => 306,
            ],
            [
                'parroquiaid' => 991,
                'parroquianom' => 'Bolivar',
                'municipioid' => 307,
            ],
            [
                'parroquiaid' => 992,
                'parroquianom' => 'Coquivacoa',
                'municipioid' => 307,
            ],
            [
                'parroquiaid' => 993,
                'parroquianom' => 'Cristo De Aranza',
                'municipioid' => 307,
            ],
            [
                'parroquiaid' => 994,
                'parroquianom' => 'Chiquinquira',
                'municipioid' => 307,
            ],
            [
                'parroquiaid' => 995,
                'parroquianom' => 'Santa Lucia',
                'municipioid' => 307,
            ],
            [
                'parroquiaid' => 996,
                'parroquianom' => 'Olegario Villalobos',
                'municipioid' => 307,
            ],
            [
                'parroquiaid' => 997,
                'parroquianom' => 'Juana De Avila',
                'municipioid' => 307,
            ],
            [
                'parroquiaid' => 998,
                'parroquianom' => 'Caracciolo Parra Perez',
                'municipioid' => 307,
            ],
            [
                'parroquiaid' => 999,
                'parroquianom' => 'Idelfonzo Vasquez',
                'municipioid' => 307,
            ],
            [
                'parroquiaid' => 1000,
                'parroquianom' => 'Cacique Mara',
                'municipioid' => 307,
            ],
        ]);

        $this->db->table('sgc_parroquias')->insertBatch([
            [
                'parroquiaid' => 1001,
                'parroquianom' => 'Cecilio Acosta',
                'municipioid' => 307,
            ],
            [
                'parroquiaid' => 1002,
                'parroquianom' => 'Raul Leoni',
                'municipioid' => 307,
            ],
            [
                'parroquiaid' => 1003,
                'parroquianom' => 'Francisco Eugenio B',
                'municipioid' => 307,
            ],
            [
                'parroquiaid' => 1004,
                'parroquianom' => 'Manuel Dagnino',
                'municipioid' => 307,
            ],
            [
                'parroquiaid' => 1005,
                'parroquianom' => 'Luis Hurtado Higuera',
                'municipioid' => 307,
            ],
            [
                'parroquiaid' => 1006,
                'parroquianom' => 'Venancio Pulgar',
                'municipioid' => 307,
            ],
            [
                'parroquiaid' => 1007,
                'parroquianom' => 'Antonio Borjas Romero',
                'municipioid' => 307,
            ],
            [
                'parroquiaid' => 1008,
                'parroquianom' => 'San Isidro',
                'municipioid' => 307,
            ],
            [
                'parroquiaid' => 1009,
                'parroquianom' => 'Faria',
                'municipioid' => 308,
            ],
            [
                'parroquiaid' => 1010,
                'parroquianom' => 'San Antonio',
                'municipioid' => 308,
            ],
            [
                'parroquiaid' => 1011,
                'parroquianom' => 'Ana Maria Campos',
                'municipioid' => 308,
            ],
            [
                'parroquiaid' => 1012,
                'parroquianom' => 'San Jose',
                'municipioid' => 308,
            ],
            [
                'parroquiaid' => 1013,
                'parroquianom' => 'Altagracia',
                'municipioid' => 308,
            ],
            [
                'parroquiaid' => 1014,
                'parroquianom' => 'Goajira',
                'municipioid' => 309,
            ],
            [
                'parroquiaid' => 1015,
                'parroquianom' => 'Elias Sanchez Rubio',
                'municipioid' => 309,
            ],
            [
                'parroquiaid' => 1016,
                'parroquianom' => 'Sinamaica',
                'municipioid' => 309,
            ],
            [
                'parroquiaid' => 1017,
                'parroquianom' => 'Alta Guajira',
                'municipioid' => 309,
            ],
            [
                'parroquiaid' => 1018,
                'parroquianom' => 'San Jose De Perija',
                'municipioid' => 310,
            ],
            [
                'parroquiaid' => 1019,
                'parroquianom' => 'Bartolome De Las Casas',
                'municipioid' => 310,
            ],
            [
                'parroquiaid' => 1020,
                'parroquianom' => 'Libertad',
                'municipioid' => 310,
            ],
            [
                'parroquiaid' => 1021,
                'parroquianom' => 'Rio Negro',
                'municipioid' => 310,
            ],
            [
                'parroquiaid' => 1022,
                'parroquianom' => 'Gibraltar',
                'municipioid' => 311,
            ],
            [
                'parroquiaid' => 1023,
                'parroquianom' => 'Heras',
                'municipioid' => 311,
            ],
            [
                'parroquiaid' => 1024,
                'parroquianom' => 'M.Arturo Celestino A',
                'municipioid' => 311,
            ],
            [
                'parroquiaid' => 1025,
                'parroquianom' => 'Romulo Gallegos',
                'municipioid' => 311,
            ],
            [
                'parroquiaid' => 1026,
                'parroquianom' => 'Bobures',
                'municipioid' => 311,
            ],
            [
                'parroquiaid' => 1027,
                'parroquianom' => 'El Batey',
                'municipioid' => 311,
            ],
            [
                'parroquiaid' => 1028,
                'parroquianom' => 'Andres Bello (KM 48)',
                'municipioid' => 312,
            ],
            [
                'parroquiaid' => 1029,
                'parroquianom' => 'Potreritos',
                'municipioid' => 312,
            ],
            [
                'parroquiaid' => 1030,
                'parroquianom' => 'El Carmelo',
                'municipioid' => 312,
            ],
            [
                'parroquiaid' => 1031,
                'parroquianom' => 'Chiquinquira',
                'municipioid' => 312,
            ],
            [
                'parroquiaid' => 1032,
                'parroquianom' => 'Concepcion',
                'municipioid' => 312,
            ],
            [
                'parroquiaid' => 1033,
                'parroquianom' => 'Eleazar Lopez C',
                'municipioid' => 313,
            ],
            [
                'parroquiaid' => 1034,
                'parroquianom' => 'Alonso De Ojeda',
                'municipioid' => 313,
            ],
            [
                'parroquiaid' => 1035,
                'parroquianom' => 'Venezuela',
                'municipioid' => 313,
            ],
            [
                'parroquiaid' => 1036,
                'parroquianom' => 'Campo Lara',
                'municipioid' => 313,
            ],
            [
                'parroquiaid' => 1037,
                'parroquianom' => 'Libertad',
                'municipioid' => 313,
            ],
            [
                'parroquiaid' => 1038,
                'parroquianom' => 'Udon Perez',
                'municipioid' => 314,
            ],
            [
                'parroquiaid' => 1039,
                'parroquianom' => 'Encontrados',
                'municipioid' => 314,
            ],
            [
                'parroquiaid' => 1040,
                'parroquianom' => 'Donaldo Garcia',
                'municipioid' => 315,
            ],
            [
                'parroquiaid' => 1041,
                'parroquianom' => 'Sixto Zambrano',
                'municipioid' => 315,
            ],
            [
                'parroquiaid' => 1042,
                'parroquianom' => 'El Rosario',
                'municipioid' => 315,
            ],
            [
                'parroquiaid' => 1043,
                'parroquianom' => 'Ambrosio',
                'municipioid' => 316,
            ],
            [
                'parroquiaid' => 1044,
                'parroquianom' => 'German Rios Linares',
                'municipioid' => 316,
            ],
            [
                'parroquiaid' => 1045,
                'parroquianom' => 'Jorge Hernandez',
                'municipioid' => 316,
            ],
            [
                'parroquiaid' => 1046,
                'parroquianom' => 'La Rosa',
                'municipioid' => 316,
            ],
            [
                'parroquiaid' => 1047,
                'parroquianom' => 'Punta Gorda',
                'municipioid' => 316,
            ],
            [
                'parroquiaid' => 1048,
                'parroquianom' => 'Carmen Herrera',
                'municipioid' => 316,
            ],
            [
                'parroquiaid' => 1049,
                'parroquianom' => 'San Benito',
                'municipioid' => 316,
            ],
            [
                'parroquiaid' => 1050,
                'parroquianom' => 'Romulo Betancourt',
                'municipioid' => 316,
            ],
        ]);

        $this->db->table('sgc_parroquias')->insertBatch([
            [
                'parroquiaid' => 1051,
                'parroquianom' => 'Aristides Calvani',
                'municipioid' => 316,
            ],
            [
                'parroquiaid' => 1052,
                'parroquianom' => 'Raul Cuenca',
                'municipioid' => 317,
            ],
            [
                'parroquiaid' => 1053,
                'parroquianom' => 'La Victoria',
                'municipioid' => 317,
            ],
            [
                'parroquiaid' => 1054,
                'parroquianom' => 'Rafael Urdaneta',
                'municipioid' => 317,
            ],
            [
                'parroquiaid' => 1055,
                'parroquianom' => 'Jose Ramon Yepez',
                'municipioid' => 318,
            ],
            [
                'parroquiaid' => 1056,
                'parroquianom' => 'La Concepcion',
                'municipioid' => 318,
            ],
            [
                'parroquiaid' => 1057,
                'parroquianom' => 'San Jose',
                'municipioid' => 318,
            ],
            [
                'parroquiaid' => 1058,
                'parroquianom' => 'Mariano Parra Leon',
                'municipioid' => 318,
            ],
            [
                'parroquiaid' => 1059,
                'parroquianom' => 'Monagas',
                'municipioid' => 319,
            ],
            [
                'parroquiaid' => 1060,
                'parroquianom' => 'Isla De Toas',
                'municipioid' => 319,
            ],
            [
                'parroquiaid' => 1061,
                'parroquianom' => 'Marcial Hernandez',
                'municipioid' => 320,
            ],
            [
                'parroquiaid' => 1062,
                'parroquianom' => 'Francisco Ochoa',
                'municipioid' => 320,
            ],
            [
                'parroquiaid' => 1063,
                'parroquianom' => 'San Francisco',
                'municipioid' => 320,
            ],
            [
                'parroquiaid' => 1064,
                'parroquianom' => 'El Bajo',
                'municipioid' => 320,
            ],
            [
                'parroquiaid' => 1065,
                'parroquianom' => 'Domitila Flores',
                'municipioid' => 320,
            ],
            [
                'parroquiaid' => 1066,
                'parroquianom' => 'Los Cortijos',
                'municipioid' => 320,
            ],
            [
                'parroquiaid' => 1067,
                'parroquianom' => 'Bari',
                'municipioid' => 321,
            ],
            [
                'parroquiaid' => 1068,
                'parroquianom' => 'Jesus M Semprun',
                'municipioid' => 321,
            ],
            [
                'parroquiaid' => 1069,
                'parroquianom' => 'Simon Rodriguez',
                'municipioid' => 322,
            ],
            [
                'parroquiaid' => 1070,
                'parroquianom' => 'Carlos Quevedo',
                'municipioid' => 322,
            ],
            [
                'parroquiaid' => 1071,
                'parroquianom' => 'Francisco J Pulgar',
                'municipioid' => 322,
            ],
            [
                'parroquiaid' => 1072,
                'parroquianom' => 'Rafael Maria Baralt',
                'municipioid' => 323,
            ],
            [
                'parroquiaid' => 1073,
                'parroquianom' => 'Manuel Manrique',
                'municipioid' => 323,
            ],
            [
                'parroquiaid' => 1074,
                'parroquianom' => 'Rafael Urdaneta',
                'municipioid' => 323,
            ],
            [
                'parroquiaid' => 1075,
                'parroquianom' => 'Fernando Giron Tovar',
                'municipioid' => 324,
            ],
            [
                'parroquiaid' => 1076,
                'parroquianom' => 'Luis Alberto Gomez',
                'municipioid' => 324,
            ],
            [
                'parroquiaid' => 1077,
                'parroquianom' => 'Parhueña',
                'municipioid' => 324,
            ],
            [
                'parroquiaid' => 1078,
                'parroquianom' => 'Platanillal',
                'municipioid' => 324,
            ],
            [
                'parroquiaid' => 1079,
                'parroquianom' => 'Cm. San Fernando De Ataba',
                'municipioid' => 325,
            ],
            [
                'parroquiaid' => 1080,
                'parroquianom' => 'Ucata',
                'municipioid' => 325,
            ],
            [
                'parroquiaid' => 1081,
                'parroquianom' => 'Yapacana',
                'municipioid' => 325,
            ],
            [
                'parroquiaid' => 1082,
                'parroquianom' => 'Caname',
                'municipioid' => 325,
            ],
            [
                'parroquiaid' => 1083,
                'parroquianom' => 'Cm. Maroa',
                'municipioid' => 326,
            ],
            [
                'parroquiaid' => 1084,
                'parroquianom' => 'Victorino',
                'municipioid' => 326,
            ],
            [
                'parroquiaid' => 1085,
                'parroquianom' => 'Comunidad',
                'municipioid' => 326,
            ],
            [
                'parroquiaid' => 1086,
                'parroquianom' => 'Cm. San Carlos De Rio Neg',
                'municipioid' => 327,
            ],
            [
                'parroquiaid' => 1087,
                'parroquianom' => 'Solano',
                'municipioid' => 327,
            ],
            [
                'parroquiaid' => 1088,
                'parroquianom' => 'Cocuy',
                'municipioid' => 327,
            ],
            [
                'parroquiaid' => 1089,
                'parroquianom' => 'Cm. Isla De Raton',
                'municipioid' => 328,
            ],
            [
                'parroquiaid' => 1090,
                'parroquianom' => 'Samariapo',
                'municipioid' => 328,
            ],
            [
                'parroquiaid' => 1091,
                'parroquianom' => 'Sipapo',
                'municipioid' => 328,
            ],
            [
                'parroquiaid' => 1092,
                'parroquianom' => 'Munduapo',
                'municipioid' => 328,
            ],
            [
                'parroquiaid' => 1093,
                'parroquianom' => 'Guayapo',
                'municipioid' => 328,
            ],
            [
                'parroquiaid' => 1094,
                'parroquianom' => 'Cm. San Juan De Manapiare',
                'municipioid' => 329,
            ],
            [
                'parroquiaid' => 1095,
                'parroquianom' => 'Alto Ventuari',
                'municipioid' => 329,
            ],
            [
                'parroquiaid' => 1096,
                'parroquianom' => 'Medio Ventuari',
                'municipioid' => 329,
            ],
            [
                'parroquiaid' => 1097,
                'parroquianom' => 'Bajo Ventuari',
                'municipioid' => 329,
            ],
            [
                'parroquiaid' => 1098,
                'parroquianom' => 'Cm. La Esmeralda',
                'municipioid' => 330,
            ],
            [
                'parroquiaid' => 1099,
                'parroquianom' => 'Huachamacare',
                'municipioid' => 330,
            ],
            [
                'parroquiaid' => 1100,
                'parroquianom' => 'Marawaka',
                'municipioid' => 330,
            ],
        ]);

        $this->db->table('sgc_parroquias')->insertBatch([
            [
                'parroquiaid' => 1101,
                'parroquianom' => 'Mavaca',
                'municipioid' => 330,
            ],
            [
                'parroquiaid' => 1102,
                'parroquianom' => 'Sierra Parima',
                'municipioid' => 330,
            ],
            [
                'parroquiaid' => 1103,
                'parroquianom' => 'San Jose',
                'municipioid' => 331,
            ],
            [
                'parroquiaid' => 1104,
                'parroquianom' => 'Virgen Del Valle',
                'municipioid' => 331,
            ],
            [
                'parroquiaid' => 1105,
                'parroquianom' => 'San Rafael',
                'municipioid' => 331,
            ],
            [
                'parroquiaid' => 1106,
                'parroquianom' => 'Jose Vidal Marcano',
                'municipioid' => 331,
            ],
            [
                'parroquiaid' => 1107,
                'parroquianom' => 'Leonardo Ruiz Pineda',
                'municipioid' => 331,
            ],
            [
                'parroquiaid' => 1108,
                'parroquianom' => 'Mons. Argimiro Garcia',
                'municipioid' => 331,
            ],
            [
                'parroquiaid' => 1109,
                'parroquianom' => 'Mcl.Antonio J De Sucre',
                'municipioid' => 331,
            ],
            [
                'parroquiaid' => 1110,
                'parroquianom' => 'Juan Millan',
                'municipioid' => 331,
            ],
            [
                'parroquiaid' => 1111,
                'parroquianom' => 'Pedernales',
                'municipioid' => 332,
            ],
            [
                'parroquiaid' => 1112,
                'parroquianom' => 'Luis B Prieto Figuero',
                'municipioid' => 332,
            ],
            [
                'parroquiaid' => 1113,
                'parroquianom' => 'Curiapo',
                'municipioid' => 333,
            ],
            [
                'parroquiaid' => 1114,
                'parroquianom' => 'Santos De Abelgas',
                'municipioid' => 333,
            ],
            [
                'parroquiaid' => 1115,
                'parroquianom' => 'Manuel Renaud',
                'municipioid' => 333,
            ],
            [
                'parroquiaid' => 1116,
                'parroquianom' => 'Padre Barral',
                'municipioid' => 333,
            ],
            [
                'parroquiaid' => 1117,
                'parroquianom' => 'Aniceto Lugo',
                'municipioid' => 333,
            ],
            [
                'parroquiaid' => 1118,
                'parroquianom' => 'Almirante Luis Brion',
                'municipioid' => 333,
            ],
            [
                'parroquiaid' => 1119,
                'parroquianom' => 'Imataca',
                'municipioid' => 334,
            ],
            [
                'parroquiaid' => 1120,
                'parroquianom' => 'Romulo Gallegos',
                'municipioid' => 334,
            ],
            [
                'parroquiaid' => 1121,
                'parroquianom' => 'Juan Bautista Arismen',
                'municipioid' => 334,
            ],
            [
                'parroquiaid' => 1122,
                'parroquianom' => 'Manuel Piar',
                'municipioid' => 334,
            ],
            [
                'parroquiaid' => 1123,
                'parroquianom' => '5 De Julio',
                'municipioid' => 334,
            ],
            [
                'parroquiaid' => 1124,
                'parroquianom' => 'Caraballeda',
                'municipioid' => 335,
            ],
            [
                'parroquiaid' => 1125,
                'parroquianom' => 'Carayaca',
                'municipioid' => 335,
            ],
            [
                'parroquiaid' => 1126,
                'parroquianom' => 'Caruao',
                'municipioid' => 335,
            ],
            [
                'parroquiaid' => 1127,
                'parroquianom' => 'Catia La Mar',
                'municipioid' => 335,
            ],
            [
                'parroquiaid' => 1128,
                'parroquianom' => 'La Guaira',
                'municipioid' => 335,
            ],
            [
                'parroquiaid' => 1129,
                'parroquianom' => 'Macuto',
                'municipioid' => 335,
            ],
            [
                'parroquiaid' => 1130,
                'parroquianom' => 'Maiquetia',
                'municipioid' => 335,
            ],
            [
                'parroquiaid' => 1131,
                'parroquianom' => 'Naiguata',
                'municipioid' => 335,
            ],
            [
                'parroquiaid' => 1132,
                'parroquianom' => 'El Junko',
                'municipioid' => 335,
            ],
            [
                'parroquiaid' => 1133,
                'parroquianom' => 'Pq Raul Leoni',
                'municipioid' => 335,
            ],
            [
                'parroquiaid' => 1134,
                'parroquianom' => 'Pq Carlos Soublette',
                'municipioid' => 335,
            ],
            [
                'parroquiaid' => 1135,
                'parroquianom' => 'N/A',
                'municipioid' => 336,
            ],
        ]);

    }
}

<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Seeder for table: sgc_municipio (336 rows)
 * Generated from existing database data
 */
class MunicipioSeeder extends Seeder
{
    public function run()
    {
        $this->db->query('TRUNCATE TABLE sgc_municipio RESTART IDENTITY CASCADE');

        $this->db->table('sgc_municipio')->insertBatch([
            [
                'municipioid' => 1,
                'municipionom' => 'Libertador',
                'estadoid' => 24,
            ],
            [
                'municipioid' => 2,
                'municipionom' => 'Anaco',
                'estadoid' => 2,
            ],
            [
                'municipioid' => 3,
                'municipionom' => 'Aragua',
                'estadoid' => 2,
            ],
            [
                'municipioid' => 4,
                'municipionom' => 'Bolivar',
                'estadoid' => 2,
            ],
            [
                'municipioid' => 5,
                'municipionom' => 'Bruzual',
                'estadoid' => 2,
            ],
            [
                'municipioid' => 6,
                'municipionom' => 'Cajigal',
                'estadoid' => 2,
            ],
            [
                'municipioid' => 7,
                'municipionom' => 'Freites',
                'estadoid' => 2,
            ],
            [
                'municipioid' => 8,
                'municipionom' => 'Independencia',
                'estadoid' => 2,
            ],
            [
                'municipioid' => 9,
                'municipionom' => 'Libertad',
                'estadoid' => 2,
            ],
            [
                'municipioid' => 10,
                'municipionom' => 'Miranda',
                'estadoid' => 2,
            ],
            [
                'municipioid' => 11,
                'municipionom' => 'Monagas',
                'estadoid' => 2,
            ],
            [
                'municipioid' => 12,
                'municipionom' => 'Peñalver',
                'estadoid' => 2,
            ],
            [
                'municipioid' => 13,
                'municipionom' => 'Simon Rodriguez',
                'estadoid' => 2,
            ],
            [
                'municipioid' => 14,
                'municipionom' => 'Sotillo',
                'estadoid' => 2,
            ],
            [
                'municipioid' => 15,
                'municipionom' => 'Guanipa',
                'estadoid' => 2,
            ],
            [
                'municipioid' => 16,
                'municipionom' => 'Guanta',
                'estadoid' => 2,
            ],
            [
                'municipioid' => 17,
                'municipionom' => 'Piritu',
                'estadoid' => 2,
            ],
            [
                'municipioid' => 18,
                'municipionom' => 'M.L/Diego Bautista U',
                'estadoid' => 2,
            ],
            [
                'municipioid' => 19,
                'municipionom' => 'Carvajal',
                'estadoid' => 2,
            ],
            [
                'municipioid' => 20,
                'municipionom' => 'Santa Ana',
                'estadoid' => 2,
            ],
            [
                'municipioid' => 21,
                'municipionom' => 'Mc Gregor',
                'estadoid' => 2,
            ],
            [
                'municipioid' => 22,
                'municipionom' => 'S Juan Capistrano',
                'estadoid' => 2,
            ],
            [
                'municipioid' => 23,
                'municipionom' => 'Achaguas',
                'estadoid' => 3,
            ],
            [
                'municipioid' => 24,
                'municipionom' => 'Muñoz',
                'estadoid' => 3,
            ],
            [
                'municipioid' => 25,
                'municipionom' => 'Paez',
                'estadoid' => 3,
            ],
            [
                'municipioid' => 26,
                'municipionom' => 'Pedro Camejo',
                'estadoid' => 3,
            ],
            [
                'municipioid' => 27,
                'municipionom' => 'Romulo Gallegos',
                'estadoid' => 3,
            ],
            [
                'municipioid' => 28,
                'municipionom' => 'San Fernando',
                'estadoid' => 3,
            ],
            [
                'municipioid' => 29,
                'municipionom' => 'Biruaca',
                'estadoid' => 3,
            ],
            [
                'municipioid' => 30,
                'municipionom' => 'Girardot',
                'estadoid' => 4,
            ],
            [
                'municipioid' => 31,
                'municipionom' => 'Santiago Mariño',
                'estadoid' => 4,
            ],
            [
                'municipioid' => 32,
                'municipionom' => 'Jose Felix Rivas',
                'estadoid' => 4,
            ],
            [
                'municipioid' => 33,
                'municipionom' => 'San Casimiro',
                'estadoid' => 4,
            ],
            [
                'municipioid' => 34,
                'municipionom' => 'San Sebastian',
                'estadoid' => 4,
            ],
            [
                'municipioid' => 35,
                'municipionom' => 'Sucre',
                'estadoid' => 4,
            ],
            [
                'municipioid' => 36,
                'municipionom' => 'Urdaneta',
                'estadoid' => 4,
            ],
            [
                'municipioid' => 37,
                'municipionom' => 'Zamora',
                'estadoid' => 4,
            ],
            [
                'municipioid' => 38,
                'municipionom' => 'Libertador',
                'estadoid' => 4,
            ],
            [
                'municipioid' => 39,
                'municipionom' => 'Jose Angel Lamas',
                'estadoid' => 4,
            ],
            [
                'municipioid' => 40,
                'municipionom' => 'Bolivar',
                'estadoid' => 4,
            ],
            [
                'municipioid' => 41,
                'municipionom' => 'Santos Michelena',
                'estadoid' => 4,
            ],
            [
                'municipioid' => 42,
                'municipionom' => 'Mario B Iragorry',
                'estadoid' => 4,
            ],
            [
                'municipioid' => 43,
                'municipionom' => 'Tovar',
                'estadoid' => 4,
            ],
            [
                'municipioid' => 44,
                'municipionom' => 'Camatagua',
                'estadoid' => 4,
            ],
            [
                'municipioid' => 45,
                'municipionom' => 'Jose R Revenga',
                'estadoid' => 4,
            ],
            [
                'municipioid' => 46,
                'municipionom' => 'Francisco Linares A.',
                'estadoid' => 4,
            ],
            [
                'municipioid' => 47,
                'municipionom' => 'M.Ocumare D La Costa',
                'estadoid' => 4,
            ],
            [
                'municipioid' => 48,
                'municipionom' => 'Arismendi',
                'estadoid' => 5,
            ],
            [
                'municipioid' => 49,
                'municipionom' => 'Barinas',
                'estadoid' => 5,
            ],
            [
                'municipioid' => 50,
                'municipionom' => 'Bolivar',
                'estadoid' => 5,
            ],
        ]);

        $this->db->table('sgc_municipio')->insertBatch([
            [
                'municipioid' => 51,
                'municipionom' => 'Ezequiel Zamora',
                'estadoid' => 5,
            ],
            [
                'municipioid' => 52,
                'municipionom' => 'Obispos',
                'estadoid' => 5,
            ],
            [
                'municipioid' => 53,
                'municipionom' => 'Pedraza',
                'estadoid' => 5,
            ],
            [
                'municipioid' => 54,
                'municipionom' => 'Rojas',
                'estadoid' => 5,
            ],
            [
                'municipioid' => 55,
                'municipionom' => 'Sosa',
                'estadoid' => 5,
            ],
            [
                'municipioid' => 56,
                'municipionom' => 'Alberto Arvelo T',
                'estadoid' => 5,
            ],
            [
                'municipioid' => 57,
                'municipionom' => 'A Jose De Sucre',
                'estadoid' => 5,
            ],
            [
                'municipioid' => 58,
                'municipionom' => 'Cruz Paredes',
                'estadoid' => 5,
            ],
            [
                'municipioid' => 59,
                'municipionom' => 'Andres E. Blanco',
                'estadoid' => 5,
            ],
            [
                'municipioid' => 60,
                'municipionom' => 'Caroni',
                'estadoid' => 6,
            ],
            [
                'municipioid' => 61,
                'municipionom' => 'Cedeño',
                'estadoid' => 6,
            ],
            [
                'municipioid' => 62,
                'municipionom' => 'Heres',
                'estadoid' => 6,
            ],
            [
                'municipioid' => 63,
                'municipionom' => 'Piar',
                'estadoid' => 6,
            ],
            [
                'municipioid' => 64,
                'municipionom' => 'Roscio',
                'estadoid' => 6,
            ],
            [
                'municipioid' => 65,
                'municipionom' => 'Sucre',
                'estadoid' => 6,
            ],
            [
                'municipioid' => 66,
                'municipionom' => 'Sifontes',
                'estadoid' => 6,
            ],
            [
                'municipioid' => 67,
                'municipionom' => 'Raul Leoni',
                'estadoid' => 6,
            ],
            [
                'municipioid' => 68,
                'municipionom' => 'Gran Sabana',
                'estadoid' => 6,
            ],
            [
                'municipioid' => 69,
                'municipionom' => 'El Callao',
                'estadoid' => 6,
            ],
            [
                'municipioid' => 70,
                'municipionom' => 'Padre Pedro Chien',
                'estadoid' => 6,
            ],
            [
                'municipioid' => 71,
                'municipionom' => 'Bejuma',
                'estadoid' => 7,
            ],
            [
                'municipioid' => 72,
                'municipionom' => 'Carlos Arvelo',
                'estadoid' => 7,
            ],
            [
                'municipioid' => 73,
                'municipionom' => 'Diego Ibarra',
                'estadoid' => 7,
            ],
            [
                'municipioid' => 74,
                'municipionom' => 'Guacara',
                'estadoid' => 7,
            ],
            [
                'municipioid' => 75,
                'municipionom' => 'Montalban',
                'estadoid' => 7,
            ],
            [
                'municipioid' => 76,
                'municipionom' => 'Juan Jose Mora',
                'estadoid' => 7,
            ],
            [
                'municipioid' => 77,
                'municipionom' => 'Puerto Cabello',
                'estadoid' => 7,
            ],
            [
                'municipioid' => 78,
                'municipionom' => 'San Joaquin',
                'estadoid' => 7,
            ],
            [
                'municipioid' => 79,
                'municipionom' => 'Valencia',
                'estadoid' => 7,
            ],
            [
                'municipioid' => 80,
                'municipionom' => 'Miranda',
                'estadoid' => 7,
            ],
            [
                'municipioid' => 81,
                'municipionom' => 'Los Guayos',
                'estadoid' => 7,
            ],
            [
                'municipioid' => 82,
                'municipionom' => 'Naguanagua',
                'estadoid' => 7,
            ],
            [
                'municipioid' => 83,
                'municipionom' => 'San Diego',
                'estadoid' => 7,
            ],
            [
                'municipioid' => 84,
                'municipionom' => 'Libertador',
                'estadoid' => 7,
            ],
            [
                'municipioid' => 85,
                'municipionom' => 'Anzoategui',
                'estadoid' => 8,
            ],
            [
                'municipioid' => 86,
                'municipionom' => 'Falcon',
                'estadoid' => 8,
            ],
            [
                'municipioid' => 87,
                'municipionom' => 'Girardot',
                'estadoid' => 8,
            ],
            [
                'municipioid' => 88,
                'municipionom' => 'Mp Pao Sn J Bautista',
                'estadoid' => 8,
            ],
            [
                'municipioid' => 89,
                'municipionom' => 'Ricaurte',
                'estadoid' => 8,
            ],
            [
                'municipioid' => 90,
                'municipionom' => 'San Carlos',
                'estadoid' => 8,
            ],
            [
                'municipioid' => 91,
                'municipionom' => 'Tinaco',
                'estadoid' => 8,
            ],
            [
                'municipioid' => 92,
                'municipionom' => 'Lima Blanco',
                'estadoid' => 8,
            ],
            [
                'municipioid' => 93,
                'municipionom' => 'Romulo Gallegos',
                'estadoid' => 8,
            ],
            [
                'municipioid' => 94,
                'municipionom' => 'Acosta',
                'estadoid' => 10,
            ],
            [
                'municipioid' => 95,
                'municipionom' => 'Bolivar',
                'estadoid' => 10,
            ],
            [
                'municipioid' => 96,
                'municipionom' => 'Buchivacoa',
                'estadoid' => 10,
            ],
            [
                'municipioid' => 97,
                'municipionom' => 'Carirubana',
                'estadoid' => 10,
            ],
            [
                'municipioid' => 98,
                'municipionom' => 'Colina',
                'estadoid' => 10,
            ],
            [
                'municipioid' => 99,
                'municipionom' => 'Democracia',
                'estadoid' => 10,
            ],
            [
                'municipioid' => 100,
                'municipionom' => 'Falcon',
                'estadoid' => 10,
            ],
        ]);

        $this->db->table('sgc_municipio')->insertBatch([
            [
                'municipioid' => 101,
                'municipionom' => 'Federacion',
                'estadoid' => 10,
            ],
            [
                'municipioid' => 102,
                'municipionom' => 'Mauroa',
                'estadoid' => 10,
            ],
            [
                'municipioid' => 103,
                'municipionom' => 'Miranda',
                'estadoid' => 10,
            ],
            [
                'municipioid' => 104,
                'municipionom' => 'Petit',
                'estadoid' => 10,
            ],
            [
                'municipioid' => 105,
                'municipionom' => 'Silva',
                'estadoid' => 10,
            ],
            [
                'municipioid' => 106,
                'municipionom' => 'Zamora',
                'estadoid' => 10,
            ],
            [
                'municipioid' => 107,
                'municipionom' => 'Dabajuro',
                'estadoid' => 10,
            ],
            [
                'municipioid' => 108,
                'municipionom' => 'Mons. Iturriza',
                'estadoid' => 10,
            ],
            [
                'municipioid' => 109,
                'municipionom' => 'Los Taques',
                'estadoid' => 10,
            ],
            [
                'municipioid' => 110,
                'municipionom' => 'Piritu',
                'estadoid' => 10,
            ],
            [
                'municipioid' => 111,
                'municipionom' => 'Union',
                'estadoid' => 10,
            ],
            [
                'municipioid' => 112,
                'municipionom' => 'San Francisco',
                'estadoid' => 10,
            ],
            [
                'municipioid' => 113,
                'municipionom' => 'Jacura',
                'estadoid' => 10,
            ],
            [
                'municipioid' => 114,
                'municipionom' => 'Cacique Manaure',
                'estadoid' => 10,
            ],
            [
                'municipioid' => 115,
                'municipionom' => 'Palma Sola',
                'estadoid' => 10,
            ],
            [
                'municipioid' => 116,
                'municipionom' => 'Sucre',
                'estadoid' => 10,
            ],
            [
                'municipioid' => 117,
                'municipionom' => 'Urumaco',
                'estadoid' => 10,
            ],
            [
                'municipioid' => 118,
                'municipionom' => 'Tocopero',
                'estadoid' => 10,
            ],
            [
                'municipioid' => 119,
                'municipionom' => 'Infante',
                'estadoid' => 11,
            ],
            [
                'municipioid' => 120,
                'municipionom' => 'Mellado',
                'estadoid' => 11,
            ],
            [
                'municipioid' => 121,
                'municipionom' => 'Miranda',
                'estadoid' => 11,
            ],
            [
                'municipioid' => 122,
                'municipionom' => 'Monagas',
                'estadoid' => 11,
            ],
            [
                'municipioid' => 123,
                'municipionom' => 'Ribas',
                'estadoid' => 11,
            ],
            [
                'municipioid' => 124,
                'municipionom' => 'Roscio',
                'estadoid' => 11,
            ],
            [
                'municipioid' => 125,
                'municipionom' => 'Zaraza',
                'estadoid' => 11,
            ],
            [
                'municipioid' => 126,
                'municipionom' => 'Camaguan',
                'estadoid' => 11,
            ],
            [
                'municipioid' => 127,
                'municipionom' => 'S Jose De Guaribe',
                'estadoid' => 11,
            ],
            [
                'municipioid' => 128,
                'municipionom' => 'Las Mercedes',
                'estadoid' => 11,
            ],
            [
                'municipioid' => 129,
                'municipionom' => 'El Socorro',
                'estadoid' => 11,
            ],
            [
                'municipioid' => 130,
                'municipionom' => 'Ortiz',
                'estadoid' => 11,
            ],
            [
                'municipioid' => 131,
                'municipionom' => 'S Maria De Ipire',
                'estadoid' => 11,
            ],
            [
                'municipioid' => 132,
                'municipionom' => 'Chaguaramas',
                'estadoid' => 11,
            ],
            [
                'municipioid' => 133,
                'municipionom' => 'San Geronimo De G',
                'estadoid' => 11,
            ],
            [
                'municipioid' => 134,
                'municipionom' => 'Crespo',
                'estadoid' => 12,
            ],
            [
                'municipioid' => 135,
                'municipionom' => 'Iribarren',
                'estadoid' => 12,
            ],
            [
                'municipioid' => 136,
                'municipionom' => 'Jimenez',
                'estadoid' => 12,
            ],
            [
                'municipioid' => 137,
                'municipionom' => 'Moran',
                'estadoid' => 12,
            ],
            [
                'municipioid' => 138,
                'municipionom' => 'Palavecino',
                'estadoid' => 12,
            ],
            [
                'municipioid' => 139,
                'municipionom' => 'Torres',
                'estadoid' => 12,
            ],
            [
                'municipioid' => 140,
                'municipionom' => 'Urdaneta',
                'estadoid' => 12,
            ],
            [
                'municipioid' => 141,
                'municipionom' => 'Andres E Blanco',
                'estadoid' => 12,
            ],
            [
                'municipioid' => 142,
                'municipionom' => 'Simon Planas',
                'estadoid' => 12,
            ],
            [
                'municipioid' => 143,
                'municipionom' => 'Alberto Adriani',
                'estadoid' => 13,
            ],
            [
                'municipioid' => 144,
                'municipionom' => 'Andres Bello',
                'estadoid' => 13,
            ],
            [
                'municipioid' => 145,
                'municipionom' => 'Arzobispo Chacon',
                'estadoid' => 13,
            ],
            [
                'municipioid' => 146,
                'municipionom' => 'Campo Elias',
                'estadoid' => 13,
            ],
            [
                'municipioid' => 147,
                'municipionom' => 'Guaraque',
                'estadoid' => 13,
            ],
            [
                'municipioid' => 148,
                'municipionom' => 'Julio Cesar Salas',
                'estadoid' => 13,
            ],
            [
                'municipioid' => 149,
                'municipionom' => 'Justo Briceño',
                'estadoid' => 13,
            ],
            [
                'municipioid' => 150,
                'municipionom' => 'Libertador',
                'estadoid' => 13,
            ],
        ]);

        $this->db->table('sgc_municipio')->insertBatch([
            [
                'municipioid' => 151,
                'municipionom' => 'Santos Marquina',
                'estadoid' => 13,
            ],
            [
                'municipioid' => 152,
                'municipionom' => 'Miranda',
                'estadoid' => 13,
            ],
            [
                'municipioid' => 153,
                'municipionom' => 'Antonio Pinto S.',
                'estadoid' => 13,
            ],
            [
                'municipioid' => 154,
                'municipionom' => 'Ob. Ramos De Lora',
                'estadoid' => 13,
            ],
            [
                'municipioid' => 155,
                'municipionom' => 'Caracciolo Parra',
                'estadoid' => 13,
            ],
            [
                'municipioid' => 156,
                'municipionom' => 'Cardenal Quintero',
                'estadoid' => 13,
            ],
            [
                'municipioid' => 157,
                'municipionom' => 'Pueblo Llano',
                'estadoid' => 13,
            ],
            [
                'municipioid' => 158,
                'municipionom' => 'Rangel',
                'estadoid' => 13,
            ],
            [
                'municipioid' => 159,
                'municipionom' => 'Rivas Davila',
                'estadoid' => 13,
            ],
            [
                'municipioid' => 160,
                'municipionom' => 'Sucre',
                'estadoid' => 13,
            ],
            [
                'municipioid' => 161,
                'municipionom' => 'Tovar',
                'estadoid' => 13,
            ],
            [
                'municipioid' => 162,
                'municipionom' => 'Tulio F Cordero',
                'estadoid' => 13,
            ],
            [
                'municipioid' => 163,
                'municipionom' => 'Padre Noguera',
                'estadoid' => 13,
            ],
            [
                'municipioid' => 164,
                'municipionom' => 'Aricagua',
                'estadoid' => 13,
            ],
            [
                'municipioid' => 165,
                'municipionom' => 'Zea',
                'estadoid' => 13,
            ],
            [
                'municipioid' => 166,
                'municipionom' => 'Acevedo',
                'estadoid' => 14,
            ],
            [
                'municipioid' => 167,
                'municipionom' => 'Brion',
                'estadoid' => 14,
            ],
            [
                'municipioid' => 168,
                'municipionom' => 'Guaicaipuro',
                'estadoid' => 14,
            ],
            [
                'municipioid' => 169,
                'municipionom' => 'Independencia',
                'estadoid' => 14,
            ],
            [
                'municipioid' => 170,
                'municipionom' => 'Lander',
                'estadoid' => 14,
            ],
            [
                'municipioid' => 171,
                'municipionom' => 'Paez',
                'estadoid' => 14,
            ],
            [
                'municipioid' => 172,
                'municipionom' => 'Paz Castillo',
                'estadoid' => 14,
            ],
            [
                'municipioid' => 173,
                'municipionom' => 'Plaza',
                'estadoid' => 14,
            ],
            [
                'municipioid' => 174,
                'municipionom' => 'Sucre',
                'estadoid' => 14,
            ],
            [
                'municipioid' => 175,
                'municipionom' => 'Urdaneta',
                'estadoid' => 14,
            ],
            [
                'municipioid' => 176,
                'municipionom' => 'Zamora',
                'estadoid' => 14,
            ],
            [
                'municipioid' => 177,
                'municipionom' => 'Cristobal Rojas',
                'estadoid' => 14,
            ],
            [
                'municipioid' => 178,
                'municipionom' => 'Los Salias',
                'estadoid' => 14,
            ],
            [
                'municipioid' => 179,
                'municipionom' => 'Andres Bello',
                'estadoid' => 14,
            ],
            [
                'municipioid' => 180,
                'municipionom' => 'Simon Bolivar',
                'estadoid' => 14,
            ],
            [
                'municipioid' => 181,
                'municipionom' => 'Baruta',
                'estadoid' => 14,
            ],
            [
                'municipioid' => 182,
                'municipionom' => 'Carrizal',
                'estadoid' => 14,
            ],
            [
                'municipioid' => 183,
                'municipionom' => 'Chacao',
                'estadoid' => 14,
            ],
            [
                'municipioid' => 184,
                'municipionom' => 'El Hatillo',
                'estadoid' => 14,
            ],
            [
                'municipioid' => 185,
                'municipionom' => 'Buroz',
                'estadoid' => 14,
            ],
            [
                'municipioid' => 186,
                'municipionom' => 'Pedro Gual',
                'estadoid' => 14,
            ],
            [
                'municipioid' => 187,
                'municipionom' => 'Acosta',
                'estadoid' => 15,
            ],
            [
                'municipioid' => 188,
                'municipionom' => 'Bolivar',
                'estadoid' => 15,
            ],
            [
                'municipioid' => 189,
                'municipionom' => 'Caripe',
                'estadoid' => 15,
            ],
            [
                'municipioid' => 190,
                'municipionom' => 'Cedeño',
                'estadoid' => 15,
            ],
            [
                'municipioid' => 191,
                'municipionom' => 'Ezequiel Zamora',
                'estadoid' => 15,
            ],
            [
                'municipioid' => 192,
                'municipionom' => 'Libertador',
                'estadoid' => 15,
            ],
            [
                'municipioid' => 193,
                'municipionom' => 'Maturin',
                'estadoid' => 15,
            ],
            [
                'municipioid' => 194,
                'municipionom' => 'Piar',
                'estadoid' => 15,
            ],
            [
                'municipioid' => 195,
                'municipionom' => 'Punceres',
                'estadoid' => 15,
            ],
            [
                'municipioid' => 196,
                'municipionom' => 'Sotillo',
                'estadoid' => 15,
            ],
            [
                'municipioid' => 197,
                'municipionom' => 'Aguasay',
                'estadoid' => 15,
            ],
            [
                'municipioid' => 198,
                'municipionom' => 'Santa Barbara',
                'estadoid' => 15,
            ],
            [
                'municipioid' => 199,
                'municipionom' => 'Uracoa',
                'estadoid' => 15,
            ],
            [
                'municipioid' => 200,
                'municipionom' => 'Arismendi',
                'estadoid' => 16,
            ],
        ]);

        $this->db->table('sgc_municipio')->insertBatch([
            [
                'municipioid' => 201,
                'municipionom' => 'Diaz',
                'estadoid' => 16,
            ],
            [
                'municipioid' => 202,
                'municipionom' => 'Gomez',
                'estadoid' => 16,
            ],
            [
                'municipioid' => 203,
                'municipionom' => 'Maneiro',
                'estadoid' => 16,
            ],
            [
                'municipioid' => 204,
                'municipionom' => 'Marcano',
                'estadoid' => 16,
            ],
            [
                'municipioid' => 205,
                'municipionom' => 'Mariño',
                'estadoid' => 16,
            ],
            [
                'municipioid' => 206,
                'municipionom' => 'Penin. De Macanao',
                'estadoid' => 16,
            ],
            [
                'municipioid' => 207,
                'municipionom' => 'Villalba(I.Coche)',
                'estadoid' => 16,
            ],
            [
                'municipioid' => 208,
                'municipionom' => 'Tubores',
                'estadoid' => 16,
            ],
            [
                'municipioid' => 209,
                'municipionom' => 'Antolin Del Campo',
                'estadoid' => 16,
            ],
            [
                'municipioid' => 210,
                'municipionom' => 'Garcia',
                'estadoid' => 16,
            ],
            [
                'municipioid' => 211,
                'municipionom' => 'Araure',
                'estadoid' => 17,
            ],
            [
                'municipioid' => 212,
                'municipionom' => 'Esteller',
                'estadoid' => 17,
            ],
            [
                'municipioid' => 213,
                'municipionom' => 'Guanare',
                'estadoid' => 17,
            ],
            [
                'municipioid' => 214,
                'municipionom' => 'Guanarito',
                'estadoid' => 17,
            ],
            [
                'municipioid' => 215,
                'municipionom' => 'Ospino',
                'estadoid' => 17,
            ],
            [
                'municipioid' => 216,
                'municipionom' => 'Paez',
                'estadoid' => 17,
            ],
            [
                'municipioid' => 217,
                'municipionom' => 'Sucre',
                'estadoid' => 17,
            ],
            [
                'municipioid' => 218,
                'municipionom' => 'Turen',
                'estadoid' => 17,
            ],
            [
                'municipioid' => 219,
                'municipionom' => 'M.Jose V De Unda',
                'estadoid' => 17,
            ],
            [
                'municipioid' => 220,
                'municipionom' => 'Agua Blanca',
                'estadoid' => 17,
            ],
            [
                'municipioid' => 221,
                'municipionom' => 'Papelon',
                'estadoid' => 17,
            ],
            [
                'municipioid' => 222,
                'municipionom' => 'Genaro Boconoito',
                'estadoid' => 17,
            ],
            [
                'municipioid' => 223,
                'municipionom' => 'S Rafael De Onoto',
                'estadoid' => 17,
            ],
            [
                'municipioid' => 224,
                'municipionom' => 'Santa Rosalia',
                'estadoid' => 17,
            ],
            [
                'municipioid' => 225,
                'municipionom' => 'Arismendi',
                'estadoid' => 18,
            ],
            [
                'municipioid' => 226,
                'municipionom' => 'Benitez',
                'estadoid' => 18,
            ],
            [
                'municipioid' => 227,
                'municipionom' => 'Bermudez',
                'estadoid' => 18,
            ],
            [
                'municipioid' => 228,
                'municipionom' => 'Cajigal',
                'estadoid' => 18,
            ],
            [
                'municipioid' => 229,
                'municipionom' => 'Mariño',
                'estadoid' => 18,
            ],
            [
                'municipioid' => 230,
                'municipionom' => 'Mejia',
                'estadoid' => 18,
            ],
            [
                'municipioid' => 231,
                'municipionom' => 'Montes',
                'estadoid' => 18,
            ],
            [
                'municipioid' => 232,
                'municipionom' => 'Ribero',
                'estadoid' => 18,
            ],
            [
                'municipioid' => 233,
                'municipionom' => 'Sucre',
                'estadoid' => 18,
            ],
            [
                'municipioid' => 234,
                'municipionom' => 'Valdez',
                'estadoid' => 18,
            ],
            [
                'municipioid' => 235,
                'municipionom' => 'Andres E Blanco',
                'estadoid' => 18,
            ],
            [
                'municipioid' => 236,
                'municipionom' => 'Libertador',
                'estadoid' => 18,
            ],
            [
                'municipioid' => 237,
                'municipionom' => 'Andres Mata',
                'estadoid' => 18,
            ],
            [
                'municipioid' => 238,
                'municipionom' => 'Bolivar',
                'estadoid' => 18,
            ],
            [
                'municipioid' => 239,
                'municipionom' => 'Cruz S Acosta',
                'estadoid' => 18,
            ],
            [
                'municipioid' => 240,
                'municipionom' => 'Ayacucho',
                'estadoid' => 19,
            ],
            [
                'municipioid' => 241,
                'municipionom' => 'Bolivar',
                'estadoid' => 19,
            ],
            [
                'municipioid' => 242,
                'municipionom' => 'Independencia',
                'estadoid' => 19,
            ],
            [
                'municipioid' => 243,
                'municipionom' => 'Cardenas',
                'estadoid' => 19,
            ],
            [
                'municipioid' => 244,
                'municipionom' => 'Jauregui',
                'estadoid' => 19,
            ],
            [
                'municipioid' => 245,
                'municipionom' => 'Junin',
                'estadoid' => 19,
            ],
            [
                'municipioid' => 246,
                'municipionom' => 'Lobatera',
                'estadoid' => 19,
            ],
            [
                'municipioid' => 247,
                'municipionom' => 'San Cristobal',
                'estadoid' => 19,
            ],
            [
                'municipioid' => 248,
                'municipionom' => 'Uribante',
                'estadoid' => 19,
            ],
            [
                'municipioid' => 249,
                'municipionom' => 'Cordoba',
                'estadoid' => 19,
            ],
            [
                'municipioid' => 250,
                'municipionom' => 'Garcia De Hevia',
                'estadoid' => 19,
            ],
        ]);

        $this->db->table('sgc_municipio')->insertBatch([
            [
                'municipioid' => 251,
                'municipionom' => 'Guasimos',
                'estadoid' => 19,
            ],
            [
                'municipioid' => 252,
                'municipionom' => 'Michelena',
                'estadoid' => 19,
            ],
            [
                'municipioid' => 253,
                'municipionom' => 'Libertador',
                'estadoid' => 19,
            ],
            [
                'municipioid' => 254,
                'municipionom' => 'Panamericano',
                'estadoid' => 19,
            ],
            [
                'municipioid' => 255,
                'municipionom' => 'Pedro Maria Ureña',
                'estadoid' => 19,
            ],
            [
                'municipioid' => 256,
                'municipionom' => 'Sucre',
                'estadoid' => 19,
            ],
            [
                'municipioid' => 257,
                'municipionom' => 'Andres Bello',
                'estadoid' => 19,
            ],
            [
                'municipioid' => 258,
                'municipionom' => 'Fernandez Feo',
                'estadoid' => 19,
            ],
            [
                'municipioid' => 259,
                'municipionom' => 'Libertad',
                'estadoid' => 19,
            ],
            [
                'municipioid' => 260,
                'municipionom' => 'Samuel Maldonado',
                'estadoid' => 19,
            ],
            [
                'municipioid' => 261,
                'municipionom' => 'Seboruco',
                'estadoid' => 19,
            ],
            [
                'municipioid' => 262,
                'municipionom' => 'Antonio Romulo C',
                'estadoid' => 19,
            ],
            [
                'municipioid' => 263,
                'municipionom' => 'Fco De Miranda',
                'estadoid' => 19,
            ],
            [
                'municipioid' => 264,
                'municipionom' => 'Jose Maria Vargas',
                'estadoid' => 19,
            ],
            [
                'municipioid' => 265,
                'municipionom' => 'Rafael Urdaneta',
                'estadoid' => 19,
            ],
            [
                'municipioid' => 266,
                'municipionom' => 'Simon Rodriguez',
                'estadoid' => 19,
            ],
            [
                'municipioid' => 267,
                'municipionom' => 'Torbes',
                'estadoid' => 19,
            ],
            [
                'municipioid' => 268,
                'municipionom' => 'San Judas Tadeo',
                'estadoid' => 19,
            ],
            [
                'municipioid' => 269,
                'municipionom' => 'Rafael Rangel',
                'estadoid' => 20,
            ],
            [
                'municipioid' => 270,
                'municipionom' => 'Bocono',
                'estadoid' => 20,
            ],
            [
                'municipioid' => 271,
                'municipionom' => 'Carache',
                'estadoid' => 20,
            ],
            [
                'municipioid' => 272,
                'municipionom' => 'Escuque',
                'estadoid' => 20,
            ],
            [
                'municipioid' => 273,
                'municipionom' => 'Trujillo',
                'estadoid' => 20,
            ],
            [
                'municipioid' => 274,
                'municipionom' => 'Urdaneta',
                'estadoid' => 20,
            ],
            [
                'municipioid' => 275,
                'municipionom' => 'Valera',
                'estadoid' => 20,
            ],
            [
                'municipioid' => 276,
                'municipionom' => 'Candelaria',
                'estadoid' => 20,
            ],
            [
                'municipioid' => 277,
                'municipionom' => 'Miranda',
                'estadoid' => 20,
            ],
            [
                'municipioid' => 278,
                'municipionom' => 'Monte Carmelo',
                'estadoid' => 20,
            ],
            [
                'municipioid' => 279,
                'municipionom' => 'Motatan',
                'estadoid' => 20,
            ],
            [
                'municipioid' => 280,
                'municipionom' => 'Pampan',
                'estadoid' => 20,
            ],
            [
                'municipioid' => 281,
                'municipionom' => 'S Rafael Carvajal',
                'estadoid' => 20,
            ],
            [
                'municipioid' => 282,
                'municipionom' => 'Sucre',
                'estadoid' => 20,
            ],
            [
                'municipioid' => 283,
                'municipionom' => 'Andres Bello',
                'estadoid' => 20,
            ],
            [
                'municipioid' => 284,
                'municipionom' => 'Bolivar',
                'estadoid' => 20,
            ],
            [
                'municipioid' => 285,
                'municipionom' => 'Jose F M Cañizal',
                'estadoid' => 20,
            ],
            [
                'municipioid' => 286,
                'municipionom' => 'Juan V Campo Eli',
                'estadoid' => 20,
            ],
            [
                'municipioid' => 287,
                'municipionom' => 'La Ceiba',
                'estadoid' => 20,
            ],
            [
                'municipioid' => 288,
                'municipionom' => 'Pampanito',
                'estadoid' => 20,
            ],
            [
                'municipioid' => 289,
                'municipionom' => 'Bolivar',
                'estadoid' => 22,
            ],
            [
                'municipioid' => 290,
                'municipionom' => 'Bruzual',
                'estadoid' => 22,
            ],
            [
                'municipioid' => 291,
                'municipionom' => 'Nirgua',
                'estadoid' => 22,
            ],
            [
                'municipioid' => 292,
                'municipionom' => 'San Felipe',
                'estadoid' => 22,
            ],
            [
                'municipioid' => 293,
                'municipionom' => 'Sucre',
                'estadoid' => 22,
            ],
            [
                'municipioid' => 294,
                'municipionom' => 'Urachiche',
                'estadoid' => 22,
            ],
            [
                'municipioid' => 295,
                'municipionom' => 'Peña',
                'estadoid' => 22,
            ],
            [
                'municipioid' => 296,
                'municipionom' => 'Jose Antonio Paez',
                'estadoid' => 22,
            ],
            [
                'municipioid' => 297,
                'municipionom' => 'La Trinidad',
                'estadoid' => 22,
            ],
            [
                'municipioid' => 298,
                'municipionom' => 'Cocorote',
                'estadoid' => 22,
            ],
            [
                'municipioid' => 299,
                'municipionom' => 'Independencia',
                'estadoid' => 22,
            ],
            [
                'municipioid' => 300,
                'municipionom' => 'Aristides Bastid',
                'estadoid' => 22,
            ],
        ]);

        $this->db->table('sgc_municipio')->insertBatch([
            [
                'municipioid' => 301,
                'municipionom' => 'Manuel Monge',
                'estadoid' => 22,
            ],
            [
                'municipioid' => 302,
                'municipionom' => 'Veroes',
                'estadoid' => 22,
            ],
            [
                'municipioid' => 303,
                'municipionom' => 'Baralt',
                'estadoid' => 23,
            ],
            [
                'municipioid' => 304,
                'municipionom' => 'Santa Rita',
                'estadoid' => 23,
            ],
            [
                'municipioid' => 305,
                'municipionom' => 'Colon',
                'estadoid' => 23,
            ],
            [
                'municipioid' => 306,
                'municipionom' => 'Mara',
                'estadoid' => 23,
            ],
            [
                'municipioid' => 307,
                'municipionom' => 'Maracaibo',
                'estadoid' => 23,
            ],
            [
                'municipioid' => 308,
                'municipionom' => 'Miranda',
                'estadoid' => 23,
            ],
            [
                'municipioid' => 309,
                'municipionom' => 'Paez',
                'estadoid' => 23,
            ],
            [
                'municipioid' => 310,
                'municipionom' => 'Machiques De P',
                'estadoid' => 23,
            ],
            [
                'municipioid' => 311,
                'municipionom' => 'Sucre',
                'estadoid' => 23,
            ],
            [
                'municipioid' => 312,
                'municipionom' => 'La Cañada De U.',
                'estadoid' => 23,
            ],
            [
                'municipioid' => 313,
                'municipionom' => 'Lagunillas',
                'estadoid' => 23,
            ],
            [
                'municipioid' => 314,
                'municipionom' => 'Catatumbo',
                'estadoid' => 23,
            ],
            [
                'municipioid' => 315,
                'municipionom' => 'M/Rosario De Perija',
                'estadoid' => 23,
            ],
            [
                'municipioid' => 316,
                'municipionom' => 'Cabimas',
                'estadoid' => 23,
            ],
            [
                'municipioid' => 317,
                'municipionom' => 'Valmore Rodriguez',
                'estadoid' => 23,
            ],
            [
                'municipioid' => 318,
                'municipionom' => 'Jesus E Lossada',
                'estadoid' => 23,
            ],
            [
                'municipioid' => 319,
                'municipionom' => 'Almirante P',
                'estadoid' => 23,
            ],
            [
                'municipioid' => 320,
                'municipionom' => 'San Francisco',
                'estadoid' => 23,
            ],
            [
                'municipioid' => 321,
                'municipionom' => 'Jesus M Semprun',
                'estadoid' => 23,
            ],
            [
                'municipioid' => 322,
                'municipionom' => 'Francisco J Pulg',
                'estadoid' => 23,
            ],
            [
                'municipioid' => 323,
                'municipionom' => 'Simon Bolivar',
                'estadoid' => 23,
            ],
            [
                'municipioid' => 324,
                'municipionom' => 'Atures',
                'estadoid' => 1,
            ],
            [
                'municipioid' => 325,
                'municipionom' => 'Atabapo',
                'estadoid' => 1,
            ],
            [
                'municipioid' => 326,
                'municipionom' => 'Maroa',
                'estadoid' => 1,
            ],
            [
                'municipioid' => 327,
                'municipionom' => 'Rio Negro',
                'estadoid' => 1,
            ],
            [
                'municipioid' => 328,
                'municipionom' => 'Autana',
                'estadoid' => 1,
            ],
            [
                'municipioid' => 329,
                'municipionom' => 'Manapiare',
                'estadoid' => 1,
            ],
            [
                'municipioid' => 330,
                'municipionom' => 'Alto Orinoco',
                'estadoid' => 1,
            ],
            [
                'municipioid' => 331,
                'municipionom' => 'Tucupita',
                'estadoid' => 9,
            ],
            [
                'municipioid' => 332,
                'municipionom' => 'Pedernales',
                'estadoid' => 9,
            ],
            [
                'municipioid' => 333,
                'municipionom' => 'Antonio Diaz',
                'estadoid' => 9,
            ],
            [
                'municipioid' => 334,
                'municipionom' => 'Casacoima',
                'estadoid' => 9,
            ],
            [
                'municipioid' => 335,
                'municipionom' => 'Vargas',
                'estadoid' => 21,
            ],
            [
                'municipioid' => 336,
                'municipionom' => 'N/A',
                'estadoid' => 26,
            ],
        ]);

    }
}

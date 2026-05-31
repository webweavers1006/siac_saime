<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Seeder for table: sgc_paises (216 rows)
 * Generated from existing database data
 */
class PaisesSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('sgc_paises')->truncate();

        $this->db->table('sgc_paises')->insertBatch([
            [
                'paisid' => 1,
                'paisnom' => 'Venezuela',
            ],
            [
                'paisid' => 2,
                'paisnom' => 'Australia',
            ],
            [
                'paisid' => 3,
                'paisnom' => 'Austria',
            ],
            [
                'paisid' => 4,
                'paisnom' => 'Azerbaiyán',
            ],
            [
                'paisid' => 5,
                'paisnom' => 'Anguilla',
            ],
            [
                'paisid' => 6,
                'paisnom' => 'Argentina',
            ],
            [
                'paisid' => 7,
                'paisnom' => 'Armenia',
            ],
            [
                'paisid' => 8,
                'paisnom' => 'Bielorrusia',
            ],
            [
                'paisid' => 9,
                'paisnom' => 'Belice',
            ],
            [
                'paisid' => 10,
                'paisnom' => 'Bélgica',
            ],
            [
                'paisid' => 11,
                'paisnom' => 'Bermudas',
            ],
            [
                'paisid' => 12,
                'paisnom' => 'Bulgaria',
            ],
            [
                'paisid' => 13,
                'paisnom' => 'Brasil',
            ],
            [
                'paisid' => 14,
                'paisnom' => 'Reino Unido',
            ],
            [
                'paisid' => 15,
                'paisnom' => 'Hungría',
            ],
            [
                'paisid' => 16,
                'paisnom' => 'Vietnam',
            ],
            [
                'paisid' => 17,
                'paisnom' => 'Haiti',
            ],
            [
                'paisid' => 18,
                'paisnom' => 'Guadalupe',
            ],
            [
                'paisid' => 19,
                'paisnom' => 'Alemania',
            ],
            [
                'paisid' => 20,
                'paisnom' => 'Países Bajos, Holanda',
            ],
            [
                'paisid' => 21,
                'paisnom' => 'Grecia',
            ],
            [
                'paisid' => 22,
                'paisnom' => 'Georgia',
            ],
            [
                'paisid' => 23,
                'paisnom' => 'Dinamarca',
            ],
            [
                'paisid' => 24,
                'paisnom' => 'Egipto',
            ],
            [
                'paisid' => 25,
                'paisnom' => 'Israel',
            ],
            [
                'paisid' => 26,
                'paisnom' => 'India',
            ],
            [
                'paisid' => 27,
                'paisnom' => 'Irán',
            ],
            [
                'paisid' => 28,
                'paisnom' => 'Irlanda',
            ],
            [
                'paisid' => 29,
                'paisnom' => 'España',
            ],
            [
                'paisid' => 30,
                'paisnom' => 'Italia',
            ],
            [
                'paisid' => 31,
                'paisnom' => 'Kazajstán',
            ],
            [
                'paisid' => 32,
                'paisnom' => 'Camerún',
            ],
            [
                'paisid' => 33,
                'paisnom' => 'Canadá',
            ],
            [
                'paisid' => 34,
                'paisnom' => 'Chipre',
            ],
            [
                'paisid' => 35,
                'paisnom' => 'Kirguistán',
            ],
            [
                'paisid' => 36,
                'paisnom' => 'China',
            ],
            [
                'paisid' => 37,
                'paisnom' => 'Costa Rica',
            ],
            [
                'paisid' => 38,
                'paisnom' => 'Kuwait',
            ],
            [
                'paisid' => 39,
                'paisnom' => 'Letonia',
            ],
            [
                'paisid' => 40,
                'paisnom' => 'Libia',
            ],
            [
                'paisid' => 41,
                'paisnom' => 'Lituania',
            ],
            [
                'paisid' => 42,
                'paisnom' => 'Luxemburgo',
            ],
            [
                'paisid' => 43,
                'paisnom' => 'México',
            ],
            [
                'paisid' => 44,
                'paisnom' => 'Moldavia',
            ],
            [
                'paisid' => 45,
                'paisnom' => 'Mónaco',
            ],
            [
                'paisid' => 46,
                'paisnom' => 'Nueva Zelanda',
            ],
            [
                'paisid' => 47,
                'paisnom' => 'Noruega',
            ],
            [
                'paisid' => 48,
                'paisnom' => 'Polonia',
            ],
            [
                'paisid' => 49,
                'paisnom' => 'Portugal',
            ],
            [
                'paisid' => 50,
                'paisnom' => 'Reunión',
            ],
        ]);

        $this->db->table('sgc_paises')->insertBatch([
            [
                'paisid' => 51,
                'paisnom' => 'Rusia',
            ],
            [
                'paisid' => 52,
                'paisnom' => 'El Salvador',
            ],
            [
                'paisid' => 53,
                'paisnom' => 'Eslovaquia',
            ],
            [
                'paisid' => 54,
                'paisnom' => 'Eslovenia',
            ],
            [
                'paisid' => 55,
                'paisnom' => 'Surinam',
            ],
            [
                'paisid' => 56,
                'paisnom' => 'Estados Unidos',
            ],
            [
                'paisid' => 57,
                'paisnom' => 'Tadjikistan',
            ],
            [
                'paisid' => 58,
                'paisnom' => 'Turkmenistan',
            ],
            [
                'paisid' => 59,
                'paisnom' => 'Islas Turcas y Caicos',
            ],
            [
                'paisid' => 60,
                'paisnom' => 'Turquía',
            ],
            [
                'paisid' => 61,
                'paisnom' => 'Uganda',
            ],
            [
                'paisid' => 62,
                'paisnom' => 'Uzbekistán',
            ],
            [
                'paisid' => 63,
                'paisnom' => 'Ucrania',
            ],
            [
                'paisid' => 64,
                'paisnom' => 'Finlandia',
            ],
            [
                'paisid' => 65,
                'paisnom' => 'Francia',
            ],
            [
                'paisid' => 66,
                'paisnom' => 'República Checa',
            ],
            [
                'paisid' => 67,
                'paisnom' => 'Suiza',
            ],
            [
                'paisid' => 68,
                'paisnom' => 'Suecia',
            ],
            [
                'paisid' => 69,
                'paisnom' => 'Estonia',
            ],
            [
                'paisid' => 70,
                'paisnom' => 'Corea del Sur',
            ],
            [
                'paisid' => 71,
                'paisnom' => 'Japón',
            ],
            [
                'paisid' => 72,
                'paisnom' => 'Croacia',
            ],
            [
                'paisid' => 73,
                'paisnom' => 'Rumanía',
            ],
            [
                'paisid' => 74,
                'paisnom' => 'Hong Kong',
            ],
            [
                'paisid' => 75,
                'paisnom' => 'Indonesia',
            ],
            [
                'paisid' => 76,
                'paisnom' => 'Jordania',
            ],
            [
                'paisid' => 77,
                'paisnom' => 'Malasia',
            ],
            [
                'paisid' => 78,
                'paisnom' => 'Singapur',
            ],
            [
                'paisid' => 79,
                'paisnom' => 'Taiwan',
            ],
            [
                'paisid' => 80,
                'paisnom' => 'Bosnia y Herzegovina',
            ],
            [
                'paisid' => 81,
                'paisnom' => 'Bahamas',
            ],
            [
                'paisid' => 82,
                'paisnom' => 'Chile',
            ],
            [
                'paisid' => 83,
                'paisnom' => 'Colombia',
            ],
            [
                'paisid' => 84,
                'paisnom' => 'Islandia',
            ],
            [
                'paisid' => 85,
                'paisnom' => 'Corea del Norte',
            ],
            [
                'paisid' => 86,
                'paisnom' => 'Macedonia',
            ],
            [
                'paisid' => 87,
                'paisnom' => 'Malta',
            ],
            [
                'paisid' => 88,
                'paisnom' => 'Pakistán',
            ],
            [
                'paisid' => 89,
                'paisnom' => 'Papúa-Nueva Guinea',
            ],
            [
                'paisid' => 90,
                'paisnom' => 'Perú',
            ],
            [
                'paisid' => 91,
                'paisnom' => 'Filipinas',
            ],
            [
                'paisid' => 92,
                'paisnom' => 'Arabia Saudita',
            ],
            [
                'paisid' => 93,
                'paisnom' => 'Tailandia',
            ],
            [
                'paisid' => 94,
                'paisnom' => 'Emiratos Árabes Unidos',
            ],
            [
                'paisid' => 95,
                'paisnom' => 'Groenlandia',
            ],
            [
                'paisid' => 96,
                'paisnom' => 'Venezuela',
            ],
            [
                'paisid' => 97,
                'paisnom' => 'Zimbabwe',
            ],
            [
                'paisid' => 98,
                'paisnom' => 'Kenia',
            ],
            [
                'paisid' => 99,
                'paisnom' => 'Algeria',
            ],
            [
                'paisid' => 100,
                'paisnom' => 'Líbano',
            ],
        ]);

        $this->db->table('sgc_paises')->insertBatch([
            [
                'paisid' => 101,
                'paisnom' => 'Botsuana',
            ],
            [
                'paisid' => 102,
                'paisnom' => 'Tanzania',
            ],
            [
                'paisid' => 103,
                'paisnom' => 'Namibia',
            ],
            [
                'paisid' => 104,
                'paisnom' => 'Ecuador',
            ],
            [
                'paisid' => 105,
                'paisnom' => 'Marruecos',
            ],
            [
                'paisid' => 106,
                'paisnom' => 'Ghana',
            ],
            [
                'paisid' => 107,
                'paisnom' => 'Siria',
            ],
            [
                'paisid' => 108,
                'paisnom' => 'Nepal',
            ],
            [
                'paisid' => 109,
                'paisnom' => 'Mauritania',
            ],
            [
                'paisid' => 110,
                'paisnom' => 'Seychelles',
            ],
            [
                'paisid' => 111,
                'paisnom' => 'Paraguay',
            ],
            [
                'paisid' => 112,
                'paisnom' => 'Uruguay',
            ],
            [
                'paisid' => 113,
                'paisnom' => 'Congo (Brazzaville)',
            ],
            [
                'paisid' => 114,
                'paisnom' => 'Cuba',
            ],
            [
                'paisid' => 115,
                'paisnom' => 'Albania',
            ],
            [
                'paisid' => 116,
                'paisnom' => 'Nigeria',
            ],
            [
                'paisid' => 117,
                'paisnom' => 'Zambia',
            ],
            [
                'paisid' => 118,
                'paisnom' => 'Mozambique',
            ],
            [
                'paisid' => 119,
                'paisnom' => 'Angola',
            ],
            [
                'paisid' => 120,
                'paisnom' => 'Sri Lanka',
            ],
            [
                'paisid' => 121,
                'paisnom' => 'Etiopía',
            ],
            [
                'paisid' => 122,
                'paisnom' => 'Túnez',
            ],
            [
                'paisid' => 123,
                'paisnom' => 'Bolivia',
            ],
            [
                'paisid' => 124,
                'paisnom' => 'Panamá',
            ],
            [
                'paisid' => 125,
                'paisnom' => 'Malawi',
            ],
            [
                'paisid' => 126,
                'paisnom' => 'Liechtenstein',
            ],
            [
                'paisid' => 127,
                'paisnom' => 'Bahrein',
            ],
            [
                'paisid' => 128,
                'paisnom' => 'Barbados',
            ],
            [
                'paisid' => 129,
                'paisnom' => 'Chad',
            ],
            [
                'paisid' => 130,
                'paisnom' => 'Man, Isla de',
            ],
            [
                'paisid' => 131,
                'paisnom' => 'Jamaica',
            ],
            [
                'paisid' => 132,
                'paisnom' => 'Malí',
            ],
            [
                'paisid' => 133,
                'paisnom' => 'Madagascar',
            ],
            [
                'paisid' => 134,
                'paisnom' => 'Senegal',
            ],
            [
                'paisid' => 135,
                'paisnom' => 'Togo',
            ],
            [
                'paisid' => 136,
                'paisnom' => 'Honduras',
            ],
            [
                'paisid' => 137,
                'paisnom' => 'República Dominicana',
            ],
            [
                'paisid' => 138,
                'paisnom' => 'Mongolia',
            ],
            [
                'paisid' => 139,
                'paisnom' => 'Irak',
            ],
            [
                'paisid' => 140,
                'paisnom' => 'Sudáfrica',
            ],
            [
                'paisid' => 141,
                'paisnom' => 'Aruba',
            ],
            [
                'paisid' => 142,
                'paisnom' => 'Gibraltar',
            ],
            [
                'paisid' => 143,
                'paisnom' => 'Afganistán',
            ],
            [
                'paisid' => 144,
                'paisnom' => 'Andorra',
            ],
            [
                'paisid' => 145,
                'paisnom' => 'Antigua y Barbuda',
            ],
            [
                'paisid' => 146,
                'paisnom' => 'Bangladesh',
            ],
            [
                'paisid' => 147,
                'paisnom' => 'Benín',
            ],
            [
                'paisid' => 148,
                'paisnom' => 'Bután',
            ],
            [
                'paisid' => 149,
                'paisnom' => 'Islas Virgenes Británicas',
            ],
            [
                'paisid' => 150,
                'paisnom' => 'Brunéi',
            ],
        ]);

        $this->db->table('sgc_paises')->insertBatch([
            [
                'paisid' => 151,
                'paisnom' => 'Burkina Faso',
            ],
            [
                'paisid' => 152,
                'paisnom' => 'Burundi',
            ],
            [
                'paisid' => 153,
                'paisnom' => 'Camboya',
            ],
            [
                'paisid' => 154,
                'paisnom' => 'Cabo Verde',
            ],
            [
                'paisid' => 155,
                'paisnom' => 'Comores',
            ],
            [
                'paisid' => 156,
                'paisnom' => 'Congo (Kinshasa)',
            ],
            [
                'paisid' => 157,
                'paisnom' => 'Cook, Islas',
            ],
            [
                'paisid' => 158,
                'paisnom' => 'Costa de Marfil',
            ],
            [
                'paisid' => 159,
                'paisnom' => 'Djibouti, Yibuti',
            ],
            [
                'paisid' => 160,
                'paisnom' => 'Timor Oriental',
            ],
            [
                'paisid' => 161,
                'paisnom' => 'Guinea Ecuatorial',
            ],
            [
                'paisid' => 162,
                'paisnom' => 'Eritrea',
            ],
            [
                'paisid' => 163,
                'paisnom' => 'Feroe, Islas',
            ],
            [
                'paisid' => 164,
                'paisnom' => 'Fiyi',
            ],
            [
                'paisid' => 165,
                'paisnom' => 'Polinesia Francesa',
            ],
            [
                'paisid' => 166,
                'paisnom' => 'Gabón',
            ],
            [
                'paisid' => 167,
                'paisnom' => 'Gambia',
            ],
            [
                'paisid' => 168,
                'paisnom' => 'Granada',
            ],
            [
                'paisid' => 169,
                'paisnom' => 'Guatemala',
            ],
            [
                'paisid' => 170,
                'paisnom' => 'Guernsey',
            ],
            [
                'paisid' => 171,
                'paisnom' => 'Guinea',
            ],
            [
                'paisid' => 172,
                'paisnom' => 'Guinea-Bissau',
            ],
            [
                'paisid' => 173,
                'paisnom' => 'Guyana',
            ],
            [
                'paisid' => 174,
                'paisnom' => 'Jersey',
            ],
            [
                'paisid' => 175,
                'paisnom' => 'Kiribati',
            ],
            [
                'paisid' => 176,
                'paisnom' => 'Laos',
            ],
            [
                'paisid' => 177,
                'paisnom' => 'Lesotho',
            ],
            [
                'paisid' => 178,
                'paisnom' => 'Liberia',
            ],
            [
                'paisid' => 179,
                'paisnom' => 'Maldivas',
            ],
            [
                'paisid' => 180,
                'paisnom' => 'Martinica',
            ],
            [
                'paisid' => 181,
                'paisnom' => 'Mauricio',
            ],
            [
                'paisid' => 182,
                'paisnom' => 'Myanmar',
            ],
            [
                'paisid' => 183,
                'paisnom' => 'Nauru',
            ],
            [
                'paisid' => 184,
                'paisnom' => 'Antillas Holandesas',
            ],
            [
                'paisid' => 185,
                'paisnom' => 'Nueva Caledonia',
            ],
            [
                'paisid' => 186,
                'paisnom' => 'Nicaragua',
            ],
            [
                'paisid' => 187,
                'paisnom' => 'Níger',
            ],
            [
                'paisid' => 188,
                'paisnom' => 'Norfolk Island',
            ],
            [
                'paisid' => 189,
                'paisnom' => 'Omán',
            ],
            [
                'paisid' => 190,
                'paisnom' => 'Isla Pitcairn',
            ],
            [
                'paisid' => 191,
                'paisnom' => 'Qatar',
            ],
            [
                'paisid' => 192,
                'paisnom' => 'Ruanda',
            ],
            [
                'paisid' => 193,
                'paisnom' => 'Santa Elena',
            ],
            [
                'paisid' => 194,
                'paisnom' => 'San Cristobal y Nevis',
            ],
            [
                'paisid' => 195,
                'paisnom' => 'Santa Lucía',
            ],
            [
                'paisid' => 196,
                'paisnom' => 'San Pedro y Miquelón',
            ],
            [
                'paisid' => 197,
                'paisnom' => 'San Vincente y Granadinas',
            ],
            [
                'paisid' => 198,
                'paisnom' => 'Samoa',
            ],
            [
                'paisid' => 199,
                'paisnom' => 'San Marino',
            ],
            [
                'paisid' => 200,
                'paisnom' => 'San Tomé y Príncipe',
            ],
        ]);

        $this->db->table('sgc_paises')->insertBatch([
            [
                'paisid' => 201,
                'paisnom' => 'Serbia y Montenegro',
            ],
            [
                'paisid' => 202,
                'paisnom' => 'Sierra Leona',
            ],
            [
                'paisid' => 203,
                'paisnom' => 'Islas Salomón',
            ],
            [
                'paisid' => 204,
                'paisnom' => 'Somalia',
            ],
            [
                'paisid' => 205,
                'paisnom' => 'Sudán',
            ],
            [
                'paisid' => 206,
                'paisnom' => 'Swazilandia',
            ],
            [
                'paisid' => 207,
                'paisnom' => 'Tokelau',
            ],
            [
                'paisid' => 208,
                'paisnom' => 'Tonga',
            ],
            [
                'paisid' => 209,
                'paisnom' => 'Trinidad y Tobago',
            ],
            [
                'paisid' => 210,
                'paisnom' => 'Tuvalu',
            ],
            [
                'paisid' => 211,
                'paisnom' => 'Vanuatu',
            ],
            [
                'paisid' => 212,
                'paisnom' => 'Wallis y Futuna',
            ],
            [
                'paisid' => 213,
                'paisnom' => 'Sáhara Occidental',
            ],
            [
                'paisid' => 214,
                'paisnom' => 'Yemen',
            ],
            [
                'paisid' => 215,
                'paisnom' => 'Puerto Rico',
            ],
            [
                'paisid' => 216,
                'paisnom' => 'N/A',
            ],
        ]);

    }
}

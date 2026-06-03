<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Main Seeder — ejecuta todos los seeders en el orden correcto.
 *
 * Uso:
 *   php spark db:seed MainSeeder
 */
class MainSeeder extends Seeder
{
    public function run()
    {
        // 1. Roles (requerido por UsuarioOperador)
        $this->call('RolesSeeder');

        // 2. Usuario admin
        $this->call('UsuarioOperadorSeeder');

        // 3. Catálogos base (sin dependencias)
        $this->call('PaisesSeeder');
        $this->call('EstatusSeeder');
        $this->call('EstatusLlamadasSeeder');
        $this->call('EnteAsdcritoSeeder');
        $this->call('OficinasSeeder');
        $this->call('OrgPodPopularSeeder');
        $this->call('RedSocialSeeder');
        $this->call('TipoBeneficiariosSeeder');
        $this->call('TipoPropIntelecSeeder');
        $this->call('TercerosSeeder');
        $this->call('TipoatencionUsuSeeder');
        $this->call('TipoatenciondetalleSeeder');
        $this->call('DireccionesAdministrativasSeeder');
        $this->call('ViaTipoAtencionSeeder');
        $this->call('MotivosSeeder');

        // 4. Dependen de PaisesSeeder
        $this->call('EstadosSeeder');

        // 5. Depende de EstadosSeeder
        $this->call('MunicipioSeeder');

        // 6. Depende de MunicipioSeeder
        $this->call('ParroquiasSeeder');

        // 7. Depende de TercerosSeeder
        $this->call('MediacionSeeder');
    }
}

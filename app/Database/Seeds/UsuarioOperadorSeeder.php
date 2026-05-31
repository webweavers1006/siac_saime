<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Seeder for sgc_usuario_operador — creates default admin user
 *
 * Default credentials:
 *   Email: admin@sala-situacional.test
 *   Password: admin123
 */
class UsuarioOperadorSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('sgc_usuario_operador')->truncate();

        // Reset the sequence after truncate (PostgreSQL)
        $this->db->query("ALTER SEQUENCE sgc_usuario_operador_idusuopr_seq RESTART WITH 1");

        $this->db->table('sgc_usuario_operador')->insertBatch([
            [
                'idusuopr'                      => 1,
                'usuopnom'                      => 'Admin',
                'usuopape'                      => 'Sistema',
                'usuoppass'                     => password_hash('admin123', PASSWORD_BCRYPT),
                'usuopemail'                    => 'admin@sala-situacional.test',
                'idrol'                         => 5, // Administrador
                'usuopborrado'                  => false,
                'usercargo'                     => 'Administrador del Sistema',
                'id_direccion_administrativa'   => null,
                'acceso_audi'                   => false,
            ],
        ]);
    }
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class Entes_asdcritos_Model extends BaseModel
{
    
    // Método para listar entes adscritos
    public function listar_Entes_asdcritos()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('sgc_ente_asdcrito');
        $builder->select('ente_id, ente_nombre');
        $builder->where('borrado', false);
        $query = $builder->get();
        $resultado = $query->getResult();
        return $resultado;
    }
}

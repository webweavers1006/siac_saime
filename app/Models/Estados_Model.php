<?php

namespace App\Models;

use CodeIgniter\Model;

class Estados_Model extends BaseModel
{
   

    // Método para listar estados
public function listar_Estados()
{
    $db = \Config\Database::connect();
    $builder = $db->table('sgc_estados AS estds');
    $builder->select('estds.estadoid, estds.estadonom');
    $builder->where('estds.borrado', false);
    $query = $builder->get();
    $resultado = $query->getResult();
    return $resultado;
}
}

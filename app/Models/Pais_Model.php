<?php

namespace App\Models;

use CodeIgniter\Model;

class Pais_Model extends BaseModel
{
   

    // Método para listar estados
public function llenar_pais()
{
    $db = \Config\Database::connect();
    $builder = $db->table('sgc_paises AS p');
    $builder->select('p.paisid, p.paisnom');
    $query = $builder->get();
    $resultado = $query->getResult();
    return $resultado;
}
}

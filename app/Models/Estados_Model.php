<?php

namespace App\Models;

use CodeIgniter\Model;

class Estados_Model extends BaseModel
{
    public function listar_Estados()
    {
        $db      = \Config\Database::connect();
        $strQuery = "SELECT estds.estadoid,estds.estadonom ";
        $strQuery .= "FROM public.sgc_estados as estds WHERE estds.borrado='false' ";
        $query = $db->query($strQuery);
        $resultado = $query->getResult();
        return $resultado;
    }
}

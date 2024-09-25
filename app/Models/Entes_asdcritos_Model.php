<?php

namespace App\Models;

use CodeIgniter\Model;

class Entes_asdcritos_Model extends BaseModel
{
    public function listar_Entes_asdcritos()
    {
        $db      = \Config\Database::connect();
        $strQuery = "SELECT ente_id,ente_nombre ";
        $strQuery .= "FROM public.sgc_ente_asdcrito  WHERE borrado='false' ";
        $query = $db->query($strQuery);
        $resultado = $query->getResult();
        return $resultado;
    }
}

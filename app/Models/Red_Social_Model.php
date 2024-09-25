<?php

namespace App\Models;

use CodeIgniter\Model;

class Red_Social_Model extends BaseModel
{
    public function listar_Red_Social()
    {
        $db      = \Config\Database::connect();
        $strQuery = "SELECT red_s_id,red_s_nom ";
        $strQuery .= "FROM public.sgc_red_social  WHERE red_s_borrado='false' ";
        $query = $db->query($strQuery);
        $resultado = $query->getResult();
        return $resultado;
    }

    public function listar_Red_Social_filtro()
    {
        $db      = \Config\Database::connect();
        $strQuery = "SELECT red_s_id,red_s_nom ";
        $strQuery .= "FROM public.sgc_red_social  WHERE red_s_borrado='false' and red_s_id <> '3'";
        $query = $db->query($strQuery);
        $resultado = $query->getResult();
        return $resultado;
    }
    


}

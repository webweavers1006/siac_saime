<?php

namespace App\Models;

class Documentos_casos_Model extends BaseModel
{
    //Metodo que busca los ducumentos en funsion de los id de los casos 
    public function buscar_documentos_casos($idcaso = null)
    {
        $builder = $this->dbconn('sgc_documentos_casos');
        $builder->where('docu_id_caso=', $idcaso);
        $query = $builder->get();
        return $query;
    }

  

    // Método para buscar documentos de un caso
    public function buscar_documentos($idcaso = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('sgc_documentos_casos AS c');
        $builder->select('c.docu_id_caso, c.docu_ruta');
        if ($idcaso !== null) {
            $builder->where('c.docu_id_caso', $idcaso);
        }

        $query = $builder->get();
        $resultado = $query->getResult();
        return $resultado;
}

}

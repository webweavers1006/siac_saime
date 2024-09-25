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

     //Metodo que busca los ducumentos  en funsion de los id de los casos para eviarlos al correo
     public function buscar_documentos($idcaso = null)
     {
 

        $db      = \Config\Database::connect();
        $strQuery = "SELECT c.docu_id_caso,c.docu_ruta ";
        $strQuery .= "FROM sgc_documentos_casos as c  WHERE c.docu_id_caso=$idcaso";
        $query = $db->query($strQuery);
        //return   $strQuery;
        $resultado = $query->getResult();
        return $resultado;
       
     }
}

<?php

namespace App\Models;

class Registro_cgr_Model extends BaseModel
{
    //Metodo para insertar un nuevo caso en la BD
    public function insertarRegistro_cgr(array $cgr)
    {
        $builder = $this->dbconn('sgc_registro_cgr');
        $query = $builder->insert($cgr);
        return $query;
    }

    //Metodo para actualizar un caso en la BD
    public function AtualizarCasos_cgr($cgr)
    {
        $builder = $this->dbconn('sgc_registro_cgr');
        $query = $builder->update($cgr, 'id_caso = ' . $cgr['id_caso']);
        return $query;
    }
    //Buscar si existe el id de casos 
    public function verificar_id_caso_CGR($idcaso = null)
    {
        $db      = \Config\Database::connect();
        $strQuery = "SELECT id_cgr ";
        $strQuery .= "FROM sgc_registro_cgr  WHERE id_caso=$idcaso";
        $query = $db->query($strQuery);
        $resultado = $query->getResult();
        return $resultado;
    }





    
}

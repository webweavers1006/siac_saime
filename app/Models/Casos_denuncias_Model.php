<?php

namespace App\Models;

class Casos_denuncias_Model extends BaseModel
{
    //Metodo para insertar un nuevo caso en la BD
    public function insertarCasos_Denuncias($denuncia)
    {
        $builder = $this->dbconn('sgc_casos_denuncias');
        $query = $builder->insert($denuncia);
        return $query;
    }
    //Metodo para actualizar un caso en la BD
    public function AtualizarCasos_Denuncias($denuncia)
    {

        $builder = $this->dbconn('sgc_casos_denuncias');
        $query = $builder->update($denuncia, 'denu_id_caso = ' . $denuncia['denu_id_caso']);
        return $query;
    }
    //Buscar si existe el id de casos 
    public function verificar_id_caso_denuncia($idcaso = null)
    {
        $db      = \Config\Database::connect();
        $strQuery = "SELECT denu_id ";
        $strQuery .= "FROM sgc_casos_denuncias  WHERE denu_id_caso=$idcaso";
        $query = $db->query($strQuery);
        $resultado = $query->getResult();
        return $resultado;
    }
    //Metodo para obtener todas las denuncias
    public function info_denuncias($idcaso)
    {

        $db      = \Config\Database::connect();
        $strQuery = "SELECT denu_afecta_persona,denu_afecta_comunidad,denu_afecta_terceros,denu_involucrados ";
        $strQuery .= ",to_char(denu_fecha_hechos,'dd/mm/yyyy') as denu_fecha_hechos ";
        $strQuery .= ",denu_instancia_popular,denu_rif_instancia,denu_ente_financiador,denu_nombre_proyecto,denu_monto_aprovado ";
        $strQuery .= ",denu_id_caso,denu_borrado ";
        $strQuery .= "FROM sgc_casos_denuncias ";
        $strQuery .= " where denu_id_caso='$idcaso'  ";
        $query = $db->query($strQuery);
        $resultado = $query->getResult();
        return $resultado;
    }
}

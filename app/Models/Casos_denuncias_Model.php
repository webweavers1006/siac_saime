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
        $db = \Config\Database::connect();
        $builder = $db->table('sgc_casos_denuncias');
        $builder->select('denu_id');
        $builder->where('denu_id_caso', $idcaso);
        $query = $builder->get();
        $resultado = $query->getResult();
        return $resultado;
    }
    public function info_denuncias($idcaso)
{
    $db = \Config\Database::connect();
    $builder = $db->table('sgc_casos_denuncias');
    $builder->select('denu_afecta_persona, denu_afecta_comunidad, denu_afecta_terceros, denu_involucrados, 
                      to_char(denu_fecha_hechos, \'dd/mm/yyyy\') as denu_fecha_hechos, 
                      denu_instancia_popular, denu_rif_instancia, denu_ente_financiador, 
                      denu_nombre_proyecto, denu_monto_aprovado, denu_id_caso, denu_borrado');
    $builder->where('denu_id_caso', $idcaso);
    $query = $builder->get();
    $resultado = $query->getResult();
    return $resultado;
}
}

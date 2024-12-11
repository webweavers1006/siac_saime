<?php

namespace App\Models;

class Pdf_Model extends BaseModel
{

    //Metodo para obtener todas las direcciones
    public function obtenerCasos($idcaso = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('sgc_casos AS a');
    
        $builder->select([
            'a.tipo_beneficiario',
            'a.idcaso',
            'a.casotel',
            'TRIM(a.casoced) AS casoced',
            'a.casonom',
            'a.casoape',
            'a.casodesc',
            'a.caso_nacionalidad',
            'a.idrrss',
            'a.ofiid',
            'a.estadoid',
            'a.id_tipo_atencion',
            'a.municipioid',
            'a.parroquiaid',
            'a.direccion',
            'a.correo',
            'a.caso_hora',
            'u_ope.usercargo',
            'mun.municipionom',
            'parr.parroquianom',
            'cgr.competencia_cgr',
            'cgr.asume_cgr',
            'ente.ente_nombre',
            'CONCAT(a.caso_nacionalidad, a.casoced) AS cedula',
            'CONCAT(a.casonom, \' \', \' \', a.casoape) AS nombre',
            'CONCAT(u_ope.usuopnom, \' \', \' \', u_ope.usuopape) AS user_name',
            "CASE WHEN sexo='1' THEN 'M' ELSE 'F' END AS sexo",
            "to_char(a.casofec, 'dd/mm/yyyy') AS casofec",
            'a.casofec AS casofec_normal',
            'b.estnom',
            'tpinte.tipo_prop_nombre',
            'tpinte.tipo_prop_id',
            't_antusu.tipo_aten_nombre'
        ]);
    
        $builder->join('sgc_estatus AS b', 'b.idest = a.idest');
        $builder->join('sgc_usuario_operador AS u_ope', 'a.idusuopr = u_ope.idusuopr');
        $builder->join('sgc_tipo_prop_caso AS tpc', 'a.idcaso = tpc.idcaso');
        $builder->join('sgc_tipo_prop_intelec AS tpinte', 'tpc.idtippropint = tpinte.tipo_prop_id');
        $builder->join('sgc_tipoatencion_usu AS t_antusu', 'a.id_tipo_atencion = t_antusu.tipo_aten_id');
        $builder->join('sgc_municipio AS mun', 'a.municipioid = mun.municipioid');
        $builder->join('sgc_parroquias AS parr', 'a.parroquiaid = parr.parroquiaid');
        $builder->join('sgc_registro_cgr AS cgr', 'a.idcaso = cgr.id_caso', 'left');
        $builder->join('sgc_ente_asdcrito AS ente', 'a.ente_adscrito_id = ente.ente_id', 'left');
    
        $builder->where('a.borrado', 'false');
    
        if ($idcaso) {
            $builder->where('a.idcaso', $idcaso);
        }
    
        $builder->orderBy('a.idcaso', 'DESC');
    
        $query = $builder->get();
        $resultado = $query->getResult();
       // echo $db->getLastQuery(); 
        return $resultado;
    }
}

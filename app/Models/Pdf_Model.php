<?php

namespace App\Models;

class Pdf_Model extends BaseModel
{

    //Metodo para obtener todas las direcciones
    public function obtenerCasos($idcaso = null)
    {

        $db      = \Config\Database::connect();
        $strQuery = "SELECT a.tipo_beneficiario,a.idcaso,a.casotel,TRIM(a.casoced) AS casoced,a.casonom,a.casoape,a.casodesc";
        $strQuery .= ",a.caso_nacionalidad,a.idrrss,a.ofiid,a.estadoid,a.id_tipo_atencion";
        $strQuery .= ",a.municipioid,a.parroquiaid,a.direccion,a.correo,a.caso_hora,u_ope.usercargo";
        $strQuery .= ",mun.municipionom,parr.parroquianom";
        $strQuery .= ",cgr.competencia_cgr,cgr.asume_cgr";
        $strQuery .= ",ente.ente_nombre";
        $strQuery .= ",CONCAT(a.caso_nacionalidad,a.casoced) AS cedula";
        $strQuery .= ",CONCAT(a.casonom, ' ',' ', a.casoape) AS nombre";
        $strQuery .= ",CONCAT(u_ope.usuopnom, ' ',' ', u_ope.usuopape) AS user_name";
        $strQuery .= ",case when sexo='1'then 'M' else 'F' end as sexo ";
        $strQuery .= ",to_char(a.casofec,'dd/mm/yyyy') as casofec,a.casofec as casofec_normal,b.estnom ";
        $strQuery .= ",tpinte.tipo_prop_nombre ";
        $strQuery .= ",tpinte.tipo_prop_id ";
        $strQuery .= ",t_antusu.tipo_aten_nombre ";
        $strQuery .= "FROM sgc_casos a ";
        $strQuery .= " join sgc_estatus b on b.idest = a.idest  ";
        $strQuery .= " join sgc_usuario_operador u_ope on a.idusuopr = u_ope.idusuopr  ";
        $strQuery .= " join sgc_tipo_prop_caso as tpc on a.idcaso=tpc.idcaso  ";
        $strQuery .= " join sgc_tipo_prop_intelec as tpinte on tpc.idtippropint=tpinte.tipo_prop_id  ";
        $strQuery .= " join sgc_tipoatencion_usu as t_antusu on a.id_tipo_atencion=t_antusu.tipo_aten_id  ";
        $strQuery .= " join sgc_municipio as mun on a.municipioid=mun.municipioid ";
        $strQuery .= " join sgc_parroquias as parr on a.parroquiaid=parr.parroquiaid ";
        $strQuery .= " left join sgc_registro_cgr cgr on a.idcaso=cgr.id_caso  ";
        $strQuery .= " left join sgc_ente_asdcrito as ente on a.ente_adscrito_id=ente.ente_id ";
        $strQuery .= " where a.borrado='false'  ";
        $strQuery .= " AND a.idcaso=$idcaso   ";
        $strQuery .= " ORDER BY a.idcaso  desc";
        $query = $db->query($strQuery);
        $resultado = $query->getResult();
        return $resultado;
    }
}

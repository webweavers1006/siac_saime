<?php

namespace App\Models;

class Casos extends BaseModel
{

    


    //Metodo para obtener todos los casos 
    public function obtenerCasos()
    {
        $db      = \Config\Database::connect();
        $strQuery = "SELECT distinct a.idcaso, a.tipo_beneficiario,a.casotel,TRIM(a.casoced) AS casoced,a.casonom,a.casoape,a.casodesc";
        $strQuery .= ",a.caso_nacionalidad,a.idrrss,a.ofiid,a.estadoid,a.id_tipo_atencion";
        $strQuery .= ",a.edad,to_char(a.fecha_nacimiento,'dd/mm/yyyy') as fecha_nacimiento,a.fecha_nacimiento as fecha_nacimiento_normal";
        $strQuery .= ",a.municipioid,a.parroquiaid,a.direccion,a.correo,a.ente_adscrito_id,a.profesion";
        $strQuery .= ",CONCAT(a.caso_nacionalidad,a.casoced) AS cedula";
        $strQuery .= ",cgr.competencia_cgr,cgr.asume_cgr";
        $strQuery .= ",denu.denu_afecta_persona,denu.denu_afecta_comunidad,denu.denu_afecta_terceros";
        $strQuery .= ",denu.denu_involucrados,denu.denu_fecha_hechos,denu.denu_instancia_popular";
        $strQuery .= ",denu.denu_rif_instancia,denu.denu_ente_financiador,denu.denu_nombre_proyecto,denu.denu_monto_aprovado";
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
        $strQuery .= " left join sgc_tipo_prop_caso as tpc on a.idcaso=tpc.idcaso  ";
        $strQuery .= " left join sgc_tipo_prop_intelec as tpinte on tpc.idtippropint=tpinte.tipo_prop_id  ";
        $strQuery .= " join sgc_tipoatencion_usu as t_antusu on a.id_tipo_atencion=t_antusu.tipo_aten_id  ";
        $strQuery .= " left join sgc_registro_cgr cgr on a.idcaso=cgr.id_caso  ";
        $strQuery .= " left join sgc_casos_denuncias denu on a.idcaso=denu_id_caso ";
        $strQuery .= " where a.borrado='false'  ";
        $strQuery .= " ORDER BY a.idcaso  desc";
        $query = $db->query($strQuery);
        $resultado = $query->getResult();
        return $resultado;
    
    }
//Metodo para obtener todos los casos 
public function listar_Casos_Remitidos($id_direccion)
{
   
    $db      = \Config\Database::connect();
    $strQuery = "SELECT cr.casos_id,CONCAT(a.caso_nacionalidad,a.casoced) AS cedula,CONCAT(a.casonom,' ',a.casoape) AS beneficiario,";
    $strQuery .= " a.casotel, a.tipo_beneficiario,tpinte.tipo_prop_nombre,t_antusu.tipo_aten_nombre,to_char(a.casofec,'dd\/mm\/yyyy') as casofec";
    $strQuery .= ",a.municipioid,a.parroquiaid,a.direccion,a.correo,a.ente_adscrito_id";
    $strQuery .= ",TRIM(a.casoced) AS casoced";
    $strQuery .= ",cr.direccion_id,dire.correo,a.casodesc,a.caso_nacionalidad,a.idrrss,a.ofiid,a.estadoid, ";
    $strQuery .= "a.id_tipo_atencion,a.municipioid,a.parroquiaid,a.direccion,a.correo,a.ente_adscrito_id ";
    $strQuery .= ",cgr.competencia_cgr,cgr.asume_cgr,denu.denu_afecta_persona ";
    $strQuery .= ",denu.denu_afecta_comunidad,denu.denu_afecta_terceros,denu.denu_involucrados,denu.denu_fecha_hechos ";
    $strQuery .= ",denu.denu_instancia_popular,denu.denu_rif_instancia,denu.denu_ente_financiador,denu.denu_nombre_proyecto ";
    $strQuery .= ",denu.denu_monto_aprovado,CONCAT(a.casonom, ' ',' ', a.casoape) AS nombre ";
    $strQuery .= ",CONCAT(u_ope.usuopnom, ' ',' ', u_ope.usuopape) AS user_name,case when sexo='1'then 'M' else 'F' end as sexo  ";
    $strQuery .= ",a.casofec as casofec_normal,b.estnom ";
    $strQuery .= ",tpinte.tipo_prop_id  ";
    $strQuery .= "from  ";
    $strQuery .= "sgc_casos_remitidos as cr ";
    $strQuery .= "join sgc_direcciones_administrativas as dire on cr.direccion_id = dire.id ";
    $strQuery .= "join sgc_casos as a on cr.casos_id = a.idcaso ";
    $strQuery .= "join sgc_estatus b on b.idest = a.idest  ";
    $strQuery .= "join sgc_usuario_operador u_ope on a.idusuopr = u_ope.idusuopr  ";
    $strQuery .= "left join sgc_tipo_prop_caso as tpc on a.idcaso=tpc.idcaso ";
    $strQuery .= "left join sgc_tipo_prop_intelec as tpinte on tpc.idtippropint=tpinte.tipo_prop_id ";
    $strQuery .= "join sgc_tipoatencion_usu as t_antusu on a.id_tipo_atencion=t_antusu.tipo_aten_id ";
    $strQuery .= "left join sgc_registro_cgr cgr on a.idcaso=cgr.id_caso ";
    $strQuery .= "left join sgc_casos_denuncias denu on a.idcaso=denu_id_caso ";
    $strQuery .= " where cr.direccion_id='$id_direccion'";
    $strQuery .= " ORDER BY a.idcaso  desc";
    $query = $db->query($strQuery);
    $resultado = $query->getResult();
    return $resultado;
}


  //Metodo para obtener todos los casos por usuario
  public function obtenerCasos_filtrados_por_usuario($idusur)
  {
    
      $db      = \Config\Database::connect();
      $strQuery = "SELECT  distinct a.idcaso,a.tipo_beneficiario,a.casotel,TRIM(a.casoced) AS casoced,a.casonom,a.casoape,a.casodesc";
      $strQuery .= ",a.caso_nacionalidad,a.idrrss,a.ofiid,a.estadoid,a.id_tipo_atencion";
      $strQuery .= ",a.municipioid,a.parroquiaid,a.direccion,a.correo,a.ente_adscrito_id,a.profesion";
      $strQuery .= ",a.edad,to_char(a.fecha_nacimiento,'dd/mm/yyyy') as fecha_nacimiento,a.fecha_nacimiento as fecha_nacimiento_normal,a.profesion";
      $strQuery .= ",CONCAT(a.caso_nacionalidad,a.casoced) AS cedula";
      $strQuery .= ",cgr.competencia_cgr,cgr.asume_cgr";
      $strQuery .= ",denu.denu_afecta_persona,denu.denu_afecta_comunidad,denu.denu_afecta_terceros";
      $strQuery .= ",denu.denu_involucrados,denu.denu_fecha_hechos,denu.denu_instancia_popular";
      $strQuery .= ",denu.denu_rif_instancia,denu.denu_ente_financiador,denu.denu_nombre_proyecto,denu.denu_monto_aprovado";
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
      $strQuery .= " left join sgc_tipo_prop_caso as tpc on a.idcaso=tpc.idcaso  ";
      $strQuery .= " left join sgc_tipo_prop_intelec as tpinte on tpc.idtippropint=tpinte.tipo_prop_id  ";
      $strQuery .= " join sgc_tipoatencion_usu as t_antusu on a.id_tipo_atencion=t_antusu.tipo_aten_id  ";
      $strQuery .= " left join sgc_registro_cgr cgr on a.idcaso=cgr.id_caso  ";
      $strQuery .= " left join sgc_casos_denuncias denu on a.idcaso=denu_id_caso ";
      $strQuery .= " where a.borrado='false'  ";
      $strQuery .= " and a.idusuopr=$idusur ";
      $strQuery .= " ORDER BY a.idcaso  desc";
     $query = $db->query($strQuery);
     $resultado = $query->getResult();
      return $resultado;
  }


    









// //Metodo para obtener toda la informacion del caso para la web 
// public function Informacion_Usuarios($casoced)
// {
   
//     $db      = \Config\Database::connect();
//     $strQuery = "SELECT a.tipo_beneficiario,a.idcaso,a.casotel,TRIM(a.casoced) AS casoced,a.casonom,a.casoape,a.casodesc";
//     $strQuery .= ",a.caso_nacionalidad,a.idrrss,a.ofiid,a.estadoid,a.id_tipo_atencion";
//     $strQuery .= ",a.municipioid,a.parroquiaid,a.direccion,a.correo,a.ente_adscrito_id";
//     $strQuery .= ",CONCAT(a.caso_nacionalidad,a.casoced) AS cedula";
//     $strQuery .= ",cgr.competencia_cgr,cgr.asume_cgr";
//     $strQuery .= ",denu.denu_afecta_persona,denu.denu_afecta_comunidad,denu.denu_afecta_terceros";
//     $strQuery .= ",denu.denu_involucrados,denu.denu_fecha_hechos,denu.denu_instancia_popular";
//     $strQuery .= ",denu.denu_rif_instancia,denu.denu_ente_financiador,denu.denu_nombre_proyecto,denu.denu_monto_aprovado";
//     $strQuery .= ",CONCAT(a.casonom, ' ',' ', a.casoape) AS nombre";
//     $strQuery .= ",CONCAT(u_ope.usuopnom, ' ',' ', u_ope.usuopape) AS user_name";
//     $strQuery .= ",case when sexo='1'then 'M' else 'F' end as sexo ";
//     $strQuery .= ",to_char(a.casofec,'dd/mm/yyyy') as casofec,a.casofec as casofec_normal,b.estnom ";
//     $strQuery .= ",tpinte.tipo_prop_nombre ";
//     $strQuery .= ",tpinte.tipo_prop_id ";
//     $strQuery .= ",t_antusu.tipo_aten_nombre ";
//     $strQuery .= "FROM sgc_casos a ";
//     $strQuery .= " join sgc_estatus b on b.idest = a.idest  ";
//     $strQuery .= " join sgc_usuario_operador u_ope on a.idusuopr = u_ope.idusuopr  ";
//     $strQuery .= " join sgc_tipo_prop_caso as tpc on a.idcaso=tpc.idcaso  ";
//     $strQuery .= " join sgc_tipo_prop_intelec as tpinte on tpc.idtippropint=tpinte.tipo_prop_id  ";
//     $strQuery .= " join sgc_tipoatencion_usu as t_antusu on a.id_tipo_atencion=t_antusu.tipo_aten_id  ";
//     $strQuery .= " left join sgc_registro_cgr cgr on a.idcaso=cgr.id_caso  ";
//     $strQuery .= " left join sgc_casos_denuncias denu on a.idcaso=denu_id_caso ";
//     $strQuery .= " where a.borrado='false'  ";
//     $strQuery .= " and a.casoced='$casoced' ";
//     $strQuery .= " ORDER BY a.idcaso  desc";
//     $query = $db->query($strQuery);
//     $resultado = $query->getResult();
//     return $resultado;
// }


//Metodo para obtener toda la informacion del caso para la web 
public function Informacion_Usuarios($casoced)
{

// Validar que la cédula sea un número entero
if (!filter_var($casoced, FILTER_VALIDATE_INT)) {

   die("La cédula debe ser un número entero válido.");

}


    $db = \Config\Database::connect();

    // Utiliza el Query Builder
    $builder = $db->table('sgc_casos a');
    
    // Selecciona las columnas
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
        'a.ente_adscrito_id',
        "CONCAT(a.caso_nacionalidad, a.casoced) AS cedula",
        'cgr.competencia_cgr',
        'cgr.asume_cgr',
        'denu.denu_afecta_persona',
        'denu.denu_afecta_comunidad',
        'denu.denu_afecta_terceros',
        'denu.denu_involucrados',
        'denu.denu_fecha_hechos',
        'denu.denu_instancia_popular',
        'denu.denu_rif_instancia',
        'denu.denu_ente_financiador',
        'denu.denu_nombre_proyecto',
        'denu.denu_monto_aprovado',
        "CONCAT(a.casonom, ' ', a.casoape) AS nombre",
        "CONCAT(u_ope.usuopnom, ' ', u_ope.usuopape) AS user_name",
        "CASE WHEN sexo = '1' THEN 'M' ELSE 'F' END AS sexo",
        "TO_CHAR(a.casofec, 'dd/mm/yyyy') AS casofec",
        'a.casofec AS casofec_normal',
        'b.estnom',
        'tpinte.tipo_prop_nombre',
        'tpinte.tipo_prop_id',
        't_antusu.tipo_aten_nombre'
    ]);

    // Realiza los joins
    $builder->join('sgc_estatus b', 'b.idest = a.idest');
    $builder->join('sgc_usuario_operador u_ope', 'a.idusuopr = u_ope.idusuopr');
    $builder->join('sgc_tipo_prop_caso tpc', 'a.idcaso = tpc.idcaso');
    $builder->join('sgc_tipo_prop_intelec tpinte', 'tpc.idtippropint = tpinte.tipo_prop_id');
    $builder->join('sgc_tipoatencion_usu t_antusu', 'a.id_tipo_atencion = t_antusu.tipo_aten_id');
    $builder->join('sgc_registro_cgr cgr', 'a.idcaso = cgr.id_caso', 'left');
    $builder->join('sgc_casos_denuncias denu', 'a.idcaso = denu_id_caso', 'left');

    // Establece las condiciones
    $builder->where('a.borrado', 'false');
    $builder->where('a.casoced', $casoced);

    // Ordena los resultados
    $builder->orderBy('a.idcaso', 'desc');

    // Ejecuta la consulta y obtiene los resultados
    $query = $builder->get();
    return $query->getResult();
}




    //Metodo para obtener el caso en funsion del id 
    public function obtenerCaso_id()
    {
        $db      = \Config\Database::connect();
        $strQuery = "SELECT a.tipo_beneficiario,a.idcaso,a.casotel,TRIM(a.casoced) AS casoced,a.casonom,a.casoape,a.casodesc";
        $strQuery .= ",a.caso_nacionalidad,a.idrrss,a.ofiid,a.estadoid,a.id_tipo_atencion";
        $strQuery .= ",a.municipioid,a.parroquiaid,a.direccion,a.correo,a.ente_adscrito_id";
        $strQuery .= ",CONCAT(a.caso_nacionalidad,a.casoced) AS cedula";
        $strQuery .= ",cgr.competencia_cgr,cgr.asume_cgr";
        $strQuery .= ",denu.denu_afecta_persona,denu.denu_afecta_comunidad,denu.denu_afecta_terceros";
        $strQuery .= ",denu.denu_involucrados,denu.denu_fecha_hechos,denu.denu_instancia_popular";
        $strQuery .= ",denu.denu_rif_instancia,denu.denu_ente_financiador,denu.denu_nombre_proyecto,denu.denu_monto_aprovado";
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
        $strQuery .= " left join sgc_registro_cgr cgr on a.idcaso=cgr.id_caso  ";
        $strQuery .= " left join sgc_casos_denuncias denu on a.idcaso=denu_id_caso ";
        $strQuery .= " where a.borrado='false'  ";
        $strQuery .= " ORDER BY a.idcaso  desc";
        $query = $db->query($strQuery);
        $resultado = $query->getResult();
        return $resultado;
    }
    //Metodo para obtener EL ULTIMO ID INSERTADO
    public function obtener_utimo_id()
    {
        $builder = $this->dbconn('public.sgc_casos');
        $builder->select(
            " MAX(idcaso) as ultimo_id"
        );
        $query = $builder->get();
        return $query;
    }
    //Metodo para consultar los ultimos veinte casos por usuario
    public function obtener_ultimos_casos(String $iduser)
    {
        $db      = \Config\Database::connect();
        $strQuery = "SELECT a.idcaso,a.casotel,a.casoced,";
        $strQuery .= " CONCAT(a.casonom, ' ',' ', a.casoape) AS nombre";
        $strQuery .= " ,case when sexo='1'then 'M' else 'F' end as sexo ";
        $strQuery .= ",to_char(a.casofec,'dd/mm/yyyy') as casofec,a.casofec as casofec_normal,b.estnom ";
        $strQuery .= ",tpinte.tipo_prop_nombre ";
        $strQuery .= ",t_antusu.tipo_aten_nombre ";
        $strQuery .= "FROM sgc_casos a ";
        $strQuery .= " join sgc_estatus b on b.idest = a.idest  ";
        $strQuery .= " join sgc_usuario_operador c on a.idusuopr = c.idusuopr  ";
        $strQuery .= " join sgc_tipo_prop_caso as tpc on a.idcaso=tpc.idcaso  ";
        $strQuery .= " join sgc_tipo_prop_intelec as tpinte on tpc.idtippropint=tpinte.tipo_prop_id  ";
        $strQuery .= " join sgc_tipoatencion_usu as t_antusu on a.id_tipo_atencion=t_antusu.tipo_aten_id  ";
        $strQuery .= "where a.idusuopr= $iduser ";
        $strQuery .= " ORDER BY a.idcaso  DESC";
        $strQuery .= " limit(20)";
        $query = $db->query($strQuery);
        $resultado = $query->getResult();
        return $resultado;
    }
    //Metodo para insertar un nuevo caso en la BD
    public function insertarNuevoCaso(array $datos)
    {
        $builder = $this->dbconn('sgc_casos');
        date_default_timezone_set('America/Caracas');
        $hora = date("H:i:s A");
        $datos['caso_hora'] = $hora;
        $query = $builder->insert($datos);
        return $query;
    }
    //Metodo para   actualizar  us Caso en la BD
    public function actualizarCaso(array $datos)
    {
        $builder = $this->dbconn('sgc_casos');
        $query = $builder->update($datos, 'idcaso = ' . $datos["idcaso"]);
        return $query;
    }
    //Metodo para obtener el detalle de un solo caso
    public function detalleCaso(String $idcaso)
    {
        $db      = \Config\Database::connect();
        $strQuery = "SELECT  a.idcaso,a.casotel,TRIM(a.casoced) AS casoced,a.casonom,a.casoape,a.casodesc";
        $strQuery .= ",a.caso_nacionalidad,a.idrrss,a.ofiid,a.estadoid,a.id_tipo_atencion,a.ente_adscrito_id";
        $strQuery .= ",a.municipioid,a.parroquiaid,a.direccion,a.correo";
        $strQuery .= ",CASE WHEN direc.descripcion IS null then 'No Aplica' Else  direc.descripcion  end as unidad_administrativa ";
        $strQuery .= ",est.estadonom";
        $strQuery .= ",mun.municipionom";
        $strQuery .= ",p.parroquianom";
        $strQuery .= ",u_ope.usuopemail";
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
        $strQuery .= " join sgc_estados est on est.estadoid = a.estadoid  ";
        $strQuery .= " join sgc_municipio mun on mun.municipioid = a.municipioid ";
        $strQuery .= " join sgc_parroquias p on p.parroquiaid = a.parroquiaid";
        $strQuery .= " join sgc_usuario_operador u_ope on a.idusuopr = u_ope.idusuopr  ";
        $strQuery .= " join sgc_tipo_prop_caso as tpc on a.idcaso=tpc.idcaso  ";
        $strQuery .= " join sgc_tipo_prop_intelec as tpinte on tpc.idtippropint=tpinte.tipo_prop_id  ";
        $strQuery .= " join sgc_tipoatencion_usu as t_antusu on a.id_tipo_atencion=t_antusu.tipo_aten_id  ";
        $strQuery .= " left join sgc_casos_remitidos as casos_remi on a.idcaso=casos_remi.casos_id  ";
        $strQuery .= " left join sgc_direcciones_administrativas as direc on casos_remi.direccion_id=direc.id  ";
        $strQuery .= " WHERE a.idcaso= $idcaso";
        $strQuery .= " ORDER BY casofec_normal  ASC";
        // return  $strQuery;
        $query = $db->query($strQuery);
        $resultado = $query->getResult();
        return $resultado;
    }



    //Metodo para obtener todos los casos para el reporte consolidado 
    public function reporte_consolidado($desde = null, $hasta = null, $tipo_pi = null, $tipo_atencion_usu = null, $sexo = null, $via_atencion = null, $direcciones_caso = null, $tipo_beneficiario = 0,$atencion_cuidadano = 0,$estatus = 0,$id_estado=0,$id_municipio=0,$edad_min=null,$edad_max=null)
    {
     

        $db      = \Config\Database::connect();
        $strQuery = "SELECT caso_r.casos_re_id,a.idcaso,a.casotel,TRIM(a.casoced) AS casoced,a.casonom,a.casoape,a.casodesc";
        $strQuery .= ",a.caso_nacionalidad,a.idrrss,a.ofiid,a.estadoid,a.id_tipo_atencion";
        $strQuery .= ",case when ubi.descripcion is null then 'No aplica' else ubi.descripcion end as descripcion";
        $strQuery .= ",case when a.tipo_beneficiario='1'then 'Usuario' else 'Emprendedor' end as tipo_beneficiario";
        $strQuery .= ",a.municipioid,a.parroquiaid";
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
        $strQuery .= " join sgc_tipoatencion_usu as t_antusu on a.id_tipo_atencion=t_antusu.tipo_aten_id   ";
        $strQuery .= " join sgc_tipo_prop_intelec as tpinte on tpc.idtippropint=tpinte.tipo_prop_id  ";
        $strQuery .= " left join sgc_casos_remitidos as caso_r on a.idcaso=caso_r.casos_id  ";
        $strQuery .= " left join sgc_direcciones_administrativas as ubi on caso_r.direccion_id=ubi.id  ";
        $strQuery .= " where a.borrado='false'  ";
       // $strQuery .= " ORDER BY casos_re_id DESC'  ";
         
        $strQuery .= "  and (caso_r.vigencia='TRUE' OR  caso_r.vigencia IS NULL) ";
        $strWhere = "";
        if ($desde != 'null' and $hasta != 'null') {
            if (trim($strWhere) == "") {
                $strWhere .= " AND casofec BETWEEN '$desde'AND '$hasta'";
            } else {
                $strWhere .= " AND casofec BETWEEN '$desde'AND '$hasta'";
            }
        }

        if ($edad_min != 'null' and $edad_max != 'null') {
            if (trim($strWhere) == "") {
                $strWhere .= " AND edad BETWEEN '$edad_min'AND '$edad_max'";
            } else {
                $strWhere .= " AND edad BETWEEN '$edad_min'AND '$edad_max'";
            }
        }
        if ($tipo_pi != 0) {
            if (trim($strWhere) == "") {
                $strWhere .= " AND tpinte.tipo_prop_id=$tipo_pi";
            } else {
                $strWhere .= " AND tpinte.tipo_prop_id=$tipo_pi";
            }
        }
        if ($tipo_atencion_usu != 0) {
            if (trim($strWhere) == "") {
                $strWhere .= " AND t_antusu.tipo_aten_id=$tipo_atencion_usu";
            } else {
                $strWhere .= " AND t_antusu.tipo_aten_id=$tipo_atencion_usu";
            }
        }
        if ($sexo != 0) {
            if (trim($strWhere) == "") {
                $strWhere .= " AND a.sexo=$sexo";
            } else {
                $strWhere .= " AND a.sexo=$sexo";
            }
        }
        if ($via_atencion != 'null') {
            if (trim($strWhere) == "") {
                $strWhere .= " AND a.idrrss=$via_atencion";
            } else {
                $strWhere .= " AND a.idrrss=$via_atencion";
            }
        }
        if ($direcciones_caso != 'null') {
            if (trim($strWhere) == "") {
                $strWhere .= " AND caso_r.direccion_id=$direcciones_caso";
            } else {
                $strWhere .= " AND caso_r.direccion_id=$direcciones_caso";
            }
        }

        if ($tipo_beneficiario != '0' && $tipo_beneficiario != 'null') {
            if (trim($strWhere) == "") {
                $strWhere .= " AND a.tipo_beneficiario=$tipo_beneficiario";
            } else {
                $strWhere .= " AND a.tipo_beneficiario=$tipo_beneficiario";
            }
        }

        if ($atencion_cuidadano != '0' && $atencion_cuidadano != 'null') {
            if (trim($strWhere) == "") {
                $strWhere .= " AND a.ofiid=$atencion_cuidadano";
            } else {
                $strWhere .= " AND a.ofiid=$atencion_cuidadano";
            }
        }

        if ($estatus != '0' && $estatus != 'null') {
            if (trim($strWhere) == "") {
                $strWhere .= " AND a.idest=$estatus";
            } else {
                $strWhere .= " AND a.idest=$estatus";
            }
        }

        if ($id_estado != '0' && $id_estado != 'null') {
            if (trim($strWhere) == "") {
                $strWhere .= " AND a.estadoid='$id_estado'";
            } else {
                $strWhere .= " AND a.estadoid='$id_estado'";
            }
        }

        if ($id_municipio != '0' && $id_municipio != 'null') {
            if (trim($strWhere) == "") {
                $strWhere .= " AND a.municipioid='$id_municipio'";
            } else {
                $strWhere .= " AND a.municipioid='$id_municipio'";
            }
        }



        $strQuery = $strQuery . $strWhere;
        //return $strQuery;
        $strQuery .= " ORDER BY a.idcaso  desc";
        $query = $db->query($strQuery);
        $resultado = $query->getResult();
        return $resultado;
    }

    //Metodo para obtener todos los casos para el reporte POR OPERADOR
    public function reporte_operador($desde = null, $hasta = null, $tipo_pi = null, $tipo_atencion_usu = null, $sexo = null, $idusuopr, $via_atencion = null, $direcciones_caso = null, $tipo_beneficiario = 0, $usuarios = null,$id_estado=0,$edad_min=null,$edad_max=null)
    {
        $db      = \Config\Database::connect();
        $strQuery = "SELECT a.idcaso,a.casotel,TRIM(a.casoced) AS casoced,a.casonom,a.casoape,a.casodesc";
        $strQuery .= ",a.caso_nacionalidad,a.idrrss,a.ofiid,a.estadoid,a.id_tipo_atencion";
        $strQuery .= ",case when a.tipo_beneficiario='1'then 'Usuario' else 'Emprendedor' end as tipo_beneficiario";
        $strQuery .= ",a.municipioid,a.parroquiaid";
        $strQuery .= ",case when ubi.descripcion is null then 'No aplica' else ubi.descripcion end as descripcion";
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
        $strQuery .= " left join sgc_casos_remitidos as caso_r on a.idcaso=caso_r.casos_id  ";
        $strQuery .= " left join sgc_direcciones_administrativas as ubi on caso_r.direccion_id=ubi.id  ";
        $strQuery .= " where a.borrado='false'  ";
        $strQuery .= "  and (caso_r.vigencia='TRUE' OR  caso_r.vigencia IS NULL) ";
        // $strQuery .= " and a.idusuopr= $idusuopr ";
        $strWhere = "";

        if ($usuarios != 'null') {
            if (trim($strWhere) == "") {
                $strWhere .= " AND u_ope.idusuopr =$usuarios";
            } else {
                $strWhere .= " AND u_ope.idusuopr =$usuarios";
            }
        }


        if ($desde != 'null' and $hasta != 'null') {
            if (trim($strWhere) == "") {
                $strWhere .= " AND casofec BETWEEN '$desde'AND '$hasta'";
            } else {
                $strWhere .= " AND casofec BETWEEN '$desde'AND '$hasta'";
            }
        }
        if ($edad_min != 'null' and $edad_max != 'null') {
            if (trim($strWhere) == "") {
                $strWhere .= " AND edad BETWEEN '$edad_min'AND '$edad_max'";
            } else {
                $strWhere .= " AND edad BETWEEN '$edad_min'AND '$edad_max'";
            }
        }

        if ($tipo_pi != 0) {
            if (trim($strWhere) == "") {
                $strWhere .= " AND tpinte.tipo_prop_id=$tipo_pi";
            } else {
                $strWhere .= " AND tpinte.tipo_prop_id=$tipo_pi";
            }
        }
        if ($tipo_atencion_usu != 0) {
            if (trim($strWhere) == "") {
                $strWhere .= " AND t_antusu.tipo_aten_id=$tipo_atencion_usu";
            } else {
                $strWhere .= " AND t_antusu.tipo_aten_id=$tipo_atencion_usu";
            }
        }
        if ($sexo != 0) {
            if (trim($strWhere) == "") {
                $strWhere .= " AND a.sexo=$sexo";
            } else {
                $strWhere .= " AND a.sexo=$sexo";
            }
        }
        if ($via_atencion != 'null') {
            if (trim($strWhere) == "") {
                $strWhere .= " AND a.idrrss=$via_atencion";
            } else {
                $strWhere .= " AND a.idrrss=$via_atencion";
            }
        }
        if ($direcciones_caso != 'null') {
            if (trim($strWhere) == "") {
                $strWhere .= " AND caso_r.direccion_id=$direcciones_caso";
            } else {
                $strWhere .= " AND caso_r.direccion_id=$direcciones_caso";
            }
        }

        if ($tipo_beneficiario != '0' && $tipo_beneficiario != 'null') {
            if (trim($strWhere) == "") {
                $strWhere .= " AND a.tipo_beneficiario=$tipo_beneficiario";
            } else {
                $strWhere .= " AND a.tipo_beneficiario=$tipo_beneficiario";
            }
        }

        if ($id_estado != '0' && $id_estado != 'null') {
            if (trim($strWhere) == "") {
                $strWhere .= " AND a.estadoid='$id_estado'";
            } else {
                $strWhere .= " AND a.estadoid='$id_estado'";
            }
        }


        $strQuery = $strQuery . $strWhere;
        //return $strQuery;
        $strQuery .= " ORDER BY a.idcaso  desc";
        $query = $db->query($strQuery);
        $resultado = $query->getResult();
        return $resultado;
    }

    //Metodo para obtener los casos por estatus
    public function obtenerCasosPorEstatus(String $estatus)
    {
        $builder = $this->dbconn('sgc_casos a');
        $builder->join("sgc_estatus b", "b.idest = a.idest");
        $builder->join('sgc_usuario_operador c', "a.idusuopr = c.idusuopr");
        $builder->where("a.idest", $estatus);
        $builder->where("a.borrado", false);
        $query = $builder->get();
        return $query;
    }
    //Metodo para obtener los casos para los reportes
    public function obtenerCasosConsolidados(String $endDate, String $initDate)
    {
        $builder = $this->dbconn('sgc_casos a');
        $builder->select("a.idcaso, a.casofec, a.casoced, a.casonom, a.casoape, a.casotel, a.casonumsol, a.casoavz, b.estnom, c.rsnom, d.usuopnom, d.usuopape, e.estadonom, f.paisnom, g.municipionom, h.parroquianom");
        $builder->join("sgc_estatus b", "a.idest = b.idest");
        $builder->join('sgc_red_social c', "a.idrrss = c.idrrss");
        $builder->join('sgc_usuario_operador d', "a.idusuopr = d.idusuopr");
        $builder->join("sgc_estados e", "a.estadoid = e.estadoid");
        $builder->join("sgc_paises f", "e.paisid = f.paisid");
        $builder->join("sgc_municipio g", "a.municipioid = g.municipioid");
        $builder->join("sgc_parroquias h", "a.parroquiaid = h.parroquiaid");
        $builder->where("a.casofec BETWEEN '" . $initDate . "' AND '" . $endDate . "'");
        $builder->where("a.borrado", false);
        $builder->orderBy('a.idcaso', "ASC");
        $query = $builder->get();
        return $query;
    }

    //Metodo para obtener los casos por fecha
    public function contarCasosPorFecha(String $startDate, String $endDate)
    {
       
       
        $builder = $this->dbconn('sgc_casos');
        $builder->select('casofec');
        $builder->selectCount('casofec', 'cantCases');
        if ($startDate !== 'null' && $endDate !== 'null') {
             $builder->where("casofec BETWEEN '$startDate' AND '$endDate'");
        }
        $builder->groupBy('casofec');
        
        $result = $builder->get();
        return $result;
       
       
       
       
        // $builder = $this->dbconn('sgc_casos');
        // $builder->select('casofec');
        // $builder->selectCount('casofec', 'cantCases');
        // $builder->groupBy('casofec');
        
        //else {
        //     // Si alguna de las fechas es null, no agregue una cláusula where
        //     // Esto devolverá todos los registros
        // }
        
        // $result = $builder->get();
        // return $result;
    }


    public function consultar_estados($desde=null,$hasta=null)
    {

        $db      = \Config\Database::connect();
        $strQuery = " select COALESCE(casos.total_casos,0) AS total_casos,estados.estadonom ";
        $strQuery .= "from ";
        $strQuery .= "( ";
        $strQuery .= "select estadoid,estadonom  ";
        $strQuery .= "from sgc_estados)as estados  ";
        $strQuery .= "left join (select count(estadoid)as total_casos,estadoid   ";
        $strQuery .= "from  ";
        $strQuery .= "sgc_casos   ";
        $strQuery .= " where sgc_casos.borrado='false' ";
        if ($desde != 'null' and $hasta != 'null') 
        {
        $strQuery .= "AND casofec BETWEEN '$desde' AND '$hasta' "; 
        }
        $strQuery .= "group by estadoid  ";
        $strQuery .= "order by estadoid  ";
        $strQuery .= ")as casos on estados.estadoid =casos.estadoid  ";
        
        $strQuery .= "order by estados.estadonom  ";
        $query = $db->query($strQuery);
        $resultado = $query->getResult();
        return $resultado;
    }


    //Metodo que cuenta los Casos Atendididos
    public function contarCasosAtendidos()
    {
        $db      = \Config\Database::connect();
        $strQuery = "  SELECT count (red_s.red_s_id),red_s.red_s_nom  FROM public.sgc_casos as c ";
        $strQuery .= "join sgc_red_social red_s on c.idrrss = red_s.red_s_id  ";
        $strQuery .= " where c.borrado='false' ";
        $strQuery .= "group by (red_s.red_s_id,red_s.red_s_nom)  ";
       // return  $strQuery;
        $query = $db->query($strQuery);
        $resultado = $query->getResult();
        return $resultado;
    }

    //Metodo que cuenta los casos ATENDIDOS GENERO MASCULINO
    public function contarCasosAtendidos_MASCULINO($desde = null, $hasta = null,$id_estado=null)
    {
        $db      = \Config\Database::connect();
        $strQuery = "SELECT count  (red_s.red_s_nom),red_s.red_s_nom FROM public.sgc_casos as c ";
        $strQuery .= "join sgc_red_social red_s on c.idrrss  = red_s.red_s_id  ";
        $strQuery .= " where c.sexo='1'";
        if ($desde != 'null' and $hasta != 'null') {
            $strQuery .= "and c.casofec BETWEEN '$desde' AND '$hasta'";  # code...
        }
        if ( $id_estado != 'null'and $id_estado != null) 
        {
          $strQuery .= "  and c.estadoid='$id_estado'";
        }

        $strQuery .= " and c.borrado='false' ";
        $strQuery .= "group by (red_s.red_s_nom,red_s.red_s_nom)  ";
        $query = $db->query($strQuery);
        $resultado = $query->getResult();
        return $resultado;
    }
    //Metodo que cuenta los casos ATENDIDOS GENERO FEMENINO
    public function contarCasosAtendidos_FEMENINO($desde = null, $hasta = null,$id_estado=null)
    {
        $db      = \Config\Database::connect();
        $strQuery = "SELECT count  (red_s.red_s_nom),red_s.red_s_nom FROM public.sgc_casos as c ";
        $strQuery .= "join sgc_red_social red_s on c.idrrss  = red_s.red_s_id  ";
        $strQuery .= " where c.sexo='2'";
        if ($desde != 'null' and $hasta != 'null') {
            $strQuery .= "and c.casofec BETWEEN '$desde' AND '$hasta'";  # code...
        }
        if ( $id_estado != 'null'and $id_estado != null) 
       {
         $strQuery .= "  and c.estadoid='$id_estado'";
       }
        $strQuery .= " and c.borrado='false' ";
        $strQuery .= "group by (red_s.red_s_nom,red_s.red_s_nom)  ";
        $query = $db->query($strQuery);
        $resultado = $query->getResult();
        return $resultado;
    }

    //Metodo que cuenta los casos por propiedad Intelectual
    public function contarCasosPorPI()
    {
        $db      = \Config\Database::connect();
        $strQuery = " SELECT distinct count (tp_proint.tipo_prop_nombre),tp_proint.tipo_prop_nombre from sgc_casos as c ";
        $strQuery .= "join sgc_tipo_prop_caso tip_caso on c.idcaso=tip_caso.idcaso ";
        $strQuery .= "join sgc_tipo_prop_intelec tp_proint on tip_caso.idtippropint = tp_proint.tipo_prop_id ";
        $strQuery .= " where c.borrado='false' ";
        $strQuery .= "group by (tp_proint.tipo_prop_nombre,tp_proint.tipo_prop_nombre) ";
        //return  $strQuery;
        $query = $db->query($strQuery);
        $resultado = $query->getResult();
        return $resultado;
    }

    //Metodo que cuenta los casos por ATENCION CIUDADANO
    public function contarCasosAtencionCiudadano()
    {
        $db      = \Config\Database::connect();
        $strQuery = " SELECT  count (tipoaten.tipo_aten_nombre),tipoaten.tipo_aten_nombre from sgc_casos as c ";
        $strQuery .= "join sgc_tipoatencion_usu tipoaten on c.id_tipo_atencion = tipoaten.tipo_aten_id ";
        $strQuery .= " where c.borrado='false' ";
        $strQuery .= "group by (tipoaten.tipo_aten_nombre,tipoaten.tipo_aten_nombre) ";
        //return  $strQuery;
        $query = $db->query($strQuery);
        $resultado = $query->getResult();
        return $resultado;
    }
    




    //Metodo que cuenta los Casos Atendididos
    public function contarCasosAtendidos_filtros($desde = null, $hasta = null,$id_estado=null)
    {
        $db      = \Config\Database::connect();
        $strQuery = " SELECT count  (red_s.red_s_nom),red_s.red_s_nom FROM public.sgc_casos as c ";
        $strQuery .= "join sgc_red_social red_s on c.idrrss  = red_s.red_s_id ";
        if ($desde != 'null' and $hasta != 'null') {
            $strQuery .= "and c.casofec BETWEEN '$desde' AND '$hasta'";  # code...
        }
        $strQuery .= " and c.borrado='false' ";
        if ($id_estado != 'null'and $id_estado != null) 
        {
          $strQuery .= "  and c.estadoid='$id_estado'";
        }
        $strQuery .= "group by (red_s.red_s_nom,red_s.red_s_nom) ";
        //return  $strQuery;
        $query = $db->query($strQuery);
        $resultado = $query->getResult();
        return $resultado;
    }



    //Metodo que cuenta los casos por propiedad Intelectual
    public function contarCasosPorPI_filtros($desde = null, $hasta = null,$id_estado=null)
    {
        $db      = \Config\Database::connect();
        $strQuery = " SELECT  count (tp_proint.tipo_prop_nombre),tp_proint.tipo_prop_nombre from sgc_casos as c ";
        $strQuery .= "join sgc_tipo_prop_caso tip_caso on c.idcaso=tip_caso.idcaso ";
        $strQuery .= "join sgc_tipo_prop_intelec tp_proint on tip_caso.idtippropint = tp_proint.tipo_prop_id ";
        if ($desde != 'null' and $hasta != 'null') {
            $strQuery .= "and c.casofec BETWEEN '$desde' AND '$hasta'";  # code...
        }
        $strQuery .= " and c.borrado='false' ";
        if ( $id_estado != 'null'and $id_estado != null) 
       {
         $strQuery .= "  and c.estadoid='$id_estado'";
       }
        $strQuery .= "group by (tp_proint.tipo_prop_nombre,tp_proint.tipo_prop_nombre) ";
        //return  $strQuery;
        $query = $db->query($strQuery);
        $resultado = $query->getResult();
        return $resultado;
    }
    //Metodo que cuenta los casos de propiedad Intelectual GENERO MASCULINO
    public function contarCasos_PI_MACULINO($desde = null, $hasta = null,$id_estado=null)
    {
        $db      = \Config\Database::connect();
        $strQuery = "SELECT  count (tp_proint.tipo_prop_nombre),tp_proint.tipo_prop_nombre from sgc_casos as c  ";
        $strQuery .= "join sgc_tipo_prop_caso tip_caso on c.idcaso=tip_caso.idcaso ";
        $strQuery .= "join sgc_tipo_prop_intelec tp_proint on tip_caso.idtippropint = tp_proint.tipo_prop_id ";
        $strQuery .= "where c.sexo='1'";
        if ($desde != 'null' and $hasta != 'null') {
            $strQuery .= "and c.casofec BETWEEN '$desde' AND '$hasta'";  # code...
        }

        if ( $id_estado != 'null'and $id_estado != null) 
       {
         $strQuery .= "  and c.estadoid='$id_estado'";
       }
        $strQuery .= " and c.borrado='false' ";
        $strQuery .= "group by (tp_proint.tipo_prop_nombre,tp_proint.tipo_prop_nombre) ";
        //return  $strQuery;
        $query = $db->query($strQuery);
        $resultado = $query->getResult();
        return $resultado;
    }

    //Metodo que cuenta los casos de propiedad Intelectual FEMENINO
    public function contarCasos_PI_FEMENINO($desde = null, $hasta = null,$id_estado=null)
    {
        $db      = \Config\Database::connect();
        $strQuery = "SELECT  count (tp_proint.tipo_prop_nombre),tp_proint.tipo_prop_nombre from sgc_casos as c  ";
        $strQuery .= "join sgc_tipo_prop_caso tip_caso on c.idcaso=tip_caso.idcaso ";
        $strQuery .= "join sgc_tipo_prop_intelec tp_proint on tip_caso.idtippropint = tp_proint.tipo_prop_id ";
        $strQuery .= "where c.sexo='2'";
        if ($desde != 'null' and $hasta != 'null') {
            $strQuery .= "and c.casofec BETWEEN '$desde' AND '$hasta'";  # code...
        }
        if ( $id_estado != 'null'and $id_estado != null) 
       {
         $strQuery .= "  and c.estadoid='$id_estado'";
       }
        $strQuery .= " and c.borrado='false' ";
        $strQuery .= "group by (tp_proint.tipo_prop_nombre,tp_proint.tipo_prop_nombre) ";
        //return  $strQuery;
        $query = $db->query($strQuery);
        $resultado = $query->getResult();
        return $resultado;
    }
    //Metodo que cuenta los casos por tipo de beneficiario (USUARIO)
    public function contarCasos_Beneficiario_Usuario($desde = null, $hasta = null,$id_estado=null)
    {
        $db      = \Config\Database::connect();
        $strQuery = " SELECT count  (tipo_beneficiario),tipo_beneficiario FROM public.sgc_casos as c ";
        $strQuery .= " where c.tipo_beneficiario='1'";
        if ($desde != 'null' and $hasta != 'null') {
            $strQuery .= "and c.casofec BETWEEN '$desde' AND '$hasta'";  # code...
        }
        if ( $id_estado != 'null'and $id_estado != null ) {
            $strQuery .= "and c.estadoid='$id_estado'";  # code...
        }
        $strQuery .= " and c.borrado='false' ";
        $strQuery .= " group by (tipo_beneficiario,tipo_beneficiario) ";
        $query = $db->query($strQuery);
        $resultado = $query->getResult();
        return $resultado;
    }
    //Metodo que cuenta los casos por tipo de beneficiario (EMPRENDEDOR)
    public function contarCasos_Beneficiario_Emprendedor($desde = null, $hasta = null,$id_estado=null)
    {
        $db      = \Config\Database::connect();
        $strQuery = " SELECT count  (tipo_beneficiario),tipo_beneficiario FROM public.sgc_casos as c ";
        $strQuery .= " where c.tipo_beneficiario='2'";
        if ($desde != 'null' and $hasta != 'null') {
            $strQuery .= "and c.casofec BETWEEN '$desde' AND '$hasta'";  # code...
        }
        if ( $id_estado != 'null'and $id_estado != null ) {
            $strQuery .= "and c.estadoid='$id_estado'";  # code...
        }
        $strQuery .= " and c.borrado='false' ";
        $strQuery .= " group by (tipo_beneficiario,tipo_beneficiario) ";
        $query = $db->query($strQuery);
        $resultado = $query->getResult();
        return $resultado;
    }

  //Metodo que cuenta los casos por ATENCION CIUDADANO filtro
  public function contarCasosAtencionCiudadano_filtro($desde = null, $hasta = null,$id_estado=null)
  {
      $db      = \Config\Database::connect();
      $strQuery = " SELECT  count (tipoaten.tipo_aten_nombre),tipoaten.tipo_aten_nombre from sgc_casos as c ";
      $strQuery .= "join sgc_tipoatencion_usu tipoaten on c.id_tipo_atencion = tipoaten.tipo_aten_id ";
      if ($desde != 'null' and $hasta != 'null') {
        $strQuery .= "and c.casofec BETWEEN '$desde' AND '$hasta'";  # code...
      }
      if ( $id_estado != 'null'and $id_estado != null) 
       {
         $strQuery .= "  and c.estadoid='$id_estado'";
       }
      $strQuery .= " and c.borrado='false' ";
      $strQuery .= "group by (tipoaten.tipo_aten_nombre,tipoaten.tipo_aten_nombre) ";
      //return  $strQuery;
      $query = $db->query($strQuery);
      $resultado = $query->getResult();
      return $resultado;
  }
  
 //BUSCAMOS LOS CASOS ABIERTOS
  public function contarCasosAbiertos($desde, $hasta,$id_estado=null)
  {
      $db      = \Config\Database::connect();
      $strQuery = " SELECT count  (idest),idest FROM public.sgc_casos as c ";
      $strQuery .= " where c.idest='1'";
      $strQuery .= " and c.borrado='false' ";
      if ($desde != 'null' and $hasta != 'null') {
          $strQuery .= "and c.casofec BETWEEN '$desde' AND '$hasta'";  # code...
      }
      if ($id_estado != 'null'and $id_estado != null) {
        $strQuery .= "and c.estadoid='$id_estado'";  # code...
    }
      $strQuery .= " group by (idest,idest) ";
      $query = $db->query($strQuery);
      $resultado = $query->getResult();
      return $resultado;
  }

//BUSCAMOS LOS CASOS ABIERTOS ESTADALES
public function  ContarCasosAbiertosEstadal($desde,$hasta)
{
    $db      = \Config\Database::connect();
    $strQuery = "select estados.estadonom,COALESCE(cuenta.abiertos,0) AS abiertos  ";
    $strQuery .= "FROM ";
    $strQuery .= "( ";
    $strQuery .= " SELECT estadoid ,estadonom FROM sgc_estados ";
    $strQuery .= " ) AS estados  ";
    $strQuery .= "LEFT JOIN ";
    $strQuery .= "( ";
    $strQuery .= " SELECT COUNT(idest) AS abiertos,estadoid  ";
    $strQuery .= "FROM  sgc_casos ";
    $strQuery .= "WHERE  idest=1 ";
    $strQuery .= " and sgc_casos.borrado='false' ";
    if ($desde != 'null' and $hasta != 'null') {
        $strQuery .= "and casofec BETWEEN '$desde' AND '$hasta' ";  # code...
    }
   
    $strQuery .= " GROUP BY idest,estadoid ";
    $strQuery .= " ORDER BY  estadoid ";
    $strQuery .= ") AS cuenta ON estados.estadoid=cuenta.estadoid "; 
   
    $strQuery .= "order by estados.estadonom  ";
    // $strQuery;
    $query = $db->query($strQuery);
    $resultado = $query->getResult();
    return $resultado;
}
//BUSCAMOS LOS CASOS CERRADOS ESTADALES
public function  ContarCasosCerradosEstadal($desde,$hasta)
{
    $db      = \Config\Database::connect();
    $strQuery = "select estados.estadonom,COALESCE(cuenta.cerrados,0) AS cerrados  ";
    $strQuery .= "FROM ";
    $strQuery .= "( ";
    $strQuery .= " SELECT estadoid ,estadonom FROM sgc_estados ";
    $strQuery .= " ) AS estados  ";
    $strQuery .= "LEFT JOIN ";
    $strQuery .= "( ";
    $strQuery .= " SELECT COUNT(idest) AS cerrados,estadoid  ";
    $strQuery .= "FROM  sgc_casos ";
    $strQuery .= "WHERE  idest=2 ";
    if ($desde != 'null' and $hasta != 'null') {
        $strQuery .= "and casofec BETWEEN '$desde' AND '$hasta' ";  # code...
    }
    $strQuery .= " and sgc_casos.borrado='false' ";
    $strQuery .= " GROUP BY idest,estadoid ";
    $strQuery .= " ORDER BY  estadoid ";
    $strQuery .= ") AS cuenta ON estados.estadoid=cuenta.estadoid "; 
   
    $strQuery .= "order by estados.estadonom  ";
    // $strQuery;
    $query = $db->query($strQuery);
    $resultado = $query->getResult();
    return $resultado;
}

/*USUARIO Y EMPRENDEDOR*/

/*select estados.estadonom,COALESCE(cuenta.emprendedor,0) AS emprendedor
FROM 
(
	SELECT estadoid ,estadonom FROM sgc_estados
) AS estados 
LEFT JOIN ( 
	SELECT count(c.idcaso) as emprendedor,c.tipo_beneficiario,c.estadoid 
	FROM sgc_casos c 
	WHERE c.tipo_beneficiario=1
	group by c.tipo_beneficiario,c.estadoid
) AS cuenta ON estados.estadoid=cuenta.estadoid*/


//BUSCAMOS LOS CASOS ESTADALES POR TIPO DE BENEFICIARIO USUARIO 
public function  ContarCasosUsuariosEstadal($desde,$hasta)
{
    $db      = \Config\Database::connect();
    $strQuery = "select estados.estadonom,COALESCE(cuenta.usuario,0) AS usuario  ";
    $strQuery .= "FROM ";
    $strQuery .= "(SELECT ";
    $strQuery .= "estadoid ,estadonom FROM sgc_estados ";
    $strQuery .= ") AS estados ";
    $strQuery .= "LEFT JOIN (  ";
    $strQuery .= "SELECT count(c.idcaso) as usuario,c.tipo_beneficiario,c.estadoid  ";
    $strQuery .= "FROM sgc_casos c ";
    $strQuery .= "WHERE c.tipo_beneficiario=1 ";
    if ($desde != 'null' and $hasta != 'null') {
        $strQuery .= "and c.casofec BETWEEN '$desde' AND '$hasta'";  # code...
    }
    $strQuery .= " and c.borrado='false' ";
    $strQuery .= "group by c.tipo_beneficiario,c.estadoid";
    $strQuery .= ") AS cuenta ON estados.estadoid=cuenta.estadoid "; 
    $strQuery .= "order by estados.estadonom  ";
    $query = $db->query($strQuery);
    $resultado = $query->getResult();
    return $resultado;
}

//BUSCAMOS LOS CASOS ESTADALES POR TIPO DE BENEFICIARIO EMPRENDEDOR
public function  ContarCasosEmprendedorEstadal($desde,$hasta)
{
    $db      = \Config\Database::connect();
    $strQuery = "select estados.estadonom,COALESCE(cuenta.emprendedor,0) AS emprendedor  ";
    $strQuery .= "FROM ";
    $strQuery .= "(SELECT ";
    $strQuery .= "estadoid ,estadonom FROM sgc_estados ";
    $strQuery .= ") AS estados ";
    $strQuery .= "LEFT JOIN (  ";
    $strQuery .= "SELECT count(c.idcaso) as emprendedor,c.tipo_beneficiario,c.estadoid  ";
    $strQuery .= "FROM sgc_casos c ";
    $strQuery .= "WHERE c.tipo_beneficiario=2 ";
    if ($desde != 'null' and $hasta != 'null') {
        $strQuery .= "and c.casofec BETWEEN '$desde' AND '$hasta'";  # code...
    }
    $strQuery .= " and c.borrado='false' ";
    $strQuery .= "group by c.tipo_beneficiario,c.estadoid";
    $strQuery .= ") AS cuenta ON estados.estadoid=cuenta.estadoid "; 
    $strQuery .= "order by estados.estadonom  ";
    $query = $db->query($strQuery);
    $resultado = $query->getResult();
    return $resultado;
}


//BUSCAMOS LOS CASOS ESTADALES POR TIPO DE PROPIEDAD INTELECTUAL PATENTES
public function  ContarCasosPatentesEstadal($desde,$hasta)
{

    $db      = \Config\Database::connect();
    $strQuery = "select estados.estadonom,COALESCE(tipo.cuenta,0) AS patentes  ";
    $strQuery .= "FROM ";
    $strQuery .= "(";
    $strQuery .= " SELECT estadoid ,estadonom FROM sgc_estados";
    $strQuery .= " ) AS estados ";
    $strQuery .= "LEFT JOIN";
    $strQuery .= " (";
    $strQuery .= " SELECT";
    $strQuery .= " count(c.idcaso) cuenta";
    $strQuery .= " ,t.idtippropint";
    $strQuery .= " ,c.estadoid";
    $strQuery .= " FROM";
    $strQuery .= " sgc_casos c";
    $strQuery .= " JOIN sgc_tipo_prop_caso t ON c.idcaso=t.idcaso";
    $strQuery .= " ";
    $strQuery .= " ";
    $strQuery .= "WHERE t.idtippropint=2 ";
    if ($desde != 'null' and $hasta != 'null') {
        $strQuery .= "and c.casofec BETWEEN '$desde' AND '$hasta'";  # code...
    }
    $strQuery .= " and c.borrado='false' ";
    $strQuery .= "GROUP BY t.idtippropint,c.estadoid";
    $strQuery .= ") AS tipo on tipo.estadoid = estados.estadoid "; 
    $strQuery .= "order by estados.estadonom  ";
    $query = $db->query($strQuery);
    $resultado = $query->getResult();
    return $resultado;
  
}

//BUSCAMOS LOS CASOS ESTADALES POR TIPO DE PROPIEDAD INTELECTUAL NO APLICA
public function  ContarCasosNoAplicaEstadal($desde,$hasta)
{
    $db      = \Config\Database::connect();
    $strQuery = "select estados.estadonom,COALESCE(tipo.cuenta,0) AS no_aplica  ";
    $strQuery .= "FROM ";
    $strQuery .= "(";
    $strQuery .= " SELECT estadoid ,estadonom FROM sgc_estados";
    $strQuery .= " ) AS estados ";
    $strQuery .= "LEFT JOIN";
    $strQuery .= " (";
    $strQuery .= " SELECT";
    $strQuery .= " count(c.idcaso) cuenta";
    $strQuery .= " ,t.idtippropint";
    $strQuery .= " ,c.estadoid";
    $strQuery .= " FROM";
    $strQuery .= " sgc_casos c";
    $strQuery .= " JOIN sgc_tipo_prop_caso t ON c.idcaso=t.idcaso";
    $strQuery .= " ";
    $strQuery .= " ";
    $strQuery .= "WHERE t.idtippropint=1 ";
    if ($desde != 'null' and $hasta != 'null') {
        $strQuery .= "and c.casofec BETWEEN '$desde' AND '$hasta'";  # code...
    }
    $strQuery .= " and c.borrado='false' ";
    $strQuery .= "GROUP BY t.idtippropint,c.estadoid";
    $strQuery .= ") AS tipo on tipo.estadoid = estados.estadoid "; 
    $strQuery .= "order by estados.estadonom  ";
    $query = $db->query($strQuery);
    $resultado = $query->getResult();
    return $resultado; 
}

//BUSCAMOS LOS CASOS ESTADALES POR TIPO DE PROPIEDAD INTELECTUAL DERECHO DE AUTOR
public function  ContarCasosDerecho_AutorEstadal($desde,$hasta)
{
    $db      = \Config\Database::connect();
    $strQuery = "select estados.estadonom,COALESCE(tipo.cuenta,0) AS derecho_autor  ";
    $strQuery .= "FROM ";
    $strQuery .= "(";
    $strQuery .= " SELECT estadoid ,estadonom FROM sgc_estados";
    $strQuery .= " ) AS estados ";
    $strQuery .= "LEFT JOIN";
    $strQuery .= " (";
    $strQuery .= " SELECT";
    $strQuery .= " count(c.idcaso) cuenta";
    $strQuery .= " ,t.idtippropint";
    $strQuery .= " ,c.estadoid";
    $strQuery .= " FROM";
    $strQuery .= " sgc_casos c";
    $strQuery .= " JOIN sgc_tipo_prop_caso t ON c.idcaso=t.idcaso";
    $strQuery .= " ";
    $strQuery .= " ";
    $strQuery .= "WHERE t.idtippropint=3 ";
    if ($desde != 'null' and $hasta != 'null') {
        $strQuery .= "and c.casofec BETWEEN '$desde' AND '$hasta'";  # code...
    }
    $strQuery .= " and c.borrado='false' ";
    $strQuery .= "GROUP BY t.idtippropint,c.estadoid";
    $strQuery .= ") AS tipo on tipo.estadoid = estados.estadoid "; 
    $strQuery .= "order by estados.estadonom  ";
    $query = $db->query($strQuery);
    $resultado = $query->getResult();
    return $resultado; 
}

//BUSCAMOS LOS CASOS ESTADALES POR TIPO DE PROPIEDAD INTELECTUAL INDICACIONES GEOGRAFICAS
public function  ContarCasosIndicaciondesGeograficas($desde,$hasta)
{
    $db      = \Config\Database::connect();
    $strQuery = "select estados.estadonom,COALESCE(tipo.cuenta,0) AS indicacione_geograficas  ";
    $strQuery .= "FROM ";
    $strQuery .= "(";
    $strQuery .= " SELECT estadoid ,estadonom FROM sgc_estados";
    $strQuery .= " ) AS estados ";
    $strQuery .= "LEFT JOIN";
    $strQuery .= " (";
    $strQuery .= " SELECT";
    $strQuery .= " count(c.idcaso) cuenta";
    $strQuery .= " ,t.idtippropint";
    $strQuery .= " ,c.estadoid";
    $strQuery .= " FROM";
    $strQuery .= " sgc_casos c";
    $strQuery .= " JOIN sgc_tipo_prop_caso t ON c.idcaso=t.idcaso";
    $strQuery .= " ";
    $strQuery .= " ";
    $strQuery .= "WHERE t.idtippropint=4 ";
    if ($desde != 'null' and $hasta != 'null') {
        $strQuery .= "and c.casofec BETWEEN '$desde' AND '$hasta'";  # code...
    }
    $strQuery .= " and c.borrado='false' ";
    $strQuery .= "GROUP BY t.idtippropint,c.estadoid";
    $strQuery .= ") AS tipo on tipo.estadoid = estados.estadoid "; 
    $strQuery .= "order by estados.estadonom  ";
    $query = $db->query($strQuery);
    $resultado = $query->getResult();
    return $resultado; 
}
//BUSCAMOS LOS CASOS ESTADALES POR TIPO DE PROPIEDAD INTELECTUAL INDICACIONES GEOGRAFICAS
public function  ContarCasosMarcas($desde,$hasta)
{
   
    $db      = \Config\Database::connect();
    $strQuery = "select estados.estadonom,COALESCE(tipo.cuenta,0) AS marcas  ";
    $strQuery .= "FROM ";
    $strQuery .= "(";
    $strQuery .= " SELECT estadoid ,estadonom FROM sgc_estados";
    $strQuery .= " ) AS estados ";
    $strQuery .= "LEFT JOIN";
    $strQuery .= " (";
    $strQuery .= " SELECT";
    $strQuery .= " count(c.idcaso) cuenta";
    $strQuery .= " ,t.idtippropint";
    $strQuery .= " ,c.estadoid";
    $strQuery .= " FROM";
    $strQuery .= " sgc_casos c";
    $strQuery .= " JOIN sgc_tipo_prop_caso t ON c.idcaso=t.idcaso";
    $strQuery .= " ";
    $strQuery .= " ";
    $strQuery .= "WHERE t.idtippropint=5 ";
    if ($desde != 'null' and $hasta != 'null') {
        $strQuery .= "and c.casofec BETWEEN '$desde' AND '$hasta'";  # code...
    }
    $strQuery .= " and c.borrado='false' ";
    $strQuery .= "GROUP BY t.idtippropint,c.estadoid";
    $strQuery .= ") AS tipo on tipo.estadoid = estados.estadoid "; 
    $strQuery .= "order by estados.estadonom  ";
    $query = $db->query($strQuery);
    $resultado = $query->getResult();
    return $resultado; 
}

//BUSCAMOS LOS CASOS ESTADALES POR TIPO DE ATENCION ASESORIA
public function  ContarCasosAsesoriaEstadal($desde,$hasta)
{
    $db      = \Config\Database::connect();
    $strQuery = "select estados.estadonom,COALESCE(tipo.cuenta,0) AS asesoria  ";
    $strQuery .= "FROM ";
    $strQuery .= "(";
    $strQuery .= " SELECT estadoid ,estadonom FROM sgc_estados ";
    $strQuery .= " ) AS estados ";
    $strQuery .= "LEFT JOIN";
    $strQuery .= " (";
    $strQuery .= " SELECT";
    $strQuery .= " count(c.idcaso) cuenta";
    $strQuery .= " ,t.tipo_aten_id";
    $strQuery .= " ,c.estadoid";
    $strQuery .= " FROM";
    $strQuery .= " sgc_casos c";
    $strQuery .= " JOIN sgc_tipoatencion_usu t ON c.id_tipo_atencion=t.tipo_aten_id ";
    $strQuery .= "WHERE t.tipo_aten_id=1 ";
    if ($desde != 'null' and $hasta != 'null') {
        $strQuery .= "and c.casofec BETWEEN '$desde' AND '$hasta'";  # code...
    }
    $strQuery .= " and c.borrado='false' ";
    $strQuery .= "GROUP BY t.tipo_aten_id,c.estadoid";
    $strQuery .= ") AS tipo on tipo.estadoid = estados.estadoid "; 
    $strQuery .= "order by estados.estadonom  ";
    $query = $db->query($strQuery);
    $resultado = $query->getResult();
    return $resultado; 
}
//BUSCAMOS LOS CASOS ESTADALES POR TIPO DE ATENCION SUGERENCIA
public function  ContarCasosSugerenciaEstadal($desde,$hasta)
{
    $db      = \Config\Database::connect();
    $strQuery = "select estados.estadonom,COALESCE(tipo.cuenta,0) AS sugerencia  ";
    $strQuery .= "FROM ";
    $strQuery .= "(";
    $strQuery .= " SELECT estadoid ,estadonom FROM sgc_estados ";
    $strQuery .= " ) AS estados ";
    $strQuery .= "LEFT JOIN";
    $strQuery .= " (";
    $strQuery .= " SELECT";
    $strQuery .= " count(c.idcaso) cuenta";
    $strQuery .= " ,t.tipo_aten_id";
    $strQuery .= " ,c.estadoid";
    $strQuery .= " FROM";
    $strQuery .= " sgc_casos c";
    $strQuery .= " JOIN sgc_tipoatencion_usu t ON c.id_tipo_atencion=t.tipo_aten_id ";
    $strQuery .= "WHERE t.tipo_aten_id=2 ";
    if ($desde != 'null' and $hasta != 'null') {
        $strQuery .= "and c.casofec BETWEEN '$desde' AND '$hasta'";  # code...
    }
    $strQuery .= " and c.borrado='false' ";
    $strQuery .= "GROUP BY t.tipo_aten_id,c.estadoid";
    $strQuery .= ") AS tipo on tipo.estadoid = estados.estadoid "; 
    $strQuery .= "order by estados.estadonom  ";
    $query = $db->query($strQuery);
    $resultado = $query->getResult();
    return $resultado; 
}

//BUSCAMOS LOS CASOS ESTADALES POR TIPO DE ATENCION SUGERENCIA
public function  ContarCasosQuejaEstadal($desde,$hasta)
{
    $db      = \Config\Database::connect();
    $strQuery = "select estados.estadonom,COALESCE(tipo.cuenta,0) AS queja  ";
    $strQuery .= "FROM ";
    $strQuery .= "(";
    $strQuery .= " SELECT estadoid ,estadonom FROM sgc_estados ";
    $strQuery .= " ) AS estados ";
    $strQuery .= "LEFT JOIN";
    $strQuery .= " (";
    $strQuery .= " SELECT";
    $strQuery .= " count(c.idcaso) cuenta";
    $strQuery .= " ,t.tipo_aten_id";
    $strQuery .= " ,c.estadoid";
    $strQuery .= " FROM";
    $strQuery .= " sgc_casos c";
    $strQuery .= " JOIN sgc_tipoatencion_usu t ON c.id_tipo_atencion=t.tipo_aten_id ";
    $strQuery .= "WHERE t.tipo_aten_id=3 ";
    if ($desde != 'null' and $hasta != 'null') {
        $strQuery .= "and c.casofec BETWEEN '$desde' AND '$hasta'";  # code...
    }
    $strQuery .= " and c.borrado='false' ";
    $strQuery .= "GROUP BY t.tipo_aten_id,c.estadoid";
    $strQuery .= ") AS tipo on tipo.estadoid = estados.estadoid "; 
    $strQuery .= "order by estados.estadonom  ";
    $query = $db->query($strQuery);
    $resultado = $query->getResult();
    return $resultado; 
}

//BUSCAMOS LOS CASOS ESTADALES POR TIPO DE ATENCION RECLAMO
public function  ContarCasosReclamoEstadal($desde,$hasta)
{
    $db      = \Config\Database::connect();
    $strQuery = "select estados.estadonom,COALESCE(tipo.cuenta,0) AS reclamo  ";
    $strQuery .= "FROM ";
    $strQuery .= "(";
    $strQuery .= " SELECT estadoid ,estadonom FROM sgc_estados ";
    $strQuery .= " ) AS estados ";
    $strQuery .= "LEFT JOIN";
    $strQuery .= " (";
    $strQuery .= " SELECT";
    $strQuery .= " count(c.idcaso) cuenta";
    $strQuery .= " ,t.tipo_aten_id";
    $strQuery .= " ,c.estadoid";
    $strQuery .= " FROM";
    $strQuery .= " sgc_casos c";
    $strQuery .= " JOIN sgc_tipoatencion_usu t ON c.id_tipo_atencion=t.tipo_aten_id ";
    $strQuery .= "WHERE t.tipo_aten_id=4 ";
    if ($desde != 'null' and $hasta != 'null') {
        $strQuery .= "and c.casofec BETWEEN '$desde' AND '$hasta'";  # code...
    }
    $strQuery .= " and c.borrado='false' ";
    $strQuery .= "GROUP BY t.tipo_aten_id,c.estadoid";
    $strQuery .= ") AS tipo on tipo.estadoid = estados.estadoid "; 
    $strQuery .= "order by estados.estadonom  ";
    $query = $db->query($strQuery);
    $resultado = $query->getResult();
    return $resultado; 
}

//BUSCAMOS LOS CASOS ESTADALES POR TIPO DE ATENCION DENUNICA
public function  ContarCasosDenunciaEstadal($desde,$hasta)
{
    $db      = \Config\Database::connect();
    $strQuery = "select estados.estadonom,COALESCE(tipo.cuenta,0) AS denuncia  ";
    $strQuery .= "FROM ";
    $strQuery .= "(";
    $strQuery .= " SELECT estadoid ,estadonom FROM sgc_estados ";
    $strQuery .= " ) AS estados ";
    $strQuery .= "LEFT JOIN";
    $strQuery .= " (";
    $strQuery .= " SELECT";
    $strQuery .= " count(c.idcaso) cuenta";
    $strQuery .= " ,t.tipo_aten_id";
    $strQuery .= " ,c.estadoid";
    $strQuery .= " FROM";
    $strQuery .= " sgc_casos c";
    $strQuery .= " JOIN sgc_tipoatencion_usu t ON c.id_tipo_atencion=t.tipo_aten_id ";
    $strQuery .= "WHERE t.tipo_aten_id=5 ";
    if ($desde != 'null' and $hasta != 'null') {
        $strQuery .= "and c.casofec BETWEEN '$desde' AND '$hasta'";  # code...
    }
    $strQuery .= " and c.borrado='false' ";
    $strQuery .= "GROUP BY t.tipo_aten_id,c.estadoid";
    $strQuery .= ") AS tipo on tipo.estadoid = estados.estadoid "; 
    $strQuery .= "order by estados.estadonom  ";
    $query = $db->query($strQuery);
    $resultado = $query->getResult();
    return $resultado; 
}

//BUSCAMOS LOS CASOS ESTADALES POR TIPO DE ATENCION PETICION
public function  ContarCasosPeticionEstadal($desde,$hasta)
{
    $db      = \Config\Database::connect();
    $strQuery = "select estados.estadonom,COALESCE(tipo.cuenta,0) AS peticion  ";
    $strQuery .= "FROM ";
    $strQuery .= "(";
    $strQuery .= " SELECT estadoid ,estadonom FROM sgc_estados ";
    $strQuery .= " ) AS estados ";
    $strQuery .= "LEFT JOIN";
    $strQuery .= " (";
    $strQuery .= " SELECT";
    $strQuery .= " count(c.idcaso) cuenta";
    $strQuery .= " ,t.tipo_aten_id";
    $strQuery .= " ,c.estadoid";
    $strQuery .= " FROM";
    $strQuery .= " sgc_casos c";
    $strQuery .= " JOIN sgc_tipoatencion_usu t ON c.id_tipo_atencion=t.tipo_aten_id ";
    $strQuery .= "WHERE t.tipo_aten_id=6 ";
    if ($desde != 'null' and $hasta != 'null') {
        $strQuery .= "and c.casofec BETWEEN '$desde' AND '$hasta'";  # code...
    }
    $strQuery .= " and c.borrado='false' ";
    $strQuery .= "GROUP BY t.tipo_aten_id,c.estadoid";
    $strQuery .= ") AS tipo on tipo.estadoid = estados.estadoid "; 
    $strQuery .= "order by estados.estadonom  ";
    $query = $db->query($strQuery);
    $resultado = $query->getResult();
    return $resultado; 
}

//BUSCAMOS LOS CASOS ESTADALES POR TIPO DE ATENCION PETICION
public function  ContarCasosTalleresEstadal($desde,$hasta)
{
    $db      = \Config\Database::connect();
    $strQuery = "select estados.estadonom,COALESCE(tipo.cuenta,0) AS talleres  ";
    $strQuery .= "FROM ";
    $strQuery .= "(";
    $strQuery .= " SELECT estadoid ,estadonom FROM sgc_estados ";
    $strQuery .= " ) AS estados ";
    $strQuery .= "LEFT JOIN";
    $strQuery .= " (";
    $strQuery .= " SELECT";
    $strQuery .= " count(c.idcaso) cuenta";
    $strQuery .= " ,t.tipo_aten_id";
    $strQuery .= " ,c.estadoid";
    $strQuery .= " FROM";
    $strQuery .= " sgc_casos c";
    $strQuery .= " JOIN sgc_tipoatencion_usu t ON c.id_tipo_atencion=t.tipo_aten_id ";
    $strQuery .= "WHERE t.tipo_aten_id= 7 ";
    if ($desde != 'null' and $hasta != 'null') {
        $strQuery .= "and c.casofec BETWEEN '$desde' AND '$hasta'";  # code...
    }
    $strQuery .= " and c.borrado='false' ";
    $strQuery .= "GROUP BY t.tipo_aten_id,c.estadoid";
    $strQuery .= ") AS tipo on tipo.estadoid = estados.estadoid "; 
    $strQuery .= "order by estados.estadonom  ";
    $query = $db->query($strQuery);
    $resultado = $query->getResult();
    return $resultado; 
}






   //BUSCAMOS LOS CASOS CERRADOS
   public function ContarCasosCerrados($desde, $hasta,$id_estado=null)
   {
       $db      = \Config\Database::connect();
       $strQuery = " SELECT count  (idest),idest FROM public.sgc_casos as c ";
       $strQuery .= " where c.idest='2' ";
       if ($desde != 'null' and $hasta != 'null') {
           $strQuery .= "and c.casofec BETWEEN '$desde' AND '$hasta' ";  # code...
       }
       if ( $id_estado != 'null'and $id_estado != null) 
       {
         $strQuery .= "  and c.estadoid='$id_estado'";
       }

      $strQuery .= " and c.borrado='false' ";
       $strQuery .= " group by (idest,idest) ";
      // return $strQuery;
       $query = $db->query($strQuery);
       $resultado = $query->getResult();
       return $resultado;
   }



     //BUSCAMOS LOS CASOS  CREADOS PARA EL REPORTE DE PORTAL WEB 
     public function ContarCasos($desde, $hasta)
     {
         $db      = \Config\Database::connect();
         $strQuery = " SELECT count  (c.idcaso) as total_idcaso,casofec  FROM public.sgc_casos as c ";
         if ($desde != 'null' and $hasta != 'null') {
             $strQuery .= "where c.casofec BETWEEN '$desde' AND '$hasta' ";  # code...
         }
        $strQuery .= " and c.borrado='false' ";
         $strQuery .= "  group by (c.casofec) ";
        // return $strQuery;
         $query = $db->query($strQuery);
         $resultado = $query->getResult();
         return $resultado;
     }
  

     //BUSCAMOS LOS CASOS CERRADOS
     public function ContarCasos_Portal_Web($desde, $hasta)
     {
         $db      = \Config\Database::connect();
         $strQuery = " SELECT   TO_CHAR(c.casofec, 'Day') AS dia_semana_completo, ";
         $strQuery .= " c.casofec AS fecha,COUNT(DISTINCT c.idcaso) AS casos_creados ";
         $strQuery .= " FROM public.sgc_casos AS c ";
         $strQuery .= " left JOIN public.sta_usuarios_visitas AS v ON c.casofec = v.fecha ";
         $strQuery .= " where c.casofec BETWEEN '$desde' AND '$hasta'";
         $strQuery .= " and idrrss='3' "; 
         $strQuery .= " AND c.borrado = 'false' ";
         $strQuery .= " GROUP BY c.casofec, TO_CHAR(c.casofec, 'Day') ";
         $strQuery .= " ORDER BY c.casofec ASC; ";
         //return $strQuery;
        $query = $db->query($strQuery);
        $resultado = $query->getResult();
         return $resultado;
     }

    //Metodo para agregar  el nombre de los cocumentos de asosciados a los casos
    public function agregar_docu_casos(array $documentos_casos)

    {
        $builder = $this->dbconn('sgc_documentos_casos');
        $query = $builder->insert($documentos_casos);
        return $query;
    }

    //Metodo que busca el correo del usuario en funcion del caso Y la descripcion del caso 
    public function buscar_correo($caseid)
	{
		$builder = $this->dbconn('public.sgc_casos as c');
		$builder->select(
			"c.correo,c.casonom,c.casoape ,c.casodesc"
		);
		$builder->where(['c.idcaso' => $caseid]);
		$query = $builder->get();
		return $query;
	}

    //Metodo que busca el correo del usuario en funcion del caso Y la descripcion del caso 
    public function buscar_token($token)
	{
	
        $db      = \Config\Database::connect();
        $strQuery = " SELECT t.id_usuario FROM  sgc_usuario_token as t   ";
        $strQuery .= " where t.token='$token'";
        //return $strQuery;
        $query = $db->query($strQuery);
        $resultado = $query->getResult();
        
        return $resultado;
	}

//   //Metodo que busca el correo del usuario en funcion del caso Y la descripcion del caso 
  public function buscar_usuario($datos)
  {

  
    $builder = $this->dbconn('public.sgc_casos as c');
    $builder->select(
        "*"
    );
    $builder->where(['c.casoced' => $datos]);
    $query = $builder->get();
    return $query;
    

  }


//Metodo para obtener todas las atenciones de una caso 
public function reporte_atencion($desde = null, $hasta = null, $tipo_pi = null, $tipo_atencion_usu = null, $sexo = null, $via_atencion = null, $direcciones_caso = null, $tipo_beneficiario = 0,$atencion_cuidadano = 0,$estatus = 0)
{
 

    $db      = \Config\Database::connect();

   

    
    
    $strQuery = " SELECT c.idcaso,CONCAT(c.caso_nacionalidad,c.casoced) AS cedula,CONCAT(c.casonom, ' ',' ', c.casoape) AS nombre,";
    $strQuery .= " c.casotel,c.casodesc,c.estnom,sc.idestllam,sc.segcoment,case when sexo='1'then 'M' else 'F' end as sexo,";
    $strQuery .= " to_char(sc.segfec,'dd/mm/yyyy') as fecha_seguimiento,sc.segfec as fecha_seg_normal,";
    $strQuery .= " CONCAT(usu.usuopnom, ' ',' ', usu.usuopape) AS nombre_usuario";
    $strQuery .= ",case when c.tipo_beneficiario='1'then 'Usuario' else 'Emprendedor' end as tipo_beneficiario";
    $strQuery .= " FROM public.sgc_seguimiento_caso as sc";
    $strQuery .= " join vista_casos_atendidos as c on sc.idcaso=c.idcaso";
    $strQuery .= " join sgc_usuario_operador as usu on sc.idusuopr=usu.idusuopr";
    $strQuery .= " where sc.borrado='false'  ";
    $strWhere = "";
    $strQuery = $strQuery . $strWhere;
    //return $strQuery;
    $strQuery .= " ORDER BY c.idcaso  desc";
    $query = $db->query($strQuery);
    $resultado = $query->getResult();
    return $resultado;
  
   // $strQuery .= " ORDER BY casos_re_id DESC'  ";
     
    // $strQuery .= "  and (caso_r.vigencia='TRUE' OR  caso_r.vigencia IS NULL) ";
    // $strWhere = "";
    // if ($desde != 'null' and $hasta != 'null') {
    //     if (trim($strWhere) == "") {
    //         $strWhere .= " AND casofec BETWEEN '$desde'AND '$hasta'";
    //     } else {
    //         $strWhere .= " AND casofec BETWEEN '$desde'AND '$hasta'";
    //     }
    // }
    // if ($tipo_pi != 0) {
    //     if (trim($strWhere) == "") {
    //         $strWhere .= " AND tpinte.tipo_prop_id=$tipo_pi";
    //     } else {
    //         $strWhere .= " AND tpinte.tipo_prop_id=$tipo_pi";
    //     }
    // }
    // if ($tipo_atencion_usu != 0) {
    //     if (trim($strWhere) == "") {
    //         $strWhere .= " AND t_antusu.tipo_aten_id=$tipo_atencion_usu";
    //     } else {
    //         $strWhere .= " AND t_antusu.tipo_aten_id=$tipo_atencion_usu";
    //     }
    // }
    // if ($sexo != 0) {
    //     if (trim($strWhere) == "") {
    //         $strWhere .= " AND a.sexo=$sexo";
    //     } else {
    //         $strWhere .= " AND a.sexo=$sexo";
    //     }
    // }
    // if ($via_atencion != 'null') {
    //     if (trim($strWhere) == "") {
    //         $strWhere .= " AND a.idrrss=$via_atencion";
    //     } else {
    //         $strWhere .= " AND a.idrrss=$via_atencion";
    //     }
    // }
    // if ($direcciones_caso != 'null') {
    //     if (trim($strWhere) == "") {
    //         $strWhere .= " AND caso_r.direccion_id=$direcciones_caso";
    //     } else {
    //         $strWhere .= " AND caso_r.direccion_id=$direcciones_caso";
    //     }
    // }

    // if ($tipo_beneficiario != '0' && $tipo_beneficiario != 'null') {
    //     if (trim($strWhere) == "") {
    //         $strWhere .= " AND a.tipo_beneficiario=$tipo_beneficiario";
    //     } else {
    //         $strWhere .= " AND a.tipo_beneficiario=$tipo_beneficiario";
    //     }
    // }

    // if ($atencion_cuidadano != '0' && $atencion_cuidadano != 'null') {
    //     if (trim($strWhere) == "") {
    //         $strWhere .= " AND a.ofiid=$atencion_cuidadano";
    //     } else {
    //         $strWhere .= " AND a.ofiid=$atencion_cuidadano";
    //     }
    // }

    // if ($estatus != '0' && $estatus != 'null') {
    //     if (trim($strWhere) == "") {
    //         $strWhere .= " AND a.idest=$estatus";
    //     } else {
    //         $strWhere .= " AND a.idest=$estatus";
    //     }
    // }

   
}




//   //Metodo que busca los casos por municipios para el mapa
public function Listar_Casos_Municipios()
{

   

    $db = \Config\Database::connect();
    $builder = $db->table('sgc_casos c');
    $builder->select('e.estadoid,e.estadonom, m.municipioid, m.municipionom, t.tipo_aten_nombre, t.tipo_aten_id AS id_tipo_atencion, COUNT(c.idcaso) AS casos');
    $builder->join('sgc_municipio m', 'c.municipioid = m.municipioid');
    $builder->join('sgc_estados e', 'c.estadoid = e.estadoid');
    $builder->join('sgc_tipoatencion_usu t', 'c.id_tipo_atencion = t.tipo_aten_id');
    $builder->where('c.borrado', false);
    $builder->where('c.idcaso IS NOT NULL'); // Agregamos esta condición para filtrar los resultados
    $builder->groupBy('e.estadoid,m.municipioid, m.municipionom, e.estadonom, t.tipo_aten_id, t.tipo_aten_nombre');
    $builder->orderBy('e.estadoid,m.municipionom');
    $resultado = $builder->get()->getResult();
    return $resultado;

  
}




//   //Metodo que busca los casos por estados para el mapa
public function Listar_Casos_Estados()
{

   
    $db = \Config\Database::connect();
    $builder = $db->table('sgc_casos c');
    $builder->select('e.estadoid, e.estadonom, t.tipo_aten_nombre, t.tipo_aten_id AS id_tipo_atencion, COUNT(c.idcaso) AS casos');
    $builder->join('sgc_estados e', 'c.estadoid = e.estadoid');
    $builder->join('sgc_tipoatencion_usu t', 'c.id_tipo_atencion = t.tipo_aten_id');
    $builder->where('c.borrado', false);
    $builder->where('c.idcaso IS NOT NULL'); // Agregamos esta condición para filtrar los resultados
    $builder->groupBy('e.estadoid, e.estadonom, t.tipo_aten_id, t.tipo_aten_nombre');
    $builder->orderBy('e.estadoid');
    $builder->orderBy('e.estadonom');
    $builder->orderBy('t.tipo_aten_nombre');
    
    $resultado = $builder->get()->getResult();
    return $resultado;
  
}



public function BuscarCasosExistentes($casos_existentes)
{
    $builder = $this->db->table('public.sgc_casos as c');
    $builder->select("*");
    $builder->where(['c.casoced' => $casos_existentes['casoced']]);
    $query = $builder->get();
    $result = $query->getResult();
    return count($result) > 0; // Devuelve true si hay registros, false si no
}

public function ActualizarFechaNacimiento($casos_existentes)

{
    // Intentamos actualizar la fecha de nacimiento
    $builder = $this->db->table('public.sgc_casos');
    $builder->set('fecha_nacimiento', $casos_existentes['fecha_nacimiento']);
    $builder->set('profesion', $casos_existentes['profesion']);
    $builder->set('edad', $casos_existentes['edad']);
    $builder->where('casoced', $casos_existentes['casoced']);
    $updated = $builder->update();
    return $updated; // Retorna true si se actualizó, false si no se actualizó

}


}
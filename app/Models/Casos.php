<?php

namespace App\Models;

class Casos extends BaseModel
{

    
    public function obtenerCasos()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('sgc_casos as a');
        $builder->distinct();
        $builder->select('d.tipo_atend_borrado, a.idcaso, a.tipo_beneficiario,a.tipo_atend_id, a.casotel, TRIM(a.casoced) AS casoced, a.casonom, a.casoape, a.casodesc');
        $builder->select('a.pais,a.caso_nacionalidad, a.idrrss, a.ofiid, a.estadoid, a.id_tipo_atencion');
        $builder->select('a.edad, to_char(a.fecha_nacimiento, \'dd/mm/yyyy\') as fecha_nacimiento, a.fecha_nacimiento as fecha_nacimiento_normal');
        $builder->select('a.municipioid, a.parroquiaid, a.direccion, a.correo, a.ente_adscrito_id, a.profesion');
        $builder->select('CONCAT(a.caso_nacionalidad, a.casoced) AS cedula');
        $builder->select('cgr.competencia_cgr, cgr.asume_cgr');
        $builder->select('denu.denu_afecta_persona, denu.denu_afecta_comunidad, denu.denu_afecta_terceros');
        $builder->select('denu.denu_involucrados, denu.denu_fecha_hechos, denu.denu_instancia_popular');
        $builder->select('denu.denu_rif_instancia, denu.denu_ente_financiador, denu.denu_nombre_proyecto, denu.denu_monto_aprovado');
        $builder->select('CONCAT(a.casonom, \' \', a.casoape) AS nombre');
        $builder->select('CONCAT(u_ope.usuopnom, \' \', u_ope.usuopape) AS user_name');
        $builder->select('CASE WHEN sexo = \'1\' THEN \'M\' ELSE \'F\' END as sexo');
        $builder->select('to_char(a.casofec, \'dd/mm/yyyy\') as casofec, a.casofec as casofec_normal, b.estnom');
        $builder->select('tpinte.tipo_prop_nombre, tpinte.tipo_prop_id');
        $builder->select('t_antusu.tipo_aten_nombre, t_antusu.act_pro_int');
        $builder->join('sgc_estatus b', 'b.idest = a.idest');
        $builder->join('sgc_usuario_operador u_ope', 'a.idusuopr = u_ope.idusuopr');
        $builder->join('sgc_tipoatencion_usu as t_antusu', 'a.id_tipo_atencion = t_antusu.tipo_aten_id');
        $builder->join('sgc_tipo_prop_caso as tpc', 'a.idcaso = tpc.idcaso', 'left');
        $builder->join('sgc_tipo_prop_intelec as tpinte', 'tpc.idtippropint = tpinte.tipo_prop_id', 'left');
        $builder->join('sgc_registro_cgr cgr', 'a.idcaso = cgr.id_caso', 'left');
        $builder->join('sgc_tipoatenciondetalle as d', 'a.tipo_atend_id = d.tipo_atend_id', 'left');
        $builder->join('sgc_casos_denuncias denu', 'a.idcaso = denu_id_caso', 'left');
        $builder->where('a.borrado', 'false');
        $builder->orderBy('a.idcaso', 'DESC');
        $query = $builder->get();
       // echo $db->getLastQuery(); 
        return $query->getResult();
    }


    //Metodo para obtener todos los casos por usuario
    public function obtenerCasos_filtrados_por_usuario($idusur)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('sgc_casos as a');
        $builder->distinct();
        $builder->select('a.idcaso, a.tipo_beneficiario, a.tipo_atend_id, a.casotel, TRIM(a.casoced) AS casoced, a.casonom, a.casoape, a.casodesc');
        $builder->select('a.caso_nacionalidad, a.idrrss, a.ofiid, a.estadoid, a.id_tipo_atencion');
        $builder->select('a.municipioid, a.parroquiaid, a.direccion, a.correo, a.ente_adscrito_id, a.profesion');
        $builder->select('a.edad, to_char(a.fecha_nacimiento, \'dd/mm/yyyy\') as fecha_nacimiento, a.fecha_nacimiento as fecha_nacimiento_normal');
        $builder->select('CONCAT(a.caso_nacionalidad, a.casoced) AS cedula');
        $builder->select('cgr.competencia_cgr, cgr.asume_cgr');
        $builder->select('denu.denu_afecta_persona, denu.denu_afecta_comunidad, denu.denu_afecta_terceros');
        $builder->select('denu.denu_involucrados, denu.denu_fecha_hechos, denu.denu_instancia_popular');
        $builder->select('denu.denu_rif_instancia, denu.denu_ente_financiador, denu.denu_nombre_proyecto, denu.denu_monto_aprovado');
        $builder->select('CONCAT(a.casonom, \' \', a.casoape) AS nombre');
        $builder->select('CONCAT(u_ope.usuopnom, \' \', u_ope.usuopape) AS user_name');
        $builder->select('CASE WHEN sexo = \'1\' THEN \'M\' ELSE \'F\' END as sexo');
        $builder->select('to_char(a.casofec, \'dd/mm/yyyy\') as casofec, a.casofec as casofec_normal, b.estnom');
        $builder->select('tpinte.tipo_prop_nombre, tpinte.tipo_prop_id');
        $builder->select('t_antusu.tipo_aten_nombre, t_antusu.act_pro_int');
        $builder->join('sgc_estatus b', 'b.idest = a.idest');
        $builder->join('sgc_usuario_operador u_ope', 'a.idusuopr = u_ope.idusuopr');
        $builder->join('sgc_tipoatencion_usu as t_antusu', 'a.id_tipo_atencion = t_antusu.tipo_aten_id');
        $builder->join('sgc_tipo_prop_caso as tpc', 'a.idcaso = tpc.idcaso', 'left');
        $builder->join('sgc_tipo_prop_intelec as tpinte', 'tpc.idtippropint = tpinte.tipo_prop_id', 'left');
        $builder->join('sgc_registro_cgr cgr', 'a.idcaso = cgr.id_caso', 'left');
        $builder->join('sgc_casos_denuncias denu', 'a.idcaso = denu_id_caso', 'left');
        $builder->where('a.borrado', 'false');
        $builder->where('a.idusuopr', $idusur); 
        $builder->orderBy('a.idcaso', 'DESC');
        $query = $builder->get();
        return $query->getResult();
    }


    public function listar_Casos_Remitidos($id_direccion)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('sgc_casos_remitidos as cr');
        $builder->select('cr.casos_id, CONCAT(a.caso_nacionalidad, a.casoced) AS cedula, a.casonom,a.casoape, CONCAT(a.casonom, \' \', a.casoape) AS beneficiario');
        $builder->select('a.fecha_nacimiento,a.idcaso,a.casotel,a.edad, a.tipo_beneficiario, tpinte.tipo_prop_nombre, t_antusu.tipo_aten_nombre, to_char(a.casofec, \'dd/mm/yyyy\') as casofec');
        $builder->select('a.municipioid,a.pais as paisid, a.parroquiaid, a.direccion, a.correo, a.ente_adscrito_id, TRIM(a.casoced) AS casoced');
        $builder->select('cr.direccion_id, dire.correo, a.casodesc, a.caso_nacionalidad, a.idrrss, a.ofiid, a.estadoid');
        $builder->select('a.id_tipo_atencion, a.municipioid, a.parroquiaid, a.direccion,a.profesion, a.correo, a.ente_adscrito_id');
        $builder->select('cgr.competencia_cgr, cgr.asume_cgr, denu.denu_afecta_persona, denu.denu_afecta_comunidad, denu.denu_afecta_terceros');
        $builder->select('denu.denu_involucrados, denu.denu_fecha_hechos, denu.denu_instancia_popular, denu.denu_rif_instancia');
        $builder->select('denu.denu_ente_financiador, denu.denu_nombre_proyecto, denu.denu_monto_aprovado, CONCAT(a.casonom, \' \', a.casoape) AS nombre');
        $builder->select('CONCAT(u_ope.usuopnom, \' \', u_ope.usuopape) AS user_name, CASE WHEN sexo = \'1\' THEN \'M\' ELSE \'F\' END as sexo');
        $builder->select('a.casofec as casofec_normal, b.estnom, tpinte.tipo_prop_id');
        $builder->join('sgc_direcciones_administrativas as dire', 'cr.direccion_id = dire.id');
        $builder->join('sgc_casos as a', 'cr.casos_id = a.idcaso');
        $builder->join('sgc_estatus b', 'b.idest = a.idest');
        $builder->join('sgc_usuario_operador u_ope', 'a.idusuopr = u_ope.idusuopr');
        $builder->join('sgc_tipoatencion_usu as t_antusu', 'a.id_tipo_atencion = t_antusu.tipo_aten_id');
        $builder->join('sgc_tipo_prop_caso as tpc', 'a.idcaso = tpc.idcaso', 'left');
        $builder->join('sgc_tipo_prop_intelec as tpinte', 'tpc.idtippropint = tpinte.tipo_prop_id', 'left');
        $builder->join('sgc_registro_cgr cgr', 'a.idcaso = cgr.id_caso', 'left');
        $builder->join('sgc_casos_denuncias denu', 'a.idcaso = denu_id_caso', 'left');
        $builder->where('cr.direccion_id', $id_direccion); 
        $builder->orderBy('a.idcaso', 'DESC');
        $query = $builder->get();
        return $query->getResult();
    }
  
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

        public function obtenerCaso_id($id_caso)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('sgc_casos as a');
        $builder->select('a.tipo_beneficiario, a.idcaso, a.casotel, TRIM(a.casoced) AS casoced, a.casonom, a.casoape, a.casodesc');
        $builder->select('a.caso_nacionalidad, a.idrrss, a.ofiid, a.estadoid, a.id_tipo_atencion');
        $builder->select('a.municipioid, a.parroquiaid, a.direccion, a.correo, a.ente_adscrito_id');
        $builder->select('CONCAT(a.caso_nacionalidad, a.casoced) AS cedula');
        $builder->select('cgr.competencia_cgr, cgr.asume_cgr');
        $builder->select('denu.denu_afecta_persona, denu.denu_afecta_comunidad, denu.denu_afecta_terceros');
        $builder->select('denu.denu_involucrados, denu.denu_fecha_hechos, denu.denu_instancia_popular');
        $builder->select('denu.denu_rif_instancia, denu.denu_ente_financiador, denu.denu_nombre_proyecto, denu.denu_monto_aprovado');
        $builder->select('CONCAT(a.casonom, \' \', a.casoape) AS nombre');
        $builder->select('CONCAT(u_ope.usuopnom, \' \', u_ope.usuopape) AS user_name');
        $builder->select('CASE WHEN sexo = \'1\' THEN \'M\' ELSE \'F\' END as sexo');
        $builder->select('to_char(a.casofec, \'dd/mm/yyyy\') as casofec, a.casofec as casofec_normal, b.estnom');
        $builder->select('tpinte.tipo_prop_nombre, tpinte.tipo_prop_id, t_antusu.tipo_aten_nombre');
        $builder->join('sgc_estatus b', 'b.idest = a.idest');
        $builder->join('sgc_usuario_operador u_ope', 'a.idusuopr = u_ope.idusuopr');
        $builder->join('sgc_tipo_prop_caso as tpc', 'a.idcaso = tpc.idcaso');
        $builder->join('sgc_tipo_prop_intelec as tpinte', 'tpc.idtippropint = tpinte.tipo_prop_id');
        $builder->join('sgc_tipoatencion_usu as t_antusu', 'a.id_tipo_atencion = t_antusu.tipo_aten_id');
        $builder->join('sgc_registro_cgr cgr', 'a.idcaso = cgr.id_caso', 'left');
        $builder->join('sgc_casos_denuncias denu', 'a.idcaso = denu_id_caso', 'left');
        $builder->where('a.borrado', 'false');
        $builder->where('a.idcaso', $id_caso); 
        $query = $builder->get();
        return $query->getRow(); 
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

        public function obtener_ultimos_casos(string $iduser)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('sgc_casos as a');
        $builder->select('a.idcaso, a.casotel, a.casoced');
        $builder->select('CONCAT(a.casonom, \' \', a.casoape) AS nombre');
        $builder->select('CASE WHEN sexo = \'1\' THEN \'M\' ELSE \'F\' END as sexo');
        $builder->select('to_char(a.casofec, \'dd/mm/yyyy\') as casofec, a.casofec as casofec_normal');
        $builder->select('b.estnom, tpinte.tipo_prop_nombre, t_antusu.tipo_aten_nombre');
        $builder->join('sgc_estatus b', 'b.idest = a.idest');
        $builder->join('sgc_usuario_operador c', 'a.idusuopr = c.idusuopr');
        $builder->join('sgc_tipo_prop_caso as tpc', 'a.idcaso = tpc.idcaso');
        $builder->join('sgc_tipo_prop_intelec as tpinte', 'tpc.idtippropint = tpinte.tipo_prop_id');
        $builder->join('sgc_tipoatencion_usu as t_antusu', 'a.id_tipo_atencion = t_antusu.tipo_aten_id');
        $builder->where('a.idusuopr', $iduser); 
        $builder->orderBy('a.idcaso', 'DESC');
        $builder->limit(20);
        $query = $builder->get();
        return $query->getResult();
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
     public function detalleCaso(string $idcaso)
     {
         $db = \Config\Database::connect();
         $builder = $db->table('sgc_casos as a');
         $builder->select('a.idcaso, a.casotel, TRIM(a.casoced) AS casoced, a.casonom, a.casoape, a.casodesc');
         $builder->select('a.caso_nacionalidad, a.idrrss, a.ofiid, a.estadoid, a.id_tipo_atencion, a.ente_adscrito_id');
         $builder->select('a.municipioid, a.parroquiaid, a.direccion, a.correo');
         $builder->select("CASE WHEN direc.descripcion IS NULL THEN 'No Aplica' ELSE direc.descripcion END as unidad_administrativa");
         $builder->select('est.estadonom, mun.municipionom, p.parroquianom, u_ope.usuopemail');
         $builder->select('CONCAT(a.caso_nacionalidad, a.casoced) AS cedula');
         $builder->select('CONCAT(a.casonom, \' \', a.casoape) AS nombre');
         $builder->select('CONCAT(u_ope.usuopnom, \' \', u_ope.usuopape) AS user_name');
         $builder->select("CASE WHEN sexo = '1' THEN 'M' ELSE 'F' END as sexo");
         $builder->select('to_char(a.casofec, \'dd/mm/yyyy\') as casofec, a.casofec as casofec_normal, b.estnom');
         $builder->select('tpinte.tipo_prop_nombre, tpinte.tipo_prop_id, t_antusu.tipo_aten_nombre,t_antusu.env_correo');
         $builder->join('sgc_estatus b', 'b.idest = a.idest');
         $builder->join('sgc_estados est', 'est.estadoid = a.estadoid');
         $builder->join('sgc_municipio mun', 'mun.municipioid = a.municipioid');
         $builder->join('sgc_parroquias p', 'p.parroquiaid = a.parroquiaid');
         $builder->join('sgc_usuario_operador u_ope', 'a.idusuopr = u_ope.idusuopr');
         $builder->join('sgc_tipo_prop_caso as tpc', 'a.idcaso = tpc.idcaso');
         $builder->join('sgc_tipo_prop_intelec as tpinte', 'tpc.idtippropint = tpinte.tipo_prop_id');
         $builder->join('sgc_tipoatencion_usu as t_antusu', 'a.id_tipo_atencion = t_antusu.tipo_aten_id');
         $builder->join('sgc_casos_remitidos as casos_remi', 'a.idcaso = casos_remi.casos_id', 'left');
         $builder->join('sgc_direcciones_administrativas as direc', 'casos_remi.direccion_id = direc.id', 'left');
         $builder->where('a.idcaso', $idcaso); 
         $query = $builder->get();
         $resultado = $query->getRow();
         return $resultado ? [$resultado] : []; 
     }

     //Metodo para obtener todos los casos para el reporte consolidado 

     public function reporte_consolidado($desde = null, $hasta = null, $tipo_pi = null, $tipo_atencion_usu = null, $sexo = null, $via_atencion = null, $direcciones_caso = null, $tipo_beneficiario = 0, $atencion_cuidadano = 0, $estatus = 0,$id_pais=null,$id_estado=null,$id_municipio=null,$id_parroquia=null, $edad_min = null, $edad_max = null, $detalle_atencion = 0)
     {

        
         $db = \Config\Database::connect();
         $builder = $db->table('sgc_casos as a');
         $builder->select('caso_r.casos_re_id, a.idcaso, a.casotel, TRIM(a.casoced) AS casoced, a.casonom, a.casoape, a.casodesc');
         $builder->select('a.caso_nacionalidad, a.idrrss, a.ofiid, a.estadoid, a.id_tipo_atencion');
         $builder->select("CASE WHEN ubi.descripcion IS NULL THEN 'No aplica' ELSE ubi.descripcion END as descripcion");
         $builder->select('t_bene.tipo_beneficiario_nombre as tipo_beneficiario');
         $builder->select('a.municipioid, a.parroquiaid');
         $builder->select('CONCAT(a.caso_nacionalidad, a.casoced) AS cedula');
         $builder->select('CONCAT(a.casonom, \' \', a.casoape) AS nombre');
         $builder->select('CONCAT(u_ope.usuopnom, \' \', u_ope.usuopape) AS user_name');
         $builder->select("CASE WHEN sexo='1' THEN 'M' ELSE 'F' END as sexo");
         $builder->select('to_char(a.casofec, \'dd/mm/yyyy\') as casofec, a.casofec as casofec_normal, b.estnom');
         $builder->select('tpinte.tipo_prop_nombre, tpinte.tipo_prop_id, t_antusu.tipo_aten_nombre');
         $builder->join('sgc_estatus b', 'b.idest = a.idest');
         $builder->join('sgc_usuario_operador u_ope', 'a.idusuopr = u_ope.idusuopr', 'left');
         $builder->join('sgc_tipo_prop_caso as tpc', 'a.idcaso = tpc.idcaso', 'left');
         $builder->join('sgc_tipo_beneficiarios as t_bene', 'a.tipo_beneficiario = t_bene.tipo_beneficiario_id', 'left');
         $builder->join('sgc_tipoatencion_usu as t_antusu', 'a.id_tipo_atencion = t_antusu.tipo_aten_id', 'left');
         $builder->join('sgc_tipo_prop_intelec as tpinte', 'tpc.idtippropint = tpinte.tipo_prop_id', 'left');
         $builder->join('sgc_casos_remitidos as caso_r', 'a.idcaso = caso_r.casos_id', 'left');
         $builder->join('sgc_direcciones_administrativas as ubi', 'caso_r.direccion_id = ubi.id', 'left');
         $builder->where('a.borrado', false); // Cambiar 'false' a false sin comillas
         $builder->groupStart();
         $builder->where('caso_r.vigencia', true); // Cambiar 'TRUE' a true sin comillas
         $builder->orWhere('caso_r.vigencia IS NULL');
         $builder->groupEnd();
         if ($desde != 'null' && $hasta != 'null') {
             $builder->where('a.casofec >=', $desde);
             $builder->where('a.casofec <=', $hasta);
         }

        

         if ($edad_min != 'null' && $edad_max != 'null') {
            $builder->where('edad >=', $edad_min);
            $builder->where('edad <=', $edad_max);
        }

        if ($tipo_pi != 0) {
         $builder->where('tpinte.tipo_prop_id', $tipo_pi);
        }
        if ($tipo_atencion_usu != 0) {
            $builder->where('t_antusu.tipo_aten_id', $tipo_atencion_usu);
        }
        
        if ($sexo != 0) {
            $builder->where('a.sexo', $sexo);
        }
        
        if ($via_atencion != 'null') {
            $builder->where('a.idrrss', $via_atencion);
        }
        
        if ($direcciones_caso != 'null') {
            $builder->where('caso_r.direccion_id', $direcciones_caso);
            if ($desde != 'null' && $hasta != 'null') {
                $builder->where('caso_r.fecha >=', $desde);
                $builder->where('caso_r.fecha <=', $hasta);
            }
        }
        
        if ($tipo_beneficiario != '0' && $tipo_beneficiario != 'null') {
            $builder->where('a.tipo_beneficiario', $tipo_beneficiario);
        }
        
        if ($atencion_cuidadano != '0' && $atencion_cuidadano != 'null') {
            $builder->where('a.ofiid', $atencion_cuidadano);
        }
        
        if ($estatus != '0' && $estatus != 'null') {
            $builder->where('a.idest', $estatus);
        }
        
       
        if ($id_pais != '0' && $id_pais != 'null') {
            $builder->where('a.pais', $id_pais);
        }
        if ($id_estado != '0' && $id_estado != 'null'&& $id_estado != '26') {
            $builder->where('a.estadoid', $id_estado);
        }
        if ($id_municipio != '0' && $id_municipio != 'null' && $id_municipio != '336') {
            $builder->where('a.municipioid', $id_municipio);
        }

        if ($id_parroquia != '0' && $id_parroquia != 'null'&& $id_parroquia != '1135') {
            $builder->where('a.parroquiaid', $id_parroquia);
        }

        
        $builder->orderBy('a.idcaso', 'desc');
        $query = $builder->get();
        $resultado = $query->getResult();
        //echo $db->getLastQuery(); 
        return $resultado;
    }
        
  public function reporte_operador($desde = null, $hasta = null, $tipo_pi = null, $tipo_atencion_usu = null, $sexo = null, $idusuopr, $via_atencion = null, $direcciones_caso = null, $tipo_beneficiario = 0, $usuarios = null,$id_pais=null,$id_estado=null,$id_municipio=null,$id_parroquia=null,$edad_min=null,$edad_max=null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('sgc_casos as a');
        $builder->select('a.idcaso, a.casotel, TRIM(a.casoced) AS casoced, a.casonom, a.casoape, a.casodesc');
        $builder->select('a.caso_nacionalidad, a.idrrss, a.ofiid, a.estadoid, a.id_tipo_atencion');
        $builder->select('t_bene.tipo_beneficiario_nombre as tipo_beneficiario');
        $builder->select('a.municipioid, a.parroquiaid');
        $builder->select("CASE WHEN ubi.descripcion IS NULL THEN 'No aplica' ELSE ubi.descripcion END as descripcion");
        $builder->select('CONCAT(a.caso_nacionalidad, a.casoced) AS cedula');
        $builder->select('CONCAT(a.casonom, \' \', a.casoape) AS nombre');
        $builder->select('CONCAT(u_ope.usuopnom, \' \', u_ope.usuopape) AS user_name');
        $builder->select("CASE WHEN sexo = '1' THEN 'M' ELSE 'F' END as sexo");
        $builder->select('to_char(a.casofec, \'dd/mm/yyyy\') as casofec, a.casofec as casofec_normal, b.estnom');
        $builder->select('tpinte.tipo_prop_nombre, tpinte.tipo_prop_id, t_antusu.tipo_aten_nombre');
        $builder->join('sgc_estatus b', 'b.idest = a.idest');
        $builder->join('sgc_usuario_operador u_ope', 'a.idusuopr = u_ope.idusuopr', 'left');
        $builder->join('sgc_tipo_prop_caso as tpc', 'a.idcaso = tpc.idcaso', 'left');
        $builder->join('sgc_tipo_prop_intelec as tpinte', 'tpc.idtippropint = tpinte.tipo_prop_id', 'left');
        $builder->join('sgc_tipo_beneficiarios as t_bene', 'a.tipo_beneficiario = t_bene.tipo_beneficiario_id', 'left');
        $builder->join('sgc_tipoatencion_usu as t_antusu', 'a.id_tipo_atencion = t_antusu.tipo_aten_id', 'left');
        $builder->join('sgc_casos_remitidos as caso_r', 'a.idcaso = caso_r.casos_id', 'left');
        $builder->join('sgc_direcciones_administrativas as ubi', 'caso_r.direccion_id = ubi.id', 'left');
        $builder->where('a.borrado', false); 
        $builder->groupStart();
        $builder->where('caso_r.vigencia', true);
        $builder->orWhere('caso_r.vigencia IS NULL');
        $builder->groupEnd();
        // Condiciones adicionales
        if ($usuarios != 'null') {
            $builder->where('u_ope.idusuopr', $usuarios);
        }
        if ($desde != 'null' && $hasta != 'null') {
            $builder->where('a.casofec >=', $desde);
            $builder->where('a.casofec <=', $hasta);
        }
        if ($edad_min != 'null' && $edad_max != 'null') {
            $builder->where('edad >=', $edad_min);
            $builder->where('edad <=', $edad_max);
        }
        if ($tipo_pi != 0) {
            $builder->where('tpinte.tipo_prop_id', $tipo_pi);
        }
        if ($tipo_atencion_usu != 0) {
            $builder->where('t_antusu.tipo_aten_id', $tipo_atencion_usu);
        }
        if ($sexo != 0) {
            $builder->where('a.sexo', $sexo);
        }
        if ($via_atencion != 'null') {
            $builder->where('a.idrrss', $via_atencion);
        }
        if ($direcciones_caso != 'null') {
            $builder->where('caso_r.direccion_id', $direcciones_caso);
            if ($desde != 'null' && $hasta != 'null') {
                $builder->where('caso_r.fecha >=', $desde);
                $builder->where('caso_r.fecha <=', $hasta);
            }
        }
        if ($tipo_beneficiario != '0' && $tipo_beneficiario != 'null') {
            $builder->where('a.tipo_beneficiario', $tipo_beneficiario);
        }



        if ($id_pais != '0' && $id_pais != 'null') {
            $builder->where('a.pais', $id_pais);
        }
        if ($id_estado != '0' && $id_estado != 'null'&& $id_estado != '26') {
            $builder->where('a.estadoid', $id_estado);
        }
        if ($id_municipio != '0' && $id_municipio != 'null' && $id_municipio != '336') {
            $builder->where('a.municipioid', $id_municipio);
        }

        if ($id_parroquia != '0' && $id_parroquia != 'null'&& $id_parroquia != '1135') {
            $builder->where('a.parroquiaid', $id_parroquia);
        }


        $builder->orderBy('a.idcaso', 'desc');
        $query = $builder->get();
        $resultado = $query->getResult();
       // echo $db->getLastQuery(); 
        return $resultado;

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
        $builder->where("casofec BETWEEN '$startDate' AND '$endDate'");
        $builder->groupBy('casofec');
        $result = $builder->get();
        return $result;
    }

   // Método que cuenta los Casos Atendidos por fecha (RED SOCIAL)
    public function contarCasosAtendidos_Fecha($desde, $hasta, $id_estado=null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('sgc_red_social AS red');
        $builder->select('red.red_s_id, red.red_s_nom, COALESCE(tot.count, 0) AS count');
        $subquery = '(SELECT cas.idrrss, COUNT(cas.idrrss) AS count
                    FROM sgc_casos AS cas
                    WHERE NOT cas.borrado';
        if ($desde !== null && $hasta !== null) {
            $subquery .= ' AND cas.casofec BETWEEN ' . $db->escape($desde) . ' AND ' . $db->escape($hasta);
        }
        $subquery .= ' GROUP BY cas.idrrss) AS tot';
        $builder->join($subquery, 'red.red_s_id = tot.idrrss', 'left');
        $builder->where('red.red_s_borrado', 'false');
        $builder->orderBy('red.red_s_nom', 'ASC');
        $query = $builder->get();
        $resultado = $query->getResult();
        return $resultado;
    }



    // Método que consulta los estados
    public function consultar_estados($desde = null, $hasta = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('public.sgc_estados AS estados');
        $builder->select('estados.estadoid, estados.estadonom, COUNT(c.estadoid) AS count, c.casofec');
        $builder->join('sgc_casos AS c', 'estados.estadoid = c.estadoid', 'left');
        if ($desde != 'null' && $hasta != 'null') {
            $builder->where('c.borrado', false);
            $builder->where('c.casofec >=', $desde);
            $builder->where('c.casofec <=', $hasta);
        }
        $builder->groupBy('estados.estadoid, estados.estadonom, c.casofec');
        $builder->orderBy('estados.estadonom');
        $query = $builder->get();
        $resultado = $query->getResult();

        return $resultado;
    }

    // Método que cuenta los Casos Atendidos
    public function contarCasosAtendidos()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('public.sgc_red_social AS rs');
        $builder->select('COALESCE(COUNT(c.idrrss), 0) AS count, rs.red_s_nom');
        $builder->join('public.sgc_casos AS c', 'rs.red_s_id = c.idrrss ', 'left');
        $builder->where('rs.red_s_borrado', false);
        $builder->where('c.borrado', false);
        $builder->groupBy('rs.red_s_id, rs.red_s_nom');
        $builder->orderBy('rs.red_s_nom', 'desc');
        $query = $builder->get();
        $resultado = $query->getResult();
        //echo $db->getLastQuery();
        return $resultado;
    }



    // Método que cuenta los casos ATENDIDOS GENERO MASCULINO
    public function contarCasosAtendidos_MASCULINO($desde = null, $hasta = null, $id_estado = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('public.sgc_red_social AS rs');
        $builder->select('COALESCE(COUNT(c.idrrss), 0) AS count, rs.red_s_nom');
        $builder->join('public.sgc_casos AS c', 'rs.red_s_id = c.idrrss', 'left');
        $builder->where('c.borrado', false);
        if ($desde != 'null' && $hasta != 'null') {
            $builder->where('c.casofec >=', $desde);
            $builder->where('c.casofec <=', $hasta);
        }
        if ($id_estado != 'null' && $id_estado != null) {
            $builder->where('c.estadoid', $id_estado);
        }
        $builder->where('c.sexo', '1');
        $builder->groupBy('rs.red_s_id, rs.red_s_nom');
        $builder->orderBy('rs.red_s_nom', 'desc');
        $query = $builder->get();
        $resultado = $query->getResult();
        return $resultado;
    }

    // Método que cuenta los casos ATENDIDOS GENERO FEMENINO
    public function contarCasosAtendidos_FEMENINO($desde = null, $hasta = null, $id_estado = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('public.sgc_red_social AS rs');
        $builder->select('COALESCE(COUNT(c.idrrss), 0) AS count, rs.red_s_nom');
        $builder->join('public.sgc_casos AS c', 'rs.red_s_id = c.idrrss', 'left');
        $builder->where('c.borrado', false);
        $builder->where('c.sexo', '2');
        if ($desde != 'null' && $hasta != 'null') {
            $builder->where('c.casofec >=', $desde);
            $builder->where('c.casofec <=', $hasta);
        }
        if ($id_estado != 'null' && $id_estado != null) {
            $builder->where('c.estadoid', $id_estado);
        }
        $builder->groupBy('rs.red_s_id, rs.red_s_nom');
        $builder->orderBy('rs.red_s_nom', 'desc');
        $query = $builder->get();
        $resultado = $query->getResult();
        return $resultado;
    }

    
    // Método que cuenta los Casos Atendidos por tipo de Solicitud por Fecha
    public function contarCasosTipoSolicitudFecha($desde = null, $hasta = null, $id_estado = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('sgc_tipoatencion_usu AS tip');
        $builder->select('tip.tipo_aten_id, tip.tipo_aten_nombre, COALESCE(tot.count, 0) AS count');
        $subquery = '(SELECT cas.id_tipo_atencion, COUNT(cas.id_tipo_atencion) AS count
                    FROM sgc_casos AS cas
                    WHERE NOT cas.borrado';
        if ($desde !== null && $hasta !== null) {
            $subquery .= ' AND cas.casofec BETWEEN ' . $db->escape($desde) . ' AND ' . $db->escape($hasta);
        }
        $subquery .= ' GROUP BY cas.id_tipo_atencion) AS tot';
        $builder->join($subquery, 'tip.tipo_aten_id = tot.id_tipo_atencion', 'left');
        $builder->where('tip.tipo_aten_borrado', 'false');
        $builder->orderBy('tip.tipo_aten_nombre', 'ASC');
        $query = $builder->get();
        $resultado = $query->getResult();
        return $resultado;
    }
    
    // Método que cuenta los casos por propiedad Intelectual
    public function contarCasosPorPI()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('sgc_casos as c');
        $builder->join('sgc_tipo_prop_caso as tip_caso', 'c.idcaso = tip_caso.idcaso');
        $builder->join('sgc_tipo_prop_intelec as tp_proint', 'tip_caso.idtippropint = tp_proint.tipo_prop_id');
        $builder->select('COUNT(DISTINCT tp_proint.tipo_prop_nombre) as count, tp_proint.tipo_prop_nombre');
        $builder->where('c.borrado', false);
        $builder->groupBy('tp_proint.tipo_prop_nombre');
        $query = $builder->get();
        $resultado = $query->getResult();
        return $resultado;
    }

 
    
    //Metodo que cuenta los Casos Atendididos por tipo de SOlicitud
    public function contarCasosAtencionCiudadano()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('sgc_tipoatencion_usu');

        // Subconsulta para obtener el conteo de casos
        $subQueryCasos = $db->table('sgc_casos')
            ->select('count(idcaso) as veces, id_tipo_atencion')
            ->where('borrado', 'false')
            ->groupBy('id_tipo_atencion');

        // Subconsulta para obtener los tipos de atención
        $subQueryTipoAtencion = $builder
            ->select('tipo_aten_nombre, tipo_aten_id')
            ->where('tipo_aten_borrado', 'false')
            ->orderBy('tipo_aten_id', 'ASC');

        // Crear la consulta principal utilizando el Query Builder
        $query = $db->table('sgc_tipoatencion_usu AS tipoaten')
            ->select('tipoaten.tipo_aten_nombre, COALESCE(casos.veces, 0) AS count')
            ->join("({$subQueryCasos->getCompiledSelect()}) AS casos", 'casos.id_tipo_atencion = tipoaten.tipo_aten_id', 'left')
            ->where('tipoaten.tipo_aten_borrado', 'false')
            ->orderBy('tipoaten.tipo_aten_nombre', 'ASC');

        // Ejecutar la consulta
        $resultado = $query->get()->getResult();
        return $resultado; 
    }


    // Método que cuenta los Casos Atendidos por tipo de Solicitud Masculino
    public function contarCasosTipoSolicitudMasculino($desde = null, $hasta = null, $id_estado = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('sgc_tipoatencion_usu AS tip_ate');
        $builder->select('tip_ate.tipo_aten_nombre, COALESCE(COUNT(c.idcaso), 0) AS count');
        $builder->join('public.sgc_casos AS c', 'c.id_tipo_atencion = tip_ate.tipo_aten_id AND c.sexo = \'1\'', 'left');
        $builder->where('c.borrado', false);
        if ($desde != 'null' && $hasta != 'null') {
            $builder->where('c.casofec >=', $desde);
            $builder->where('c.casofec <=', $hasta);
        }
        if ($id_estado != 'null' && $id_estado != null) {
            $builder->where('c.estadoid', $id_estado);
        }
        $builder->where('tip_ate.tipo_aten_borrado', false);
        $builder->groupBy('tip_ate.tipo_aten_nombre');
        $builder->orderBy('tip_ate.tipo_aten_nombre', 'ASC');
        $query = $builder->get();
        $resultado = $query->getResult();
        return $resultado; 
    }

    // Método que cuenta los Casos Atendidos por tipo de Solicitud Femenino
    public function contarCasosTipoSolicitudFemenino($desde = null, $hasta = null, $id_estado = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('sgc_tipoatencion_usu AS tip_ate');
        $builder->select('tip_ate.tipo_aten_nombre, COALESCE(COUNT(c.idcaso), 0) AS count');
        $builder->join('public.sgc_casos AS c', 'c.id_tipo_atencion = tip_ate.tipo_aten_id  AND c.sexo = \'2\'', 'left');
        $builder->where('c.borrado', false);
        if ($desde != 'null' && $hasta != 'null') {
            $builder->where('c.casofec >=', $desde);
            $builder->where('c.casofec <=', $hasta);
        }
        if ($id_estado != 'null' && $id_estado != null) {
            $builder->where('c.estadoid', $id_estado);
        }
        $builder->where('tip_ate.tipo_aten_borrado', false);
        $builder->groupBy('tip_ate.tipo_aten_nombre');
        $builder->orderBy('tip_ate.tipo_aten_nombre', 'ASC');
        $query = $builder->get();
        $resultado = $query->getResult();
        return $resultado; 
    }


    // Método que cuenta los Casos POR ESTATUS
    public function contarCasosEstatus()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('sgc_estatus AS estatus');
        $builder->select('estatus.estnom, COALESCE(casos.veces, 0) AS count');
        $builder->join('(SELECT COUNT(c.idcaso) AS veces, c.idest 
                        FROM sgc_casos c 
                        WHERE c.borrado = false 
                        GROUP BY c.idest) AS casos', 'casos.idest = estatus.idest', 'left');
        $builder->where('estatus.borrado', false);
        $builder->orderBy('estatus.estnom', 'ASC');
        $query = $builder->get();
        $resultado = $query->getResult();

        return $resultado;
    }

    // Método que consulta el estatus de casos por estados
    public function consultar_estatus_caso_estados($desde = null, $hasta = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('sgc_estatus AS estatus');
        $builder->select('COALESCE(estatus.estnom, \'No Aplica\') AS estnom, estados.estadonom, estados.estadoid, casos.casofec, COALESCE(casos.veces, 0) AS count');
        $builder->join('(SELECT COUNT(c.idcaso) AS veces, c.idest, c.estadoid, c.casofec 
                        FROM sgc_casos c 
                        GROUP BY c.idest, c.estadoid, c.casofec) AS casos', 'casos.idest = estatus.idest', 'left');
        $builder->join('public.sgc_estados AS estados', 'casos.estadoid = estados.estadoid', 'right');
        $builder->where('estatus.borrado', false);
        if ($desde != 'null' && $hasta != 'null') {
            $builder->where('casos.casofec >=', $desde);
            $builder->where('casos.casofec <=', $hasta);
        }
        $builder->orderBy('estados.estadonom', 'ASC');
        $query = $builder->get();
        $resultado = $query->getResult();
        return $resultado;
    }


    // Método que cuenta los casos estadales por tipo de beneficiario
    public function ContarCasos_Estadal_Tipo_Beneficiario($desde = null, $hasta = null)
    { 
        $db = \Config\Database::connect();
        $builder = $db->table('sgc_casos AS c');
        $builder->select('COALESCE(COUNT(c.tipo_beneficiario), 0) AS count, COALESCE(tb.tipo_beneficiario_nombre, \'No Aplica\') AS tipo_beneficiario_nombre, estados.estadonom');
        $builder->join('sgc_tipo_beneficiarios AS tb', 'c.tipo_beneficiario = tb.tipo_beneficiario_id', 'right');
        $builder->join('public.sgc_estados AS estados', 'c.estadoid = estados.estadoid', 'right');
        $builder->where('COALESCE(c.borrado, FALSE)', false);
        $builder->where('COALESCE(tb.tipo_beneficiario_borrado, FALSE)', false);
        if ($desde != 'null' && $hasta != 'null') {
            $builder->where('c.casofec >=', $desde);
            $builder->where('c.casofec <=', $hasta);
        }
        $builder->groupBy('tb.tipo_beneficiario_nombre, estados.estadonom');
        $builder->orderBy('estados.estadonom', 'ASC');
        $query = $builder->get();
        $resultado = $query->getResult();
        return $resultado;
    }


    // Método que cuenta los casos estadales por tipo de propiedad intelectual
    public function ContarCasos_Estadal_Tipo_Prop_Intelectual($desde = null, $hasta = null)
    { 
        $db = \Config\Database::connect();
        $builder = $db->table('sgc_casos AS c');
        $builder->select('COUNT(tp_proint.tipo_prop_nombre) AS count, tp_proint.tipo_prop_nombre, estados.estadonom');
        $builder->join('sgc_tipo_prop_caso AS tip_caso', 'c.idcaso = tip_caso.idcaso');
        $builder->join('sgc_tipo_prop_intelec AS tp_proint', 'tip_caso.idtippropint = tp_proint.tipo_prop_id');
        $builder->join('public.sgc_estados AS estados', 'c.estadoid = estados.estadoid', 'right');
        $builder->where('c.borrado', false);
        if ($desde != 'null' && $hasta != 'null') {
            $builder->where('c.casofec >=', $desde);
            $builder->where('c.casofec <=', $hasta);
        }
        $builder->groupBy('tp_proint.tipo_prop_nombre, estados.estadonom');
        $query = $builder->get();
        $resultado = $query->getResult();
        return $resultado;
    }





    // Método que cuenta los casos atendidos por tipo de atención estadales
    public function ContarasosTipoSolicitud_Estadal($desde = null, $hasta = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('sgc_casos AS c');
        $builder->select('COALESCE(COUNT(c.id_tipo_atencion), 0) AS count, COALESCE(aten.tipo_aten_nombre, \'No Aplica\') AS tipo_aten_nombre, estados.estadonom');
        $builder->join('sgc_tipoatencion_usu AS aten', 'c.id_tipo_atencion = aten.tipo_aten_id', 'right');
        $builder->join('public.sgc_estados AS estados', 'c.estadoid = estados.estadoid', 'right');
        $builder->where('COALESCE(c.borrado, FALSE)', false);
        $builder->where('COALESCE(aten.tipo_aten_borrado, FALSE)', false);
        if ($desde != 'null' && $hasta != 'null') {
            $builder->where('c.casofec >=', $desde);
            $builder->where('c.casofec <=', $hasta);
        }
        $builder->groupBy('aten.tipo_aten_nombre, estados.estadonom');
        $builder->orderBy('estados.estadonom', 'ASC');
        $query = $builder->get();
        $resultado = $query->getResult();
        return $resultado; 
    }





    // Método que cuenta los casos atendidos con filtros
    public function contarCasosAtendidos_filtros($desde = null, $hasta = null, $id_estado = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('sgc_casos AS c');
        $builder->select('COUNT(red_s.red_s_nom) AS count, red_s.red_s_nom');
        $builder->join('sgc_red_social AS red_s', 'c.idrrss = red_s.red_s_id');
        $builder->where('c.borrado', false);
        if ($desde != 'null' && $hasta != 'null') {
            $builder->where('c.casofec >=', $desde);
            $builder->where('c.casofec <=', $hasta);
        }
        if ($id_estado != 'null' && $id_estado != null) {
            $builder->where('c.estadoid', $id_estado);
        }
        $builder->groupBy('red_s.red_s_nom');
        $query = $builder->get();
        $resultado = $query->getResult();
        return $resultado;
    }

    
    // Método que cuenta los casos por estatus y por fecha
    public function contarCasosEstatusFecha($desde = null, $hasta = null, $id_estado = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('sgc_estatus AS est');
        $builder->select('COALESCE(COUNT(c.idest), 0) AS count, est.estnom');
        $builder->join('public.sgc_casos AS c', 'c.idest = est.idest ', 'left');
        $builder->where('c.borrado', false);
        if ($desde != 'null' && $hasta != 'null') {
            $builder->where('c.casofec >=', $desde);
            $builder->where('c.casofec <=', $hasta);
        }
        if ($id_estado != 'null' && $id_estado != null) {
            $builder->where('c.estadoid', $id_estado);
        }
        $builder->groupBy('est.estnom');
        $query = $builder->get();
        $resultado = $query->getResult();
        return $resultado;
    }


    // Método que cuenta los casos por propiedad intelectual
    public function contarCasosPorPI_filtros($desde = null, $hasta = null, $id_estado = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('sgc_casos AS c');
        $builder->select('COUNT(tp_proint.tipo_prop_nombre) AS count, tp_proint.tipo_prop_nombre');
        $builder->join('sgc_tipo_prop_caso AS tip_caso', 'c.idcaso = tip_caso.idcaso');
        $builder->join('sgc_tipo_prop_intelec AS tp_proint', 'tip_caso.idtippropint = tp_proint.tipo_prop_id');
        $builder->where('c.borrado', false);
        if ($desde != 'null' && $hasta != 'null') {
            $builder->where('c.casofec >=', $desde);
            $builder->where('c.casofec <=', $hasta);
        }
        if ($id_estado != 'null' && $id_estado != null) {
            $builder->where('c.estadoid', $id_estado);
        }
        $builder->groupBy('tp_proint.tipo_prop_nombre');
        $query = $builder->get();
        $resultado = $query->getResult();
        return $resultado;
    }


    // Método que cuenta los casos de propiedad intelectual género masculino
    public function contarCasos_PI_MASCULINO($desde = null, $hasta = null, $id_estado = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('sgc_casos AS c');
        $builder->select('COUNT(tp_proint.tipo_prop_nombre) AS count, tp_proint.tipo_prop_nombre');
        $builder->join('sgc_tipo_prop_caso AS tip_caso', 'c.idcaso = tip_caso.idcaso');
        $builder->join('sgc_tipo_prop_intelec AS tp_proint', 'tip_caso.idtippropint = tp_proint.tipo_prop_id');
        $builder->where('c.sexo', '1');
        if ($desde != 'null' && $hasta != 'null') {
            $builder->where('c.casofec >=', $desde);
            $builder->where('c.casofec <=', $hasta);
        }
        if ($id_estado != 'null' && $id_estado != null) {
            $builder->where('c.estadoid', $id_estado);
        }
        $builder->where('c.borrado', false);
        $builder->groupBy('tp_proint.tipo_prop_nombre');
        $query = $builder->get();
        $resultado = $query->getResult();
        return $resultado;
    }
    // Método que cuenta los casos de propiedad intelectual género femenino
    public function contarCasos_PI_FEMENINO($desde = null, $hasta = null, $id_estado = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('sgc_casos AS c');
        $builder->select('COUNT(tp_proint.tipo_prop_nombre) AS count, tp_proint.tipo_prop_nombre');
        $builder->join('sgc_tipo_prop_caso AS tip_caso', 'c.idcaso = tip_caso.idcaso');
        $builder->join('sgc_tipo_prop_intelec AS tp_proint', 'tip_caso.idtippropint = tp_proint.tipo_prop_id');
        $builder->where('c.sexo', '2');
        if ($desde != 'null' && $hasta != 'null') {
            $builder->where('c.casofec >=', $desde);
            $builder->where('c.casofec <=', $hasta);
        }
        if ($id_estado != 'null' && $id_estado != null) {
            $builder->where('c.estadoid', $id_estado);
        }
        $builder->where('c.borrado', false);
        $builder->groupBy('tp_proint.tipo_prop_nombre');
        $query = $builder->get();
        $resultado = $query->getResult();
        return $resultado;
    }

    // Método que cuenta los casos por tipo de beneficiario
    public function contarCasos_Tipo_Beneficiario($desde = null, $hasta = null, $id_estado = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('sgc_tipo_beneficiarios AS tb');
        $builder->select('COALESCE(COUNT(c.tipo_beneficiario), 0) AS count, tb.tipo_beneficiario_nombre');
        $builder->join('sgc_casos AS c', 'c.tipo_beneficiario = tb.tipo_beneficiario_id', 'right');
        $builder->where('c.borrado', 'false');
        $builder->orWhere('c.tipo_beneficiario IS NULL');
        $builder->where('tb.tipo_beneficiario_borrado', 'false');
        // Agregamos condiciones de fecha si están presentes
        if ($desde != 'null' && $hasta != 'null') {
            $builder->where('c.casofec >=', $desde);
            $builder->where('c.casofec <=', $hasta);
        }
        // Agregamos condición de estado si está presente
        if ($id_estado != 'null' && $id_estado != null) {
            $builder->where('c.estadoid', $id_estado);
        }
        $builder->groupBy('tb.tipo_beneficiario_nombre');
        $builder->orderBy('tb.tipo_beneficiario_nombre', 'ASC');
        $query = $builder->get();
        $resultado = $query->getResult();
        return $resultado;
    }


    // Método que cuenta los casos por tipo de beneficiario en función de la fecha
    public function contarCasos_Tipo_Beneficiario_fecha($desde = null, $hasta = null, $id_estado = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('sgc_tipo_beneficiarios AS tb');
        $builder->select('tb.tipo_beneficiario_id, tb.tipo_beneficiario_nombre, COALESCE(SUM(casos_fecha.count), 0) AS total_fecha_tipo, COALESCE(SUM(casos_fecha.count), 0) AS count');
        $subQuery = $db->table('sgc_casos AS c')
            ->select('c.casofec, c.tipo_beneficiario, COUNT(c.tipo_beneficiario) AS count');
        if ($desde != 'null' && $hasta != 'null') {
            $subQuery->where('c.casofec >=', $desde);
            $subQuery->where('c.casofec <=', $hasta);
        }
        if ($id_estado != 'null' && $id_estado != null) {
            $subQuery->where('c.estadoid', $id_estado);
        }
        $subQuery->groupBy('c.tipo_beneficiario, c.casofec');
        $subQueryString = $subQuery->getCompiledSelect();
        $builder->join("($subQueryString) AS casos_fecha", 'tb.tipo_beneficiario_id = casos_fecha.tipo_beneficiario', 'left');
        $builder->groupBy('tb.tipo_beneficiario_id, tb.tipo_beneficiario_nombre');
        $builder->orderBy('tb.tipo_beneficiario_nombre', 'ASC');
        $query = $builder->get();
        $resultado = $query->getResult();
        return $resultado;
    }

   
    // Método que cuenta los casos por ATENCION CIUDADANO filtro
    public function contarCasosAtencionCiudadano_filtro($desde = null, $hasta = null, $id_estado = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('sgc_casos AS c');
        $builder->select('COUNT(tipoaten.tipo_aten_nombre) AS total, tipoaten.tipo_aten_nombre');
        $builder->join('sgc_tipoatencion_usu AS tipoaten', 'c.id_tipo_atencion = tipoaten.tipo_aten_id');
        if ($desde != 'null' && $hasta != 'null') {
            $builder->where('c.casofec >=', $desde);
            $builder->where('c.casofec <=', $hasta);
        }
        if ($id_estado != 'null' && $id_estado != null) {
            $builder->where('c.estadoid', $id_estado);
        }
        $builder->where('c.borrado', false);
        $builder->groupBy('tipoaten.tipo_aten_nombre');
        $query = $builder->get();
        $resultado = $query->getResult();
        return $resultado;
    }
  
    // BUSCAMOS LOS CASOS ABIERTOS
    public function contarCasosAbiertos($desde, $hasta, $id_estado = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('sgc_casos AS c');
        $builder->select('COUNT(idest) AS total, idest');
        $builder->where('c.idest', '1');
        $builder->where('c.borrado', false);
        if ($desde != 'null' && $hasta != 'null') {
            $builder->where('c.casofec >=', $desde);
            $builder->where('c.casofec <=', $hasta);
        }
        if ($id_estado != 'null' && $id_estado != null) {
            $builder->where('c.estadoid', $id_estado);
        }
        $builder->groupBy('idest');
        $query = $builder->get();
        $resultado = $query->getResult();
        return $resultado;
    }


    // BUSCAMOS LOS CASOS ABIERTOS ESTADALES
    public function ContarCasosAbiertosEstadal($desde, $hasta)
    {
        $db = \Config\Database::connect();
        $subQuery = $db->table('sgc_casos')
            ->select('COUNT(idest) AS abiertos, estadoid')
            ->where('idest', '1')
            ->where('borrado', false);
        if ($desde != 'null' && $hasta != 'null') {
            $subQuery->where('casofec >=', $desde);
            $subQuery->where('casofec <=', $hasta);
        }
        $subQuery->groupBy('estadoid');
        $subQueryString = $subQuery->getCompiledSelect();
        $builder = $db->table('sgc_estados AS estados');
        $builder->select('estados.estadonom, COALESCE(cuenta.abiertos, 0) AS abiertos');
        $builder->join("($subQueryString) AS cuenta", 'estados.estadoid = cuenta.estadoid', 'left');
        $builder->orderBy('estados.estadonom');
        $query = $builder->get();
        $resultado = $query->getResult();

        return $resultado;
    }

    // BUSCAMOS LOS CASOS CERRADOS ESTADALES
    public function ContarCasosCerradosEstadal($desde, $hasta)
    {
        $db = \Config\Database::connect();
        $subQuery = $db->table('sgc_casos')
            ->select('COUNT(idest) AS cerrados, estadoid')
            ->where('idest', '2')
            ->where('borrado', false);
        if ($desde != 'null' && $hasta != 'null') {
            $subQuery->where('casofec >=', $desde);
            $subQuery->where('casofec <=', $hasta);
        }
        $subQuery->groupBy('estadoid');
        $subQueryString = $subQuery->getCompiledSelect();
        $builder = $db->table('sgc_estados AS estados');
        $builder->select('estados.estadonom, COALESCE(cuenta.cerrados, 0) AS cerrados');
        $builder->join("($subQueryString) AS cuenta", 'estados.estadoid = cuenta.estadoid', 'left');
        $builder->orderBy('estados.estadonom');
        $query = $builder->get();
        $resultado = $query->getResult();
        return $resultado;
    }


    // BUSCAMOS LOS CASOS ESTADALES POR TIPO DE BENEFICIARIO USUARIO
    public function ContarCasosUsuariosEstadal($desde, $hasta)
    {
        $db = \Config\Database::connect();
        $subQuery = $db->table('sgc_casos AS c')
            ->select('COUNT(c.idcaso) AS usuario, c.estadoid')
            ->where('c.tipo_beneficiario', 1)
            ->where('c.borrado', 'false');
        if ($desde != 'null' && $hasta != 'null') {
            $subQuery->where('c.casofec >=', $desde);
            $subQuery->where('c.casofec <=', $hasta);
        }
        $subQuery->groupBy('c.estadoid');
        $subQueryString = $subQuery->getCompiledSelect();
        $builder = $db->table('sgc_estados AS estados');
        $builder->select('estados.estadonom, COALESCE(cuenta.usuario, 0) AS usuario');
        $builder->join("($subQueryString) AS cuenta", 'estados.estadoid = cuenta.estadoid', 'left');
        $builder->orderBy('estados.estadonom');
        $query = $builder->get();
        $resultado = $query->getResult();
        return $resultado;
    }

    // BUSCAMOS LOS CASOS ESTADALES POR TIPO DE BENEFICIARIO EMPRENDEDOR
    public function ContarCasosEmprendedorEstadal($desde, $hasta)
    {
        $db = \Config\Database::connect();
        $subQuery = $db->table('sgc_casos AS c')
            ->select('COUNT(c.idcaso) AS emprendedor, c.estadoid')
            ->where('c.tipo_beneficiario', 2)
            ->where('c.borrado', false);
        if ($desde != 'null' && $hasta != 'null') {
            $subQuery->where('c.casofec >=', $desde);
            $subQuery->where('c.casofec <=', $hasta);
        }
        $subQuery->groupBy('c.estadoid');
        $subQueryString = $subQuery->getCompiledSelect();
        $builder = $db->table('sgc_estados AS estados');
        $builder->select('estados.estadonom, COALESCE(cuenta.emprendedor, 0) AS emprendedor');
        $builder->join("($subQueryString) AS cuenta", 'estados.estadoid = cuenta.estadoid', 'left');
        $builder->orderBy('estados.estadonom');
        $query = $builder->get();
        $resultado = $query->getResult();
        return $resultado;
    }


    // BUSCAMOS LOS CASOS ESTADALES POR TIPO DE PROPIEDAD INTELECTUAL PATENTES
    public function ContarCasosPatentesEstadal($desde, $hasta)
    {
        $db = \Config\Database::connect();
        $subQuery = $db->table('sgc_casos AS c')
            ->select('COUNT(c.idcaso) AS cuenta, t.idtippropint, c.estadoid')
            ->join('sgc_tipo_prop_caso AS t', 'c.idcaso = t.idcaso')
            ->where('t.idtippropint', 2)
            ->where('c.borrado', false);
        if ($desde != 'null' && $hasta != 'null') {
            $subQuery->where('c.casofec >=', $desde);
            $subQuery->where('c.casofec <=', $hasta);
        }
        $subQuery->groupBy('t.idtippropint, c.estadoid');
        $subQueryString = $subQuery->getCompiledSelect();
        $builder = $db->table('sgc_estados AS estados');
        $builder->select('estados.estadonom, COALESCE(tipo.cuenta, 0) AS patentes');
        $builder->join("($subQueryString) AS tipo", 'tipo.estadoid = estados.estadoid', 'left');
        $builder->orderBy('estados.estadonom');
        $query = $builder->get();
        $resultado = $query->getResult();
        return $resultado;
    }

    // BUSCAMOS LOS CASOS ESTADALES POR TIPO DE PROPIEDAD INTELECTUAL NO APLICA
    public function ContarCasosNoAplicaEstadal($desde, $hasta)
    {
        $db = \Config\Database::connect();
        $subQuery = $db->table('sgc_casos AS c')
            ->select('COUNT(c.idcaso) AS cuenta, t.idtippropint, c.estadoid')
            ->join('sgc_tipo_prop_caso AS t', 'c.idcaso = t.idcaso')
            ->where('t.idtippropint', 1)
            ->where('c.borrado', false);
        if ($desde != 'null' && $hasta != 'null') {
            $subQuery->where('c.casofec >=', $desde);
            $subQuery->where('c.casofec <=', $hasta);
        }
        $subQuery->groupBy('t.idtippropint, c.estadoid');
        $subQueryString = $subQuery->getCompiledSelect();
        $builder = $db->table('sgc_estados AS estados');
        $builder->select('estados.estadonom, COALESCE(tipo.cuenta, 0) AS no_aplica');
        $builder->join("($subQueryString) AS tipo", 'tipo.estadoid = estados.estadoid', 'left');
        $builder->orderBy('estados.estadonom');
        $query = $builder->get();
        $resultado = $query->getResult();
        return $resultado;
    }


    // BUSCAMOS LOS CASOS ESTADALES POR TIPO DE PROPIEDAD INTELECTUAL DERECHO DE AUTOR
    public function ContarCasosDerecho_AutorEstadal($desde, $hasta)
    {
        $db = \Config\Database::connect();
        $subQuery = $db->table('sgc_casos AS c')
            ->select('COUNT(c.idcaso) AS cuenta, t.idtippropint, c.estadoid')
            ->join('sgc_tipo_prop_caso AS t', 'c.idcaso = t.idcaso')
            ->where('t.idtippropint', 3)
            ->where('c.borrado', false);
        if ($desde != 'null' && $hasta != 'null') {
            $subQuery->where('c.casofec >=', $desde);
            $subQuery->where('c.casofec <=', $hasta);
        }
        $subQuery->groupBy('t.idtippropint, c.estadoid');
        $subQueryString = $subQuery->getCompiledSelect();
        $builder = $db->table('sgc_estados AS estados');
        $builder->select('estados.estadonom, COALESCE(tipo.cuenta, 0) AS derecho_autor');
        $builder->join("($subQueryString) AS tipo", 'tipo.estadoid = estados.estadoid', 'left');
        $builder->orderBy('estados.estadonom');
        $query = $builder->get();
        $resultado = $query->getResult();
        return $resultado;
    }

    // BUSCAMOS LOS CASOS ESTADALES POR TIPO DE PROPIEDAD INTELECTUAL INDICACIONES GEOGRÁFICAS
    public function ContarCasosIndicaciondesGeograficas($desde, $hasta)
    {
        $db = \Config\Database::connect();
        $subQuery = $db->table('sgc_casos AS c')
            ->select('COUNT(c.idcaso) AS cuenta, t.idtippropint, c.estadoid')
            ->join('sgc_tipo_prop_caso AS t', 'c.idcaso = t.idcaso')
            ->where('t.idtippropint', 4)
            ->where('c.borrado', false);
        if ($desde != 'null' && $hasta != 'null') {
            $subQuery->where('c.casofec >=', $desde);
            $subQuery->where('c.casofec <=', $hasta);
        }
        $subQuery->groupBy('t.idtippropint, c.estadoid');
        $subQueryString = $subQuery->getCompiledSelect();
        $builder = $db->table('sgc_estados AS estados');
        $builder->select('estados.estadonom, COALESCE(tipo.cuenta, 0) AS indicacione_geograficas');
        $builder->join("($subQueryString) AS tipo", 'tipo.estadoid = estados.estadoid', 'left');
        $builder->orderBy('estados.estadonom');
        $query = $builder->get();
        $resultado = $query->getResult();
        return $resultado;
    }
    // BUSCAMOS LOS CASOS ESTADALES POR TIPO DE PROPIEDAD INTELECTUAL MARCAS
    public function ContarCasosMarcas($desde, $hasta)
    {
        $db = \Config\Database::connect();
        $subQuery = $db->table('sgc_casos AS c')
            ->select('COUNT(c.idcaso) AS cuenta, t.idtippropint, c.estadoid')
            ->join('sgc_tipo_prop_caso AS t', 'c.idcaso = t.idcaso')
            ->where('t.idtippropint', 5)
            ->where('c.borrado', 'false');
        if ($desde != 'null' && $hasta != 'null') {
            $subQuery->where('c.casofec >=', $desde);
            $subQuery->where('c.casofec <=', $hasta);
        }
        $subQuery->groupBy('t.idtippropint, c.estadoid');
        $subQueryString = $subQuery->getCompiledSelect();
        $builder = $db->table('sgc_estados AS estados');
        $builder->select('estados.estadonom, COALESCE(tipo.cuenta, 0) AS marcas');
        $builder->join("($subQueryString) AS tipo", 'tipo.estadoid = estados.estadoid', 'left');
        $builder->orderBy('estados.estadonom');
        $query = $builder->get();
        $resultado = $query->getResult();
        return $resultado;
    }

    // BUSCAMOS LOS CASOS ESTADALES POR TIPO DE ATENCIÓN ASESORÍA
    public function ContarCasosAsesoriaEstadal($desde, $hasta)
    {
        $db = \Config\Database::connect();
        $subQuery = $db->table('sgc_casos AS c')
            ->select('COUNT(c.idcaso) AS cuenta, t.tipo_aten_id, c.estadoid')
            ->join('sgc_tipoatencion_usu AS t', 'c.id_tipo_atencion = t.tipo_aten_id')
            ->where('t.tipo_aten_id', 1)
            ->where('c.borrado', false);
        if ($desde != 'null' && $hasta != 'null') {
            $subQuery->where('c.casofec >=', $desde);
            $subQuery->where('c.casofec <=', $hasta);
        }
        $subQuery->groupBy('t.tipo_aten_id, c.estadoid');
        $subQueryString = $subQuery->getCompiledSelect();
        $builder = $db->table('sgc_estados AS estados');
        $builder->select('estados.estadonom, COALESCE(tipo.cuenta, 0) AS asesoria');
        $builder->join("($subQueryString) AS tipo", 'tipo.estadoid = estados.estadoid', 'left');
        $builder->orderBy('estados.estadonom');
        $query = $builder->get();
        $resultado = $query->getResult();
        return $resultado;
    }
    /// BUSCAMOS LOS CASOS ESTADALES POR TIPO DE ATENCIÓN SUGERENCIA
    public function ContarCasosSugerenciaEstadal($desde, $hasta)
    {
        $db = \Config\Database::connect();
        $subQuery = $db->table('sgc_casos AS c')
            ->select('COUNT(c.idcaso) AS cuenta, t.tipo_aten_id, c.estadoid')
            ->join('sgc_tipoatencion_usu AS t', 'c.id_tipo_atencion = t.tipo_aten_id')
            ->where('t.tipo_aten_id', 2)
            ->where('c.borrado', false);
        if ($desde != 'null' && $hasta != 'null') {
            $subQuery->where('c.casofec >=', $desde);
            $subQuery->where('c.casofec <=', $hasta);
        }
        $subQuery->groupBy('t.tipo_aten_id, c.estadoid');
        $subQueryString = $subQuery->getCompiledSelect();
        $builder = $db->table('sgc_estados AS estados');
        $builder->select('estados.estadonom, COALESCE(tipo.cuenta, 0) AS sugerencia');
        $builder->join("($subQueryString) AS tipo", 'tipo.estadoid = estados.estadoid', 'left');
        $builder->orderBy('estados.estadonom');
        $query = $builder->get();
        $resultado = $query->getResult();
        return $resultado;
    }

    // BUSCAMOS LOS CASOS ESTADALES POR TIPO DE ATENCIÓN QUEJA
    public function ContarCasosQuejaEstadal($desde, $hasta)
    {
        $db = \Config\Database::connect();
        $subQuery = $db->table('sgc_casos AS c')
            ->select('COUNT(c.idcaso) AS cuenta, t.tipo_aten_id, c.estadoid')
            ->join('sgc_tipoatencion_usu AS t', 'c.id_tipo_atencion = t.tipo_aten_id')
            ->where('t.tipo_aten_id', 3)
            ->where('c.borrado', false);
        if ($desde != 'null' && $hasta != 'null') {
            $subQuery->where('c.casofec >=', $desde);
            $subQuery->where('c.casofec <=', $hasta);
        }
        $subQuery->groupBy('t.tipo_aten_id, c.estadoid');
        $subQueryString = $subQuery->getCompiledSelect();
        $builder = $db->table('sgc_estados AS estados');
        $builder->select('estados.estadonom, COALESCE(tipo.cuenta, 0) AS queja');
        $builder->join("($subQueryString) AS tipo", 'tipo.estadoid = estados.estadoid', 'left');
        $builder->orderBy('estados.estadonom');
        $query = $builder->get();
        $resultado = $query->getResult();
        return $resultado;
    }

    // BUSCAMOS LOS CASOS ESTADALES POR TIPO DE ATENCIÓN RECLAMO
    public function ContarCasosReclamoEstadal($desde, $hasta)
    {
        $db = \Config\Database::connect();
        $subQuery = $db->table('sgc_casos AS c')
            ->select('COUNT(c.idcaso) AS cuenta, t.tipo_aten_id, c.estadoid')
            ->join('sgc_tipoatencion_usu AS t', 'c.id_tipo_atencion = t.tipo_aten_id')
            ->where('t.tipo_aten_id', 4)
            ->where('c.borrado', false);
        if ($desde != 'null' && $hasta != 'null') {
            $subQuery->where('c.casofec >=', $desde);
            $subQuery->where('c.casofec <=', $hasta);
        }
        $subQuery->groupBy('t.tipo_aten_id, c.estadoid');
        $subQueryString = $subQuery->getCompiledSelect();
        $builder = $db->table('sgc_estados AS estados');
        $builder->select('estados.estadonom, COALESCE(tipo.cuenta, 0) AS reclamo');
        $builder->join("($subQueryString) AS tipo", 'tipo.estadoid = estados.estadoid', 'left');
        $builder->orderBy('estados.estadonom');
        $query = $builder->get();
        $resultado = $query->getResult();
        return $resultado;
    }

    // BUSCAMOS LOS CASOS ESTADALES POR TIPO DE ATENCIÓN DENUNCIA
    public function ContarCasosDenunciaEstadal($desde, $hasta)
    {
        $db = \Config\Database::connect();
        $subQuery = $db->table('sgc_casos AS c')
            ->select('COUNT(c.idcaso) AS cuenta, t.tipo_aten_id, c.estadoid')
            ->join('sgc_tipoatencion_usu AS t', 'c.id_tipo_atencion = t.tipo_aten_id')
            ->where('t.tipo_aten_id', 5)
            ->where('c.borrado', false);
        if ($desde != 'null' && $hasta != 'null') {
            $subQuery->where('c.casofec >=', $desde);
            $subQuery->where('c.casofec <=', $hasta);
        }
        $subQuery->groupBy('t.tipo_aten_id, c.estadoid');
        $subQueryString = $subQuery->getCompiledSelect();
        $builder = $db->table('sgc_estados AS estados');
        $builder->select('estados.estadonom, COALESCE(tipo.cuenta, 0) AS denuncia');
        $builder->join("($subQueryString) AS tipo", 'tipo.estadoid = estados.estadoid', 'left');
        $builder->orderBy('estados.estadonom');
        $query = $builder->get();
        $resultado = $query->getResult();
        return $resultado;
    }
    // BUSCAMOS LOS CASOS ESTADALES POR TIPO DE ATENCIÓN PETICIÓN
    public function ContarCasosPeticionEstadal($desde, $hasta)
    {
        $db = \Config\Database::connect();
        $subQuery = $db->table('sgc_casos AS c')
            ->select('COUNT(c.idcaso) AS cuenta, t.tipo_aten_id, c.estadoid')
            ->join('sgc_tipoatencion_usu AS t', 'c.id_tipo_atencion = t.tipo_aten_id')
            ->where('t.tipo_aten_id', 6)
            ->where('c.borrado', false);
        if ($desde != 'null' && $hasta != 'null') {
            $subQuery->where('c.casofec >=', $desde);
            $subQuery->where('c.casofec <=', $hasta);
        }
        $subQuery->groupBy('t.tipo_aten_id, c.estadoid');
        $subQueryString = $subQuery->getCompiledSelect();
        $builder = $db->table('sgc_estados AS estados');
        $builder->select('estados.estadonom, COALESCE(tipo.cuenta, 0) AS peticion');
        $builder->join("($subQueryString) AS tipo", 'tipo.estadoid = estados.estadoid', 'left');
        $builder->orderBy('estados.estadonom');
        $query = $builder->get();
        $resultado = $query->getResult();
        return $resultado;
    }

    // BUSCAMOS LOS CASOS ESTADALES POR TIPO DE ATENCIÓN TALLERES
    public function ContarCasosTalleresEstadal($desde, $hasta)
    {
        $db = \Config\Database::connect();
        $subQuery = $db->table('sgc_casos AS c')
            ->select('COUNT(c.idcaso) AS cuenta, t.tipo_aten_id, c.estadoid')
            ->join('sgc_tipoatencion_usu AS t', 'c.id_tipo_atencion = t.tipo_aten_id')
            ->where('t.tipo_aten_id', 7)
            ->where('c.borrado', false);
        if ($desde != 'null' && $hasta != 'null') {
            $subQuery->where('c.casofec >=', $desde);
            $subQuery->where('c.casofec <=', $hasta);
        }
        $subQuery->groupBy('t.tipo_aten_id, c.estadoid');
        $subQueryString = $subQuery->getCompiledSelect();
        $builder = $db->table('sgc_estados AS estados');
        $builder->select('estados.estadonom, COALESCE(tipo.cuenta, 0) AS talleres');
        $builder->join("($subQueryString) AS tipo", 'tipo.estadoid = estados.estadoid', 'left');
        $builder->orderBy('estados.estadonom');
        $query = $builder->get();
        $resultado = $query->getResult();
        return $resultado;
    }




        // BUSCAMOS LOS CASOS CERRADOS
        public function ContarCasosCerrados($desde, $hasta, $id_estado = null)
        {
            $db = \Config\Database::connect();
            $builder = $db->table('sgc_casos AS c');
            $builder->select('COUNT(idest) AS count, idest');
            $builder->where('c.idest', '2');
            if ($desde != 'null' && $hasta != 'null') {
                $builder->where('c.casofec >=', $desde);
                $builder->where('c.casofec <=', $hasta);
            }

            if ($id_estado != 'null' && $id_estado != null) {
                $builder->where('c.estadoid', $id_estado);
            }
            $builder->where('c.borrado', false);
            $builder->groupBy('idest');
            $query = $builder->get();
            $resultado = $query->getResult();
            return $resultado;
        }


        // BUSCAMOS LOS CASOS CREADOS PARA EL REPORTE DE PORTAL WEB
        public function ContarCasos($desde, $hasta)
        {
            $db = \Config\Database::connect();
            $builder = $db->table('sgc_casos AS c');
            $builder->select('COUNT(c.idcaso) AS total_idcaso, c.casofec');
            if ($desde != 'null' && $hasta != 'null') {
                $builder->where('c.casofec >=', $desde);
                $builder->where('c.casofec <=', $hasta);
            }
            $builder->where('c.borrado', false);
            $builder->groupBy('c.casofec');
            $query = $builder->get();
            $resultado = $query->getResult();
            return $resultado;
        }

     // BUSCAMOS LOS CASOS CERRADOS
    public function ContarCasos_Portal_Web($desde, $hasta)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('sgc_casos AS c');
        $builder->select("TO_CHAR(c.casofec, 'Day') AS dia_semana_completo, c.casofec AS fecha, COUNT(DISTINCT c.idcaso) AS casos_creados");
        $builder->join('sta_usuarios_visitas AS v', 'c.casofec = v.fecha', 'left');
        $builder->where('c.casofec >=', $desde);
        $builder->where('c.casofec <=', $hasta);
        $builder->where('v.idrrss', '3');
        $builder->where('c.borrado', 'false');
        $builder->groupBy('c.casofec, TO_CHAR(c.casofec, \'Day\')');
        $builder->orderBy('c.casofec', 'ASC');
        $query = $builder->get();
        $resultado = $query->getResult();
        return $resultado;
    }

    //Metodo para agregar  el nombre de los cocumentos de asosciados a los casos
    public function agregar_docu_casos(array $documentos_casos)
    {
        $db = \Config\Database::connect();
        $builder = $this->dbconn('sgc_documentos_casos');
        $query = $builder->insert($documentos_casos);
        return $query;
    }

    //Metodo que busca el correo del usuario en funcion del caso Y la descripcion del caso 
    public function buscar_correo($caseid)
	{
        $db = \Config\Database::connect();
        $caseid = trim(urldecode($caseid));
		$builder = $this->dbconn('public.sgc_casos as c');
		$builder->select(
			"c.correo,c.casonom,c.casoape ,c.casodesc"
		);
		$builder->where(['c.idcaso' => $caseid]);
		$query = $builder->get();
        //echo $db->getLastQuery(); 
		return $query;
	}

    // //Metodo que busca el correo del usuario en funcion del caso Y la descripcion del caso 
    // public function buscar_token($token)
	// {

    //     $db      = \Config\Database::connect();
    //     $strQuery = " SELECT t.id_usuario FROM  sgc_usuario_token as t   ";
    //     $strQuery .= " where t.token='$token'";
    //     $query = $db->query($strQuery);
    //     $resultado = $query->getResult();
        
    //     return $resultado;
	// }
    // Método que busca el correo del usuario en función del caso y la descripción del caso
    public function buscar_token($token)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('sgc_usuario_token AS t');
        $builder->select('t.id_usuario');
        $builder->where('t.token', $token);
        $query = $builder->get();
        $resultado = $query->getResult();
        return $resultado;
    }


    //Metodo que busca el correo del usuario en funcion del caso Y la descripcion del caso 
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


        // Método para obtener todas las atenciones de un caso
        public function reporte_atencion($desde = null, $hasta = null, $tipo_pi = null, $tipo_atencion_usu = null, $sexo = null, $via_atencion = null, $direcciones_caso = null, $tipo_beneficiario = 0, $atencion_cuidadano = 0, $estatus = 0)
        {
            $db = \Config\Database::connect();

            // Construimos la consulta
            $builder = $db->table('sgc_seguimiento_caso AS sc');
            $builder->select("c.idcaso, CONCAT(c.caso_nacionalidad, c.casoced) AS cedula, CONCAT(c.casonom, ' ', c.casoape) AS nombre, 
                            c.casotel, c.casodesc, c.estnom, sc.idestllam, sc.segcoment, 
                            CASE WHEN sexo = '1' THEN 'M' ELSE 'F' END AS sexo, 
                            TO_CHAR(sc.segfec, 'dd/mm/yyyy') AS fecha_seguimiento, sc.segfec AS fecha_seg_normal, 
                            CONCAT(usu.usuopnom, ' ', usu.usuopape) AS nombre_usuario, 
                            CASE WHEN c.tipo_beneficiario = '1' THEN 'Usuario' ELSE 'Emprendedor' END AS tipo_beneficiario");
            // Realizamos los JOIN necesarios
            $builder->join('vista_casos_atendidos AS c', 'sc.idcaso = c.idcaso');
            $builder->join('sgc_usuario_operador AS usu', 'sc.idusuopr = usu.idusuopr');
            // Agregamos condiciones
            $builder->where('sc.borrado', false);
            // Ordenamos por idcaso en orden descendente
            $builder->orderBy('c.idcaso', 'DESC');
            // Ejecutamos la consulta
            $query = $builder->get();
            $resultado = $query->getResult();
            return $resultado; 
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
            $builder->where('c.idcaso IS NOT NULL'); 
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
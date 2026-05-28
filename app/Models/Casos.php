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
        $builder->select('a.caso_org_id,a.edad, to_char(a.fecha_nacimiento, \'dd/mm/yyyy\') as fecha_nacimiento, a.fecha_nacimiento as fecha_nacimiento_normal');
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
        $builder->select('t_antusu.tipo_aten_nombre, t_antusu.act_pro_int,t_antusu.organismo_pp ');
        $builder->join('public.sgc_estatus b', 'b.idest = a.idest');
        $builder->join('public.sgc_usuario_operador u_ope', 'a.idusuopr = u_ope.idusuopr');
        $builder->join('public.sgc_tipoatencion_usu as t_antusu', 'a.id_tipo_atencion = t_antusu.tipo_aten_id');
        $builder->join('public.sgc_tipo_prop_caso as tpc', 'a.idcaso = tpc.idcaso', 'left');
        $builder->join('public.sgc_tipo_prop_intelec as tpinte', 'tpc.idtippropint = tpinte.tipo_prop_id', 'left');
        $builder->join('public.sgc_registro_cgr cgr', 'a.idcaso = cgr.id_caso', 'left');
        $builder->join('public.sgc_tipoatenciondetalle as d', 'a.tipo_atend_id = d.tipo_atend_id', 'left');
        $builder->where('a.borrado', false);
        $builder->orderBy('a.idcaso', 'DESC');
        $query = $builder->get();
        return $query->getResult();
    }
    
public function obtenerCasosServerSide($start, $length, $search, $order_column, $order_direction)
{
    $db = \Config\Database::connect();
    
    // --- 1. CONTEO TOTAL DE REGISTROS (recordsTotal) ---
    // CORRECCIÓN: Usar COUNT(DISTINCT) para consistencia con getReporteData y getReporteOperadorData
    $recordsTotalQuery = $db->query("SELECT COUNT(DISTINCT a.idcaso) as total FROM sgc_casos a WHERE a.borrado = FALSE");
    $recordsTotalRow = $recordsTotalQuery->getRow();
    $recordsTotal = $recordsTotalRow ? $recordsTotalRow->total : 0;
    
    // --- 2. INICIALIZACIÓN DEL BUILDER PARA FILTRO Y PÁGINA ---
    $builder = $db->table('sgc_casos as a');
    $builder->distinct();
    $this->buildBaseQuery($builder);

    // --- 3. APLICACIÓN DEL FILTRO DE BÚSQUEDA (Insensible a mayúsculas/minúsculas) ---
    if (!empty($search)) {
        $searchLower = strtolower($search);
        $searchEscaped = $db->escapeLikeString($searchLower);
        $searchPattern = '%' . $searchEscaped . '%';
        
        // Búsqueda consistente con getReporteData y getReporteOperadorData
        // Incluye: tipo_beneficiario_nombre, via_atencion_nombre (red_s_nom)
        $whereClause = "
            CAST(a.idcaso AS TEXT) LIKE '{$searchPattern}' OR
            COALESCE(TRIM(a.casoced), '') LIKE '{$searchPattern}' OR
            COALESCE(LOWER(a.casonom), '') LIKE '{$searchPattern}' OR
            COALESCE(LOWER(a.casoape), '') LIKE '{$searchPattern}' OR
            COALESCE(LOWER(b.estnom), '') LIKE '{$searchPattern}' OR
            COALESCE(LOWER(t_antusu.tipo_aten_nombre), '') LIKE '{$searchPattern}' OR
            COALESCE(LOWER(tpinte.tipo_prop_nombre), '') LIKE '{$searchPattern}' OR
            COALESCE(LOWER(t_bene.tipo_beneficiario_nombre), '') LIKE '{$searchPattern}' OR
            COALESCE(LOWER(CONCAT(u_ope.usuopnom, ' ', u_ope.usuopape)), '') LIKE '{$searchPattern}' OR
            COALESCE(LOWER(rs.red_s_nom), '') LIKE '{$searchPattern}'
        ";
        
        $builder->where("({$whereClause})", NULL, FALSE);
    }
    
    // --- 4. CONTEO DE REGISTROS FILTRADOS ---
    // CORRECCIÓN: Usar COUNT(DISTINCT a.idcaso) para contar correctamente sin duplicados por JOINs
    // Los INNER y LEFT JOINs pueden crear filas duplicadas, por lo que necesitamos COUNT DISTINCT
    
    // Construir la consulta SQL base para el conteo (incluyendo todos los JOINs para consistencia)
    $sql = "SELECT COUNT(DISTINCT a.idcaso) as total 
            FROM sgc_casos a 
            INNER JOIN public.sgc_estatus b ON b.idest = a.idest
            INNER JOIN public.sgc_usuario_operador u_ope ON a.idusuopr = u_ope.idusuopr
            INNER JOIN public.sgc_tipoatencion_usu t_antusu ON a.id_tipo_atencion = t_antusu.tipo_aten_id
            LEFT JOIN public.sgc_tipo_prop_caso tpc ON a.idcaso = tpc.idcaso
            LEFT JOIN public.sgc_tipo_prop_intelec tpinte ON tpc.idtippropint = tpinte.tipo_prop_id
            LEFT JOIN public.sgc_registro_cgr cgr ON a.idcaso = cgr.id_caso
            LEFT JOIN public.sgc_tipoatenciondetalle d ON a.tipo_atend_id = d.tipo_atend_id
            LEFT JOIN public.sgc_casos_denuncias denu ON a.idcaso = denu.denu_id_caso
            LEFT JOIN public.sgc_tipo_beneficiarios t_bene ON a.tipo_beneficiario = t_bene.tipo_beneficiario_id
            LEFT JOIN public.sgc_casos_remitidos caso_r ON a.idcaso = caso_r.casos_id
            LEFT JOIN public.sgc_direcciones_administrativas ubi ON caso_r.direccion_id = ubi.id
            LEFT JOIN public.sgc_paises pais ON a.pais = pais.paisid
            LEFT JOIN public.sgc_estados est ON a.estadoid = est.estadoid
            LEFT JOIN public.sgc_municipio mun ON a.municipioid = mun.municipioid
            LEFT JOIN public.sgc_parroquias par ON a.parroquiaid = par.parroquiaid
            LEFT JOIN public.sgc_red_social rs ON a.idrrss = rs.red_s_id
            LEFT JOIN public.sgc_org_pod_popular org ON a.caso_org_id = org.org_id
            WHERE a.borrado = FALSE AND (caso_r.vigencia = TRUE OR caso_r.vigencia IS NULL)";
    
    // Agregar condiciones de búsqueda si existen - Lógica consistente con getReporteData
    if (!empty($search)) {
        $searchLower = strtolower($search);
        $searchEscaped = $db->escapeLikeString($searchLower);
        $searchPattern = '%' . $searchEscaped . '%';
        
        // Búsqueda consistente con getReporteData y getReporteOperadorData
        $whereClause = "
            AND (CAST(a.idcaso AS TEXT) LIKE '{$searchPattern}' OR
            COALESCE(TRIM(a.casoced), '') LIKE '{$searchPattern}' OR
            COALESCE(LOWER(a.casonom), '') LIKE '{$searchPattern}' OR
            COALESCE(LOWER(a.casoape), '') LIKE '{$searchPattern}' OR
            COALESCE(LOWER(b.estnom), '') LIKE '{$searchPattern}' OR
            COALESCE(LOWER(t_antusu.tipo_aten_nombre), '') LIKE '{$searchPattern}' OR
            COALESCE(LOWER(tpinte.tipo_prop_nombre), '') LIKE '{$searchPattern}' OR
            COALESCE(LOWER(t_bene.tipo_beneficiario_nombre), '') LIKE '{$searchPattern}' OR
            COALESCE(LOWER(CONCAT(u_ope.usuopnom, ' ', u_ope.usuopape)), '') LIKE '{$searchPattern}' OR
            COALESCE(LOWER(rs.red_s_nom), '') LIKE '{$searchPattern}')";
        $sql .= $whereClause;
    }
    
    $result = $db->query($sql);
    $row = $result->getRow();
    $recordsFiltered = $row ? $row->total : 0;
    
    // --- 5. ORDENACIÓN Y PAGINACIÓN ---
    // CORRECCIÓN: Validar columnas permitidas para evitar SQL injection
    // user_name es un alias de CONCAT, no se puede usar directamente en ORDER BY
    $allowed_columns = [
        'a.idcaso', 'a.casoced', "CONCAT(a.casonom, ' ', a.casoape)", 'a.casotel',
        'tpinte.tipo_prop_nombre', 't_antusu.tipo_aten_nombre', 'a.casofec', 'b.estnom',
        "CONCAT(u_ope.usuopnom, ' ', u_ope.usuopape)", 'a.idcaso'
    ];
    
    // Si la columna no está permitida, usar a.idcaso por defecto
    if (in_array($order_column, $allowed_columns)) {
        $builder->orderBy($order_column, $order_direction);
    } else {
        $builder->orderBy('a.idcaso', $order_direction);
    }
    
    // ============================================================
    // CORRECCIÓN: Manejar el caso cuando length = -1 (opción "Todos")
    // Si length es -1, significa que el usuario quiere "Todos" los registros.
    // Si hay búsqueda activa, usamos un límite alto para capturar todos los filtrados.
    // Si no hay búsqueda, usamos un límite de seguridad para evitar sobrecarga.
    // ============================================================
    if ($length == -1) {
        if (!empty($search)) {
            // Si hay búsqueda, usamos un límite alto para capturar todos los filtrados
            $length = 10000;
        } else {
            // Si no hay búsqueda, usamos un límite de seguridad
            $length = 500;
        }
    }
    
    $builder->limit($length, $start);
    
    // Obtener los datos paginados
    $query = $builder->get();
    $data = $query->getResult();
    
    return [
        'recordsTotal' => $recordsTotal,
        'recordsFiltered' => $recordsFiltered,
        'data' => $data
    ];
}
    
public function obtenerCasos_filtrados_por_usuario_serverSide($idusur, $start, $length, $search, $order_column, $order_direction)
{
    $db = \Config\Database::connect();
    
    // --- 1. INICIALIZACIÓN DEL BUILDER PARA CONTEOS (con filtro de usuario) ---
    // CORRECCIÓN: Usar COUNT(DISTINCT) para consistencia
    // CORRECCIÓN: Agregar filtro de vigencia para consistencia con otros reportes
    $recordsTotalQuery = $db->query("SELECT COUNT(DISTINCT a.idcaso) as total FROM sgc_casos a 
        LEFT JOIN public.sgc_casos_remitidos caso_r ON a.idcaso = caso_r.casos_id 
        WHERE a.borrado = FALSE AND a.idusuopr = " . $db->escape($idusur) . " AND (caso_r.vigencia = TRUE OR caso_r.vigencia IS NULL)");
    $recordsTotalRow = $recordsTotalQuery->getRow();
    $recordsTotal = $recordsTotalRow ? $recordsTotalRow->total : 0;

    // --- 2. INICIALIZACIÓN DEL BUILDER PARA FILTRO Y PÁGINA ---
    $builder = $db->table('sgc_casos as a');
    $builder->distinct();
    $this->buildBaseQuery($builder);
    $builder->where('a.idusuopr', $idusur);

    // --- 3. APLICACIÓN DEL FILTRO DE BÚSQUEDA ---
    if (!empty($search)) {
        $searchLower = strtolower($search);
        $searchEscaped = $db->escapeLikeString($searchLower);
        $searchPattern = '%' . $searchEscaped . '%';
        
        // Búsqueda consistente con getReporteData y getReporteOperadorData
        // Incluye: tipo_beneficiario_nombre, via_atencion_nombre (red_s_nom)
        $whereClause = "
            CAST(a.idcaso AS TEXT) LIKE '{$searchPattern}' OR
            COALESCE(TRIM(a.casoced), '') LIKE '{$searchPattern}' OR
            COALESCE(LOWER(a.casonom), '') LIKE '{$searchPattern}' OR
            COALESCE(LOWER(a.casoape), '') LIKE '{$searchPattern}' OR
            COALESCE(LOWER(b.estnom), '') LIKE '{$searchPattern}' OR
            COALESCE(LOWER(t_antusu.tipo_aten_nombre), '') LIKE '{$searchPattern}' OR
            COALESCE(LOWER(tpinte.tipo_prop_nombre), '') LIKE '{$searchPattern}' OR
            COALESCE(LOWER(t_bene.tipo_beneficiario_nombre), '') LIKE '{$searchPattern}' OR
            COALESCE(LOWER(CONCAT(u_ope.usuopnom, ' ', u_ope.usuopape)), '') LIKE '{$searchPattern}' OR
            COALESCE(LOWER(rs.red_s_nom), '') LIKE '{$searchPattern}'
        ";
        
        $builder->where("({$whereClause})", NULL, FALSE);
    }
    
    // --- 4. CONTEO DE REGISTROS FILTRADOS ---
    // CORRECCIÓN: Usar COUNT(DISTINCT) para evitar duplicados por JOINs
    $sqlFiltered = "SELECT COUNT(DISTINCT a.idcaso) as total 
            FROM sgc_casos a 
            INNER JOIN public.sgc_estatus b ON b.idest = a.idest
            INNER JOIN public.sgc_usuario_operador u_ope ON a.idusuopr = u_ope.idusuopr
            INNER JOIN public.sgc_tipoatencion_usu t_antusu ON a.id_tipo_atencion = t_antusu.tipo_aten_id
            LEFT JOIN public.sgc_tipo_prop_caso tpc ON a.idcaso = tpc.idcaso
            LEFT JOIN public.sgc_tipo_prop_intelec tpinte ON tpc.idtippropint = tpinte.tipo_prop_id
            LEFT JOIN public.sgc_registro_cgr cgr ON a.idcaso = cgr.id_caso
            LEFT JOIN public.sgc_tipoatenciondetalle d ON a.tipo_atend_id = d.tipo_atend_id
            LEFT JOIN public.sgc_casos_denuncias denu ON a.idcaso = denu.denu_id_caso
            LEFT JOIN public.sgc_tipo_beneficiarios t_bene ON a.tipo_beneficiario = t_bene.tipo_beneficiario_id
            LEFT JOIN public.sgc_casos_remitidos caso_r ON a.idcaso = caso_r.casos_id
            LEFT JOIN public.sgc_direcciones_administrativas ubi ON caso_r.direccion_id = ubi.id
            LEFT JOIN public.sgc_paises pais ON a.pais = pais.paisid
            LEFT JOIN public.sgc_estados est ON a.estadoid = est.estadoid
            LEFT JOIN public.sgc_municipio mun ON a.municipioid = mun.municipioid
            LEFT JOIN public.sgc_parroquias par ON a.parroquiaid = par.parroquiaid
            LEFT JOIN public.sgc_red_social rs ON a.idrrss = rs.red_s_id
            LEFT JOIN public.sgc_org_pod_popular org ON a.caso_org_id = org.org_id
            WHERE a.borrado = FALSE AND a.idusuopr = " . $db->escape($idusur) . " AND (caso_r.vigencia = TRUE OR caso_r.vigencia IS NULL)";
    
    // Agregar filtro de búsqueda si existe - Lógica consistente con getReporteData
    if (!empty($search)) {
        $searchLower = strtolower($search);
        $searchEscaped = $db->escapeLikeString($searchLower);
        $searchPattern = '%' . $searchEscaped . '%';
        
        // Búsqueda consistente con getReporteData y getReporteOperadorData
        $whereClauseFiltered = "
            AND (CAST(a.idcaso AS TEXT) LIKE '{$searchPattern}' OR
            COALESCE(TRIM(a.casoced), '') LIKE '{$searchPattern}' OR
            COALESCE(LOWER(a.casonom), '') LIKE '{$searchPattern}' OR
            COALESCE(LOWER(a.casoape), '') LIKE '{$searchPattern}' OR
            COALESCE(LOWER(b.estnom), '') LIKE '{$searchPattern}' OR
            COALESCE(LOWER(t_antusu.tipo_aten_nombre), '') LIKE '{$searchPattern}' OR
            COALESCE(LOWER(tpinte.tipo_prop_nombre), '') LIKE '{$searchPattern}' OR
            COALESCE(LOWER(t_bene.tipo_beneficiario_nombre), '') LIKE '{$searchPattern}' OR
            COALESCE(LOWER(CONCAT(u_ope.usuopnom, ' ', u_ope.usuopape)), '') LIKE '{$searchPattern}' OR
            COALESCE(LOWER(rs.red_s_nom), '') LIKE '{$searchPattern}')";
        $sqlFiltered .= $whereClauseFiltered;
    }
    
    $resultFiltered = $db->query($sqlFiltered);
    $rowFiltered = $resultFiltered->getRow();
    $recordsFiltered = $rowFiltered ? $rowFiltered->total : 0;
    
    // --- 5. ORDENACIÓN Y PAGINACIÓN ---
    // CORRECCIÓN: Validar columnas permitidas
    $allowed_columns = [
        'a.idcaso', 'a.casoced', "CONCAT(a.casonom, ' ', a.casoape)", 'a.casotel',
        'tpinte.tipo_prop_nombre', 't_antusu.tipo_aten_nombre', 'a.casofec', 'b.estnom',
        "CONCAT(u_ope.usuopnom, ' ', u_ope.usuopape)", 'a.idcaso'
    ];
    
    if (in_array($order_column, $allowed_columns)) {
        $builder->orderBy($order_column, $order_direction);
    } else {
        $builder->orderBy('a.idcaso', $order_direction);
    }
    
    // ============================================================
    // CORRECCIÓN: Manejar el caso cuando length = -1 (opción "Todos")
    // Si length es -1, significa que el usuario quiere "Todos" los registros.
    // Si hay búsqueda activa, usamos un límite alto para capturar todos los filtrados.
    // Si no hay búsqueda, usamos un límite de seguridad para evitar sobrecarga.
    // ============================================================
    if ($length == -1) {
        if (!empty($search)) {
            // Si hay búsqueda, usamos un límite alto para capturar todos los filtrados
            $length = 10000;
        } else {
            // Si no hay búsqueda, usamos un límite de seguridad
            $length = 500;
        }
    }
    
    $builder->limit($length, $start);
    
    $query = $builder->get();
    $data = $query->getResult();
    
    return [
        'recordsTotal' => $recordsTotal,
        'recordsFiltered' => $recordsFiltered,
        'data' => $data
    ];
}
    
private function buildBaseQuery($builder)
{
    // CORRECCIÓN: Usar esquema 'public.' en TODOS los JOINs para consistencia
    $builder->select('d.tipo_atend_borrado, a.idcaso, a.tipo_beneficiario,a.tipo_atend_id, a.casotel, TRIM(a.casoced) AS casoced, a.casonom, a.casoape, a.casodesc');
    $builder->select('a.pais,a.caso_nacionalidad, a.idrrss, a.ofiid, a.estadoid, a.id_tipo_atencion');
    $builder->select('a.caso_org_id,a.edad, to_char(a.fecha_nacimiento, \'dd/mm/yyyy\') as fecha_nacimiento, a.fecha_nacimiento as fecha_nacimiento_normal');
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
    $builder->select('t_antusu.tipo_aten_nombre, t_antusu.act_pro_int,t_antusu.organismo_pp ');
    
    // CORRECCIÓN: Agregar 'public.' a TODOS los JOINs y corregir JOIN de denuncias
    $builder->join('public.sgc_estatus b', 'b.idest = a.idest');
    $builder->join('public.sgc_usuario_operador u_ope', 'a.idusuopr = u_ope.idusuopr');
    $builder->join('public.sgc_tipoatencion_usu as t_antusu', 'a.id_tipo_atencion = t_antusu.tipo_aten_id');
    $builder->join('public.sgc_tipo_prop_caso as tpc', 'a.idcaso = tpc.idcaso', 'left');
    $builder->join('public.sgc_tipo_prop_intelec as tpinte', 'tpc.idtippropint = tpinte.tipo_prop_id', 'left');
    $builder->join('public.sgc_registro_cgr cgr', 'a.idcaso = cgr.id_caso', 'left');
    $builder->join('public.sgc_tipoatenciondetalle as d', 'a.tipo_atend_id = d.tipo_atend_id', 'left');
    $builder->join('public.sgc_casos_denuncias denu', 'a.idcaso = denu.denu_id_caso', 'left');
    
    // CORRECCIÓN: Agregar JOINs faltantes para consistencia con getReporteData y getReporteOperadorData
    $builder->join('public.sgc_tipo_beneficiarios as t_bene', 'a.tipo_beneficiario = t_bene.tipo_beneficiario_id', 'left');
    $builder->join('public.sgc_casos_remitidos as caso_r', 'a.idcaso = caso_r.casos_id', 'left');
    $builder->join('public.sgc_direcciones_administrativas as ubi', 'caso_r.direccion_id = ubi.id', 'left');
    $builder->join('public.sgc_paises as pais', 'a.pais = pais.paisid', 'left');
    $builder->join('public.sgc_estados as est', 'a.estadoid = est.estadoid', 'left');
    $builder->join('public.sgc_municipio as mun', 'a.municipioid = mun.municipioid', 'left');
    $builder->join('public.sgc_parroquias as par', 'a.parroquiaid = par.parroquiaid', 'left');
    $builder->join('public.sgc_red_social as rs', 'a.idrrss = rs.red_s_id', 'left');
    $builder->join('public.sgc_org_pod_popular as org', 'a.caso_org_id = org.org_id', 'left');
    
    // CORRECCIÓN: Agregar filtro de vigencia para consistencia con getReporteData y getReporteOperadorData
    $builder->groupStart();
    $builder->where('caso_r.vigencia', true);
    $builder->orWhere('caso_r.vigencia IS NULL');
    $builder->groupEnd();
    
    $builder->where('a.borrado', false);
}

    //Metodo para obtener todos los casos por usuario
    public function obtenerCasos_filtrados_por_usuario($idusur)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('sgc_casos as a');
        $builder->distinct();
        $builder->select('a.idcaso, a.tipo_beneficiario, a.tipo_atend_id, a.casotel, TRIM(a.casoced) AS casoced, a.casonom, a.casoape, a.casodesc');
        $builder->select('a.caso_org_id,a.caso_nacionalidad, a.idrrss, a.ofiid, a.estadoid, a.id_tipo_atencion');
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
        $builder->select('t_antusu.tipo_aten_nombre, t_antusu.act_pro_int,t_antusu.organismo_pp ');
        
        // CORRECCIÓN: Usar esquema public.
        $builder->join('public.sgc_estatus b', 'b.idest = a.idest');
        $builder->join('public.sgc_usuario_operador u_ope', 'a.idusuopr = u_ope.idusuopr');
        $builder->join('public.sgc_tipoatencion_usu as t_antusu', 'a.id_tipo_atencion = t_antusu.tipo_aten_id');
        $builder->join('public.sgc_tipo_prop_caso as tpc', 'a.idcaso = tpc.idcaso', 'left');
        $builder->join('public.sgc_tipo_prop_intelec as tpinte', 'tpc.idtippropint = tpinte.tipo_prop_id', 'left');
        $builder->join('public.sgc_registro_cgr cgr', 'a.idcaso = cgr.id_caso', 'left');
        $builder->join('public.sgc_casos_denuncias denu', 'a.idcaso = denu.denu_id_caso', 'left');
        $builder->where('a.borrado', false);
        $builder->where('a.idusuopr', $idusur);
        $builder->orderBy('a.idcaso', 'DESC');
        $query = $builder->get();
        return $query->getResult();
    }
public function listar_Casos_Remitidos($id_direccion, $estatus = null)
{
    $db = \Config\Database::connect();
    $builder = $db->table('sgc_casos_remitidos as cr');
    
    // Selects
    $builder->select('cr.casos_id, CONCAT(a.caso_nacionalidad, a.casoced) AS cedula, a.casonom, a.casoape, CONCAT(a.casonom, \' \', a.casoape) AS beneficiario');
    $builder->select('a.fecha_nacimiento, a.idcaso, a.casotel, a.edad, a.tipo_beneficiario, tpinte.tipo_prop_nombre, t_antusu.tipo_aten_nombre, to_char(a.casofec, \'dd/mm/yyyy\') as casofec');
    $builder->select('a.municipioid, a.pais as paisid, a.parroquiaid, a.direccion, a.correo, a.ente_adscrito_id, TRIM(a.casoced) AS casoced');
    $builder->select('cr.direccion_id, dire.correo, a.casodesc, a.caso_nacionalidad, a.idrrss, a.ofiid, a.estadoid');
    $builder->select('a.id_tipo_atencion, a.municipioid, a.parroquiaid, a.direccion, a.profesion, a.correo, a.ente_adscrito_id');
    $builder->select('cgr.competencia_cgr, cgr.asume_cgr, denu.denu_afecta_persona, denu.denu_afecta_comunidad, denu.denu_afecta_terceros');
    $builder->select('denu.denu_involucrados, denu.denu_fecha_hechos, denu.denu_instancia_popular, denu.denu_rif_instancia');
    $builder->select('denu.denu_ente_financiador, denu.denu_nombre_proyecto, denu.denu_monto_aprovado, CONCAT(a.casonom, \' \', a.casoape) AS nombre');
    $builder->select('CONCAT(u_ope.usuopnom, \' \', u_ope.usuopape) AS user_name, CASE WHEN sexo = \'1\' THEN \'M\' ELSE \'F\' END as sexo');
    $builder->select('a.casofec as casofec_normal, b.estnom, tpinte.tipo_prop_id');
    
    // Joins
    $builder->join('public.sgc_direcciones_administrativas as dire', 'cr.direccion_id = dire.id');
    $builder->join('public.sgc_casos as a', 'cr.casos_id = a.idcaso');
    $builder->join('public.sgc_estatus b', 'b.idest = a.idest');
    $builder->join('public.sgc_usuario_operador u_ope', 'a.idusuopr = u_ope.idusuopr');
    $builder->join('public.sgc_tipoatencion_usu as t_antusu', 'a.id_tipo_atencion = t_antusu.tipo_aten_id');
    $builder->join('public.sgc_tipo_prop_caso as tpc', 'a.idcaso = tpc.idcaso', 'left');
    $builder->join('public.sgc_tipo_prop_intelec as tpinte', 'tpc.idtippropint = tpinte.tipo_prop_id', 'left');
    $builder->join('public.sgc_registro_cgr cgr', 'a.idcaso = cgr.id_caso', 'left');
    $builder->join('public.sgc_casos_denuncias denu', 'a.idcaso = denu.denu_id_caso', 'left');
    
    // Condiciones fijas restrictivas
    $builder->where('cr.direccion_id', $id_direccion); 
    $builder->where('a.borrado', false); 

    // Agrupación del OR para asegurar que la vigencia evalúe correctamente sin romper los WHERE anteriores
    $builder->groupStart()
                ->where('cr.vigencia', true)
                ->orWhere('cr.vigencia IS NULL')
            ->groupEnd();

    // Lógica de filtrado dinámico desde el Select superior de DataTables
    if ($estatus !== null && $estatus !== '0') {
        $builder->where('a.idest', $estatus);
    }
    
    $query = $builder->get();
    return $query->getResult();
}

    //Metodo para obtener toda la informacion del caso para la web 
    public function Informacion_Usuarios($casoced)
    {
        if (!filter_var($casoced, FILTER_VALIDATE_INT)) {
            die("La cédula debe ser un número entero válido.");
        }
        $db = \Config\Database::connect();
        $builder = $db->table('sgc_casos a');
        
        $builder->select([
            'a.tipo_beneficiario', 'a.idcaso', 'a.casotel', 'TRIM(a.casoced) AS casoced',
            'a.casonom', 'a.casoape', 'a.casodesc', 'a.caso_nacionalidad', 'a.idrrss',
            'a.ofiid', 'a.estadoid', 'a.id_tipo_atencion', 'a.municipioid', 'a.parroquiaid',
            'a.direccion', 'a.correo', 'a.ente_adscrito_id',
            "CONCAT(a.caso_nacionalidad, a.casoced) AS cedula",
            'cgr.competencia_cgr', 'cgr.asume_cgr',
            'denu.denu_afecta_persona', 'denu.denu_afecta_comunidad', 'denu.denu_afecta_terceros',
            'denu.denu_involucrados', 'denu.denu_fecha_hechos', 'denu.denu_instancia_popular',
            'denu.denu_rif_instancia', 'denu.denu_ente_financiador', 'denu.denu_nombre_proyecto', 'denu.denu_monto_aprovado',
            "CONCAT(a.casonom, ' ', a.casoape) AS nombre",
            "CONCAT(u_ope.usuopnom, ' ', u_ope.usuopape) AS user_name",
            "CASE WHEN sexo = '1' THEN 'M' ELSE 'F' END AS sexo",
            "TO_CHAR(a.casofec, 'dd/mm/yyyy') AS casofec",
            'a.casofec AS casofec_normal', 'b.estnom',
            'tpinte.tipo_prop_nombre', 'tpinte.tipo_prop_id', 't_antusu.tipo_aten_nombre'
        ]);
        
        // CORRECCIÓN: Usar esquema public.
        $builder->join('public.sgc_estatus b', 'b.idest = a.idest');
        $builder->join('public.sgc_usuario_operador u_ope', 'a.idusuopr = u_ope.idusuopr');
        $builder->join('public.sgc_tipo_prop_caso tpc', 'a.idcaso = tpc.idcaso');
        $builder->join('public.sgc_tipo_prop_intelec tpinte', 'tpc.idtippropint = tpinte.tipo_prop_id');
        $builder->join('public.sgc_tipoatencion_usu t_antusu', 'a.id_tipo_atencion = t_antusu.tipo_aten_id');
        $builder->join('public.sgc_registro_cgr cgr', 'a.idcaso = cgr.id_caso', 'left');
        $builder->join('public.sgc_casos_denuncias denu', 'a.idcaso = denu.denu_id_caso', 'left');
        
        //$builder->where('a.borrado', false);
        $builder->where('a.casoced', $casoced);
        $builder->orderBy('a.idcaso', 'desc');
        $query = $builder->get();
        //echo $db->getLastQuery();
        return $query->getResult();
    }

    public function obtenerCaso_id($id_caso)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('sgc_casos as a');
        $builder->select('a.idusuopr, a.tipo_beneficiario, a.idcaso, a.casotel, TRIM(a.casoced) AS casoced, a.casonom, a.casoape, a.casodesc');
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
        // Agregamos la dirección administrativa del caso (de remitidos o del usuario original)
        $builder->select('COALESCE(cr.direccion_id, u_ope.id_direccion_administrativa) AS id_direccion_administrativa');
        
        // CORRECCIÓN: Usar esquema public.
        $builder->join('public.sgc_estatus b', 'b.idest = a.idest');
        $builder->join('public.sgc_usuario_operador u_ope', 'a.idusuopr = u_ope.idusuopr');
        $builder->join('public.sgc_tipo_prop_caso as tpc', 'a.idcaso = tpc.idcaso');
        $builder->join('public.sgc_tipo_prop_intelec as tpinte', 'tpc.idtippropint = tpinte.tipo_prop_id');
        $builder->join('public.sgc_tipoatencion_usu as t_antusu', 'a.id_tipo_atencion = t_antusu.tipo_aten_id');
        $builder->join('public.sgc_registro_cgr cgr', 'a.idcaso = cgr.id_caso', 'left');
        $builder->join('public.sgc_casos_denuncias denu', 'a.idcaso = denu.denu_id_caso', 'left');
        // JOIN para obtener la dirección de remisión (si existe y está vigente)
        $builder->join('public.sgc_casos_remitidos cr', 'a.idcaso = cr.casos_id AND cr.vigencia = TRUE', 'left', false);
        
        $builder->where('a.borrado', false);
        $builder->where('a.idcaso', $id_caso);
        $query = $builder->get();
        return $query->getRow(); 
    }

    // //Metodo para obtener EL ULTIMO ID INSERTADO
    // public function obtener_utimo_id()
    // {
    //     $builder = $this->dbconn('public.sgc_casos');
    //     $builder->select(" MAX(idcaso) as ultimo_id");
    //     $query = $builder->get();
    //     return $query;
    // }

    public function obtener_ultimos_casos(string $iduser)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('sgc_casos as a');
        $builder->select('a.idcaso, a.casotel, a.casoced');
        $builder->select('CONCAT(a.casonom, \' \', a.casoape) AS nombre');
        $builder->select('CASE WHEN sexo = \'1\' THEN \'M\' ELSE \'F\' END as sexo');
        $builder->select('to_char(a.casofec, \'dd/mm/yyyy\') as casofec, a.casofec as casofec_normal');
        $builder->select('b.estnom, tpinte.tipo_prop_nombre, t_antusu.tipo_aten_nombre');
        
        // CORRECCIÓN: Usar esquema public.
        $builder->join('public.sgc_estatus b', 'b.idest = a.idest');
        $builder->join('public.sgc_usuario_operador c', 'a.idusuopr = c.idusuopr');
        $builder->join('public.sgc_tipo_prop_caso as tpc', 'a.idcaso = tpc.idcaso');
        $builder->join('public.sgc_tipo_prop_intelec as tpinte', 'tpc.idtippropint = tpinte.tipo_prop_id');
        $builder->join('public.sgc_tipoatencion_usu as t_antusu', 'a.id_tipo_atencion = t_antusu.tipo_aten_id');
        
        $builder->where('a.idusuopr', $iduser); 
        $builder->orderBy('a.idcaso', 'DESC');
        $builder->limit(20);
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

    // //Metodo para insertar un nuevo caso en la BD
    // public function insertarNuevoCaso(array $datos)
    // {
    //     $builder = $this->dbconn('sgc_casos');
    //     date_default_timezone_set('America/Caracas');
    //     $hora = date("H:i:s A");
    //     $datos['caso_hora'] = $hora;
    //     $query = $builder->insert($datos);
    //     return $query;
    // }
    //Metodo para   actualizar  us Caso en la BD



  public function insertarNuevoCaso(array $datos)
{
    // 1. Usamos el builder directamente desde la conexión del modelo
    $builder = $this->db->table('sgc_casos'); 
    
    date_default_timezone_set('America/Caracas');
    $datos['caso_hora'] = date("H:i:s A");

    // 2. Ejecutamos la inserción en la conexión compartida
    if ($builder->insert($datos)) {
        // 3. Retornamos el ID generado en este hilo/túnel específico
        return $this->db->insertID(); 
    }
    
    return false;
}

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
$builder->select('deta.tipo_atend_nombre');
         $builder->select('ts.ter_nombre AS nombre_apo_sol');
         $builder->select('tc.ter_nombre AS nombre_apo_contra');
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
$builder->join('sgc_tipoatenciondetalle as deta', 'a.tipo_atend_id = deta.tipo_atend_id', 'left');
         $builder->join('public.sgc_mediacion m', 'a.idcaso = m.med_caso_id', 'left');
         $builder->join('public.sgc_terceros ts', 'm.med_apo_sol_id = ts.ter_id', 'left');
         $builder->join('public.sgc_terceros tc', 'm.med_apo_contra_id = tc.ter_id', 'left');
         $builder->where('a.idcaso', $idcaso); 
         $query = $builder->get();
         $resultado = $query->getRow();
         return $resultado ? [$resultado] : []; 
     }
 
// Metodo para obtener todos los casos para el reporte consolidado    
    public function getReporteData($params)
    {
        $db = \Config\Database::connect();

        // --- Paso 1: Sanitización Ultra-Estricta de Parámetros ---
        foreach ($params as $key => $value) {
            if ($key === 'search' && is_array($value) && isset($value['value'])) {
                $value = $value['value'];
                $params[$key] = $value;
            }

            if (is_string($value)) {
                $value = trim($value);
                $valueLower = strtolower($value);
                
                if (
                    $value === '' || 
                    $value === 'null' || 
                    $value === 'undefined' ||
                    $value === '0' ||
                    $value === '-1' ||
                    $valueLower === 'seleccione' || 
                    $valueLower === 'todos' ||
                    strpos($valueLower, 'seleccione') !== false || 
                    ($key === 'id_pais' && $value === '1') ||      
                    ($key === 'id_estado' && $value === '26') ||
                    ($key === 'id_municipio' && $value === '336') ||
                    ($key === 'id_parroquia' && $value === '1135')
                ) {
                    $params[$key] = null;
                } else {
                    $params[$key] = $value;
                }
            } 
            elseif (is_numeric($value)) {
                if (
                    $value === 0 || 
                    $value === -1 ||
                    ($key === 'id_pais' && $value == 1) || 
                    ($key === 'id_estado' && $value == 26) ||
                    ($key === 'id_municipio' && $value == 336) ||
                    ($key === 'id_parroquia' && $value == 1135)
                ) {
                    $params[$key] = null;
                }
            } 
            else {
                if (empty($value)) {
                    $params[$key] = null;
                }
            }
        }

        // --- Paso 2: Construir la consulta base (Estructura Base) ---
        $builder = $db->table('sgc_casos as a');
        $builder->distinct();

        // Joins obligatorios para la estructura base del universo de datos
        $builder->join('sgc_estatus b', 'b.idest = a.idest', 'inner');
        $builder->join('sgc_usuario_operador u_ope', 'a.idusuopr = u_ope.idusuopr', 'inner');
        $builder->join('sgc_tipo_prop_caso as tpc', 'a.idcaso = tpc.idcaso', 'left');
        $builder->join('sgc_tipo_beneficiarios as t_bene', 'a.tipo_beneficiario = t_bene.tipo_beneficiario_id', 'left');
        $builder->join('sgc_tipoatencion_usu as t_antusu', 'a.id_tipo_atencion = t_antusu.tipo_aten_id', 'left');
        $builder->join('sgc_tipo_prop_intelec as tpinte', 'tpc.idtippropint = tpinte.tipo_prop_id', 'left');
        $builder->join('sgc_casos_remitidos as caso_r', 'a.idcaso = caso_r.casos_id', 'left');
        $builder->join('sgc_direcciones_administrativas as ubi', 'caso_r.direccion_id = ubi.id', 'left');
        
        // JOIN EXTRA: Para traer el nombre de la dirección administrativa asignada al OPERADOR
        $builder->join('sgc_direcciones_administrativas as dir_ope', 'u_ope.id_direccion_administrativa = dir_ope.id', 'left');
        
        // JOIN EXTRA: Para traer el nombre de la Línea Estratégica (Ajusta el nombre de la tabla si cambia)
        // JOIN CORREGIDO: Tabla en singular 'sgc_linea_estrategica'
        $builder->join('sgc_linea_estrategica as line_est', 'a.id_linea_estrategica = line_est.id', 'left');

        $builder->join('sgc_paises as pais', 'a.pais = pais.paisid', 'left');
        $builder->join('sgc_estados as est', 'a.estadoid = est.estadoid', 'left');
        $builder->join('sgc_municipio as mun', 'a.municipioid = mun.municipioid', 'left');
        $builder->join('sgc_parroquias as par', 'a.parroquiaid = par.parroquiaid', 'left');
        $builder->join('sgc_red_social as rs', 'a.idrrss = rs.red_s_id', 'left');
        $builder->join('sgc_org_pod_popular as org', 'a.caso_org_id = org.org_id', 'left');

        // Cláusulas WHERE Base obligatorias
        $builder->where('a.borrado', false);
        $builder->groupStart();
            $builder->where('caso_r.vigencia', true);
            $builder->orWhere('caso_r.vigencia IS NULL');
        $builder->groupEnd();

        // Conteo base inalterable (53,503)
        $builderTotal = clone $builder;
        $totalQuery   = $builderTotal->select('COUNT(DISTINCT a.idcaso) as total')->get();
        $totalRow     = $totalQuery->getRow();
        $recordsTotal = $totalRow ? (int)$totalRow->total : 0; 

        // --- Paso 3: Aplicar Filtros Dinámicos ---
        if (!empty($params['desde']) && !empty($params['hasta'])) {
            $builder->where('a.casofec >=', $params['desde']);
            $builder->where('a.casofec <=', $params['hasta']);
        }

        if (!empty($params['edad_min']) && !empty($params['edad_max'])) {
            $builder->where('a.edad >=', $params['edad_min']);
            $builder->where('a.edad <=', $params['edad_max']);
        }

        if (!empty($params['tipo_pi'])) {
            $builder->where('tpinte.tipo_prop_id', $params['tipo_pi']);
        }

        if (!empty($params['tipo_atencion_usu'])) {
            $builder->where('t_antusu.tipo_aten_id', $params['tipo_atencion_usu']);
        }

        if (!empty($params['sexo'])) {
            $builder->where('a.sexo', $params['sexo']);
        }

        if (!empty($params['via_atencion'])) {
            $builder->where('a.idrrss', $params['via_atencion']);
        }

        if (!empty($params['direcciones_caso'])) {
            $builder->where('caso_r.direccion_id', $params['direcciones_caso']);
        }

        if (!empty($params['usuarios'])) {
            $builder->where('a.idusuopr', $params['usuarios']);
        } else {
            if (!empty($params['direccion_administrativa'])) {
                $builder->where('u_ope.id_direccion_administrativa', $params['direccion_administrativa']);
            }
        }

        if (!empty($params['tipo_beneficiario'])) {
            $builder->where('a.tipo_beneficiario', $params['tipo_beneficiario']);
        }

        if (!empty($params['atencion_cuidadano'])) {
            $builder->where('a.ofiid', $params['atencion_cuidadano']);
        }

        if (!empty($params['estatus'])) {
            $builder->where('a.idest', $params['estatus']);
        }

        if (!empty($params['id_pais'])) {
            $builder->where('a.pais', $params['id_pais']);
        }

        if (!empty($params['id_estado'])) {
            $builder->where('a.estadoid', $params['id_estado']);
        }

        if (!empty($params['id_municipio'])) {
            $builder->where('a.municipioid', $params['id_municipio']);
        }

        if (!empty($params['id_parroquia'])) {
            $builder->where('a.parroquiaid', $params['id_parroquia']);
        }

        if (!empty($params['org_id'])) {
            $builder->where('a.caso_org_id', $params['org_id']);
        }

        if (!empty($params['detalle_atencion'])) {
            $builder->where('a.tipo_atend_id', $params['detalle_atencion']);
        }
        
       if (!empty($params['linea_estrategica']) && $params['linea_estrategica'] !== '0' && $params['linea_estrategica'] !== 'null') {
            $builder->where('a.id_linea_estrategica', $params['linea_estrategica']);
        }

        // Buscador Global Sanitizado
        if (!empty($params['search'])) {
            $search = $params['search'];
            $builder->groupStart();
                $builder->like('CAST(a.idcaso AS TEXT)', $search);
                $builder->orLike('TRIM(a.casoced)', $search);
                $builder->orLike('LOWER(a.casonom)', strtolower($search));
                $builder->orLike('LOWER(a.casoape)', strtolower($search));
                $builder->orLike('LOWER(b.estnom)', strtolower($search));
                $builder->orLike('LOWER(t_antusu.tipo_aten_nombre)', strtolower($search));
                $builder->orLike('LOWER(tpinte.tipo_prop_nombre)', strtolower($search));
                $builder->orLike('LOWER(t_bene.tipo_beneficiario_nombre)', strtolower($search));
                $builder->orLike("LOWER(CONCAT(u_ope.usuopnom, ' ', u_ope.usuopape))", strtolower($search));
                $builder->orLike('LOWER(rs.red_s_nom)', strtolower($search));
            $builder->groupEnd();
        }

        // --- Paso 4: Obtener el conteo filtrado ---
        $builderCount = clone $builder;
        $filteredQuery = $builderCount->select('COUNT(DISTINCT a.idcaso) as total')->get();
        $filteredRow   = $filteredQuery->getRow();
        $recordsFiltered = $filteredRow ? (int)$filteredRow->total : 0; 

        // --- Paso 5: Agregar las columnas específicas para el SELECT de datos ---
        $builder->select('caso_r.casos_re_id, a.idcaso, a.casotel, TRIM(a.casoced) AS casoced, a.casonom, a.casoape, a.casodesc');
        $builder->select('a.caso_nacionalidad, a.idrrss, a.ofiid, a.estadoid, a.id_tipo_atencion');
        
        // "Casos Remitidos a"
        $builder->select("CASE WHEN ubi.descripcion IS NULL THEN 'No aplica' ELSE ubi.descripcion END as descripcion");
        
        // "Dirección Administrativa del Operador"
        $builder->select("CASE WHEN dir_ope.descripcion IS NULL THEN 'No asignada' ELSE dir_ope.descripcion END as direccion_admin_operador");
        
        // "Línea Estratégica"
       // SELECT CORREGIDO: Apuntando a 'descripcion' en lugar de 'nombre'
        $builder->select("CASE WHEN line_est.descripcion IS NULL THEN 'No aplica' ELSE line_est.descripcion END as linea_estrategica_nombre");

        $builder->select('t_bene.tipo_beneficiario_nombre as tipo_beneficiario');
        $builder->select('a.municipioid, a.parroquiaid');
        $builder->select('CONCAT(a.caso_nacionalidad, a.casoced) AS cedula');
        $builder->select("CONCAT(a.casonom, ' ', a.casoape) AS nombre");
        
        // "Operador"
        $builder->select("CONCAT(u_ope.usuopnom, ' ', u_ope.usuopape) AS user_name");
        
        $builder->select("CASE WHEN a.sexo='1' THEN 'MASCULINO' WHEN a.sexo='2' THEN 'FEMENINO' ELSE 'NO DEFINIDO' END as sexo");
        $builder->select('to_char(a.casofec, \'dd/mm/yyyy\') as casofec, a.casofec as casofec_normal, b.estnom');
        $builder->select('tpinte.tipo_prop_nombre, tpinte.tipo_prop_id, t_antusu.tipo_aten_nombre');
        $builder->select('pais.paisnom as pais_nombre, est.estadonom as estado_nombre, mun.municipionom as municipio_nombre, par.parroquianom as parroquia_nombre');
        $builder->select("CASE WHEN rs.red_s_nom IS NULL THEN 'No aplica' ELSE rs.red_s_nom END as via_atencion_nombre");
        $builder->select("CASE WHEN org.org_nombre IS NULL THEN 'No aplica' ELSE org.org_nombre END as organismo_pp_nombre");

        // --- Paso 6: Orden y límites ---
        if (!empty($params['order_column']) && !empty($params['order_direction'])) {
            $builder->orderBy($params['order_column'], $params['order_direction']);
        } else {
            $builder->orderBy('a.idcaso', 'DESC');
        }

        if ($params['length'] != -1) {
            $builder->limit($params['length'], $params['start']);
        }

        // --- Paso 7: Obtener los datos ---
        $query = $builder->get();
        $data = $query->getResultArray();

        return [
            "recordsTotal" => (int)$recordsTotal,
            "recordsFiltered" => (int)$recordsFiltered,
            "data" => $data
        ];
    }
  public function getReporteData_Politicas_Publicas($params)
{
    $db = \Config\Database::connect();

    // --- Paso 1: Sanitización Ultra-Estricta ---
    foreach ($params as $key => $value) {
        if ($key === 'search' && is_array($value) && isset($value['value'])) { $value = $value['value']; $params[$key] = $value; }
        if (is_string($value)) {
            $value = trim($value); $valueLower = strtolower($value);
            if ($value === '' || $value === 'null' || $value === 'undefined' || $value === '0' || $value === '-1' || $valueLower === 'seleccione' || $valueLower === 'todos' || strpos($valueLower, 'seleccione') !== false || ($key === 'id_pais' && $value === '1') || ($key === 'id_estado' && $value === '26') || ($key === 'id_municipio' && $value === '336') || ($key === 'id_parroquia' && $value === '1135')) { $params[$key] = null; } else { $params[$key] = $value; }
        } elseif (is_numeric($value)) {
            if ($value === 0 || $value === -1 || ($key === 'id_pais' && $value == 1) || ($key === 'id_estado' && $value == 26) || ($key === 'id_municipio' && $value == 336) || ($key === 'id_parroquia' && $value == 1135)) { $params[$key] = null; }
        } else { if (empty($value)) { $params[$key] = null; } }
    }

    // --- Paso 2: Consulta base ---
    $builder = $db->table('sgc_casos as a');
    $builder->distinct();
    $builder->join('sgc_estatus b', 'b.idest = a.idest', 'inner');
    $builder->join('sgc_usuario_operador u_ope', 'a.idusuopr = u_ope.idusuopr', 'inner');
    $builder->join('sgc_tipo_prop_caso as tpc', 'a.idcaso = tpc.idcaso', 'left');
    $builder->join('sgc_tipo_beneficiarios as t_bene', 'a.tipo_beneficiario = t_bene.tipo_beneficiario_id', 'left');
    $builder->join('sgc_tipoatencion_usu as t_antusu', 'a.id_tipo_atencion = t_antusu.tipo_aten_id', 'left');
    $builder->join('sgc_tipo_prop_intelec as tpinte', 'tpc.idtippropint = tpinte.tipo_prop_id', 'left');
    $builder->join('sgc_casos_remitidos as caso_r', 'a.idcaso = caso_r.casos_id', 'left');
    $builder->join('sgc_direcciones_administrativas as ubi', 'caso_r.direccion_id = ubi.id', 'left');
    $builder->join('sgc_direcciones_administrativas as dir_ope', 'u_ope.id_direccion_administrativa = dir_ope.id', 'left');
    $builder->join('sgc_linea_estrategica as line_est', 'a.id_linea_estrategica = line_est.id', 'left');
    $builder->join('sgc_paises as pais', 'a.pais = pais.paisid', 'left');
    $builder->join('sgc_estados as est', 'a.estadoid = est.estadoid', 'left');
    $builder->join('sgc_municipio as mun', 'a.municipioid = mun.municipioid', 'left');
    $builder->join('sgc_parroquias as par', 'a.parroquiaid = par.parroquiaid', 'left');
    $builder->join('sgc_red_social as rs', 'a.idrrss = rs.red_s_id', 'left');
    $builder->join('sgc_org_pod_popular as org', 'a.caso_org_id = org.org_id', 'left');

    $builder->where('a.borrado', false);
    $builder->groupStart()->where('caso_r.vigencia', true)->orWhere('caso_r.vigencia IS NULL')->groupEnd();

    // --- Conteo Total ---
    $builderTotal = clone $builder;
    $totalQuery = $builderTotal->select('COUNT(DISTINCT a.idcaso) as total')->get();
    $recordsTotal = (int)($totalQuery->getRow()->total ?? 0);

    // --- Paso 3: Filtros Dinámicos ---
    if (!empty($params['desde']) && !empty($params['hasta'])) { $builder->where('a.casofec >=', $params['desde']); $builder->where('a.casofec <=', $params['hasta']); }
    if (!empty($params['edad_min']) && !empty($params['edad_max'])) { $builder->where('a.edad >=', $params['edad_min']); $builder->where('a.edad <=', $params['edad_max']); }
    if (!empty($params['tipo_pi'])) { $builder->where('tpinte.tipo_prop_id', $params['tipo_pi']); }
    if (!empty($params['tipo_atencion_usu'])) { $builder->where('t_antusu.tipo_aten_id', $params['tipo_atencion_usu']); }
    if (!empty($params['sexo'])) { $builder->where('a.sexo', $params['sexo']); }
    if (!empty($params['via_atencion'])) { $builder->where('a.idrrss', $params['via_atencion']); }
    if (!empty($params['direcciones_caso'])) { $builder->where('caso_r.direccion_id', $params['direcciones_caso']); }
    if (!empty($params['usuarios'])) { $builder->where('a.idusuopr', $params['usuarios']); } else { if (!empty($params['direccion_administrativa'])) { $builder->where('u_ope.id_direccion_administrativa', $params['direccion_administrativa']); } }
    if (!empty($params['tipo_beneficiario'])) { $builder->where('a.tipo_beneficiario', $params['tipo_beneficiario']); }
    if (!empty($params['atencion_cuidadano'])) { $builder->where('a.ofiid', $params['atencion_cuidadano']); }
    if (!empty($params['estatus'])) { $builder->where('a.idest', $params['estatus']); }
    if (!empty($params['id_pais'])) { $builder->where('a.pais', $params['id_pais']); }
    if (!empty($params['id_estado'])) { $builder->where('a.estadoid', $params['id_estado']); }
    if (!empty($params['id_municipio'])) { $builder->where('a.municipioid', $params['id_municipio']); }
    if (!empty($params['id_parroquia'])) { $builder->where('a.parroquiaid', $params['id_parroquia']); }
    if (!empty($params['org_id'])) { $builder->where('a.caso_org_id', $params['org_id']); }
    if (!empty($params['detalle_atencion'])) { $builder->where('a.tipo_atend_id', $params['detalle_atencion']); }
    if (!empty($params['linea_estrategica']) && $params['linea_estrategica'] !== '0' && $params['linea_estrategica'] !== 'null') { $builder->where('a.id_linea_estrategica', $params['linea_estrategica']); }

    if (!empty($params['search'])) {
        $search = $params['search'];
        $builder->groupStart();
            $builder->like('CAST(a.idcaso AS TEXT)', $search);
            $builder->orLike('TRIM(a.casoced)', $search);
            $builder->orLike('LOWER(a.casonom)', strtolower($search));
            $builder->orLike('LOWER(a.casoape)', strtolower($search));
            $builder->orLike('LOWER(b.estnom)', strtolower($search));
            $builder->orLike('LOWER(t_antusu.tipo_aten_nombre)', strtolower($search));
            $builder->orLike('LOWER(tpinte.tipo_prop_nombre)', strtolower($search));
            $builder->orLike('LOWER(t_bene.tipo_beneficiario_nombre)', strtolower($search));
            $builder->orLike("LOWER(CONCAT(u_ope.usuopnom, ' ', u_ope.usuopape))", strtolower($search));
            $builder->orLike('LOWER(rs.red_s_nom)', strtolower($search));
        $builder->groupEnd();
    }

    $builderCount = clone $builder;
    $filteredQuery = $builderCount->select('COUNT(DISTINCT a.idcaso) as total')->get();
    $recordsFiltered = (int)($filteredQuery->getRow()->total ?? 0);

    // --- Paso 5: SELECT Final ---
    $builder->select('caso_r.casos_re_id, a.idcaso, a.casotel, TRIM(a.casoced) AS casoced, UPPER(a.casonom) as casonom, UPPER(a.casoape) as casoape, UPPER(a.casodesc) as casodesc, a.caso_nacionalidad, a.idrrss, a.ofiid, a.estadoid, a.id_tipo_atencion');
    
    // Subconsulta Beneficiarios
    $subQueryPart = "(SELECT string_agg(DISTINCT UPPER(tb.tipo_beneficiario_nombre), ', ') FROM sgc_talleres_participantes tp JOIN sgc_participantes p ON tp.participante_id = p.id JOIN sgc_tipo_beneficiarios tb ON p.tipo_beneficiario = tb.tipo_beneficiario_id WHERE tp.id_caso = a.idcaso)";
    $builder->select("CASE WHEN a.id_tipo_atencion = 7 THEN COALESCE($subQueryPart, 'SIN PARTICIPANTES') ELSE COALESCE(UPPER(t_bene.tipo_beneficiario_nombre), 'N/A') END as tipo_beneficiario");
    
    // Subconsulta Circuito C (Organismos)
    $subQueryOrg = "(SELECT string_agg(DISTINCT UPPER(o.org_nombre), ', ') FROM sgc_talleres_participantes tp JOIN sgc_org_pod_popular o ON tp.org_id = o.org_id WHERE tp.id_caso = a.idcaso)";
    $builder->select("CASE WHEN a.id_tipo_atencion = 7 THEN COALESCE($subQueryOrg, 'NO APLICA') ELSE COALESCE(UPPER(org.org_nombre), 'N/A') END as circuito_c_atendido");
    
    // Contadores de Género
    $builder->select("CASE WHEN a.id_tipo_atencion = 7 THEN (SELECT COALESCE(COUNT(*), 0) FROM sgc_talleres_participantes WHERE id_caso = a.idcaso) ELSE 1 END as cant_personas");
    $builder->select("CASE WHEN a.id_tipo_atencion = 7 THEN (SELECT COALESCE(COUNT(*), 0) FROM sgc_talleres_participantes tp JOIN sgc_participantes p ON tp.participante_id = p.id WHERE tp.id_caso = a.idcaso AND p.sexo = 'M') ELSE (CASE WHEN a.sexo = 1 THEN 1 ELSE 0 END) END as masculino");
    $builder->select("CASE WHEN a.id_tipo_atencion = 7 THEN (SELECT COALESCE(COUNT(*), 0) FROM sgc_talleres_participantes tp JOIN sgc_participantes p ON tp.participante_id = p.id WHERE tp.id_caso = a.idcaso AND p.sexo = 'F') ELSE (CASE WHEN a.sexo = 2 THEN 1 ELSE 0 END) END as femenino");
    
    // --- Campos de información ---
    $builder->select("CASE WHEN ubi.descripcion IS NULL THEN 'NO APLICA' ELSE UPPER(ubi.descripcion) END as descripcion");
    $builder->select("CASE WHEN dir_ope.descripcion IS NULL THEN 'NO ASIGNADA' ELSE UPPER(dir_ope.descripcion) END as direccion_admin_operador");
    $builder->select("CASE WHEN line_est.descripcion IS NULL THEN 'NO APLICA' ELSE UPPER(line_est.descripcion) END as linea_estrategica_nombre");
    $builder->select('a.municipioid, a.parroquiaid');
    $builder->select("CONCAT(a.caso_nacionalidad, '-', a.casoced) AS cedula");
    $builder->select("UPPER(CONCAT(a.casonom, ' ', a.casoape)) AS nombre");
    $builder->select("UPPER(CONCAT(u_ope.usuopnom, ' ', u_ope.usuopape)) AS user_name");
    $builder->select("CASE WHEN a.sexo=1 THEN 'MASCULINO' WHEN a.sexo=2 THEN 'FEMENINO' ELSE 'NO DEFINIDO' END as sexo");
    $builder->select('to_char(a.casofec, \'dd/mm/yyyy\') as casofec, a.casofec as casofec_normal, UPPER(b.estnom) as estnom');
    $builder->select('UPPER(tpinte.tipo_prop_nombre) as tipo_prop_nombre, tpinte.tipo_prop_id');
    $builder->select("CASE WHEN UPPER(t_antusu.tipo_aten_nombre) = 'FORMACIÓN' THEN 'FORMAR' WHEN UPPER(t_antusu.tipo_aten_nombre) = 'ASESORÍA' THEN 'ASESORAR' ELSE UPPER(t_antusu.tipo_aten_nombre) END as tipo_aten_nombre");
    $builder->select('UPPER(pais.paisnom) as pais_nombre, UPPER(est.estadonom) as estado_nombre, UPPER(mun.municipionom) as municipio_nombre, UPPER(par.parroquianom) as parroquia_nombre');
    $builder->select("CASE WHEN rs.red_s_nom IS NULL THEN 'NO APLICA' ELSE UPPER(rs.red_s_nom) END as via_atencion_nombre");
    $builder->select("CASE WHEN org.org_nombre IS NULL THEN 'NO APLICA' ELSE UPPER(org.org_nombre) END as organismo_pp_nombre");

    // --- Paso 6: Orden y límites ---
    if (!empty($params['order_column'])) { $builder->orderBy($params['order_column'], $params['order_direction'] ?? 'DESC'); } else { $builder->orderBy('a.idcaso', 'DESC'); }
    if ($params['length'] != -1) { $builder->limit($params['length'], $params['start']); }

    return [ "recordsTotal" => $recordsTotal, "recordsFiltered" => $recordsFiltered, "data" => $builder->get()->getResultArray() ];
}
// Dataset específico para el reporte de Operadores
    public function getReporteOperadorData(array $params)
    {
        $db = \Config\Database::connect();

        // --- Paso 1: Sanitización Ultra-Estricta de Parámetros ---
        foreach ($params as $key => $value) {
            // Extraer el buscador de DataTables si llega estructurado como array
            if ($key === 'search' && is_array($value) && isset($value['value'])) {
                $value = $value['value'];
                $params[$key] = $value;
            }

            // Si es una cadena de texto, limpiamos espacios y evaluamos variaciones
            if (is_string($value)) {
                $value = trim($value);
                $valueLower = strtolower($value);
                
                if (
                    $value === '' || 
                    $value === 'null' || 
                    $value === 'undefined' ||
                    $value === '0' ||
                    $value === '-1' ||
                    $valueLower === 'seleccione' || 
                    $valueLower === 'todos' ||
                    strpos($valueLower, 'seleccione') !== false || // Seguro para PHP anterior a 8.0
                    ($key === 'id_pais' && $value === '1') ||      // Neutraliza el valor inicial de Venezuela
                    ($key === 'id_estado' && $value === '26') ||
                    ($key === 'id_municipio' && $value === '336') ||
                    ($key === 'id_parroquia' && $value === '1135')
                ) {
                    $params[$key] = null;
                } else {
                    $params[$key] = $value;
                }
            } 
            // Si llega directamente mapeado como un valor numérico por el framework
            elseif (is_numeric($value)) {
                if (
                    $value === 0 || 
                    $value === -1 ||
                    ($key === 'id_pais' && $value == 1) || 
                    ($key === 'id_estado' && $value == 26) ||
                    ($key === 'id_municipio' && $value == 336) ||
                    ($key === 'id_parroquia' && $value == 1135)
                ) {
                    $params[$key] = null;
                }
            } 
            // Manejo de contingencia para arrays vacíos u otros objetos
            else {
                if (empty($value)) {
                    $params[$key] = null;
                }
            }
        }

        // --- Paso 2: Construir la consulta base (Estructura Base) ---
        $builder = $db->table('sgc_casos as a');
        $builder->distinct();

        // Joins obligatorios para la estructura base del universo de datos
        $builder->join('sgc_estatus b', 'b.idest = a.idest', 'inner');
        $builder->join('sgc_usuario_operador u_ope', 'a.idusuopr = u_ope.idusuopr', 'inner');
        $builder->join('sgc_tipo_prop_caso as tpc', 'a.idcaso = tpc.idcaso', 'left');
        $builder->join('sgc_tipo_beneficiarios as t_bene', 'a.tipo_beneficiario = t_bene.tipo_beneficiario_id', 'left');
        $builder->join('sgc_tipoatencion_usu as t_antusu', 'a.id_tipo_atencion = t_antusu.tipo_aten_id', 'left');
        $builder->join('sgc_tipo_prop_intelec as tpinte', 'tpc.idtippropint = tpinte.tipo_prop_id', 'left');
        $builder->join('sgc_casos_remitidos as caso_r', 'a.idcaso = caso_r.casos_id', 'left');
        $builder->join('sgc_direcciones_administrativas as ubi', 'caso_r.direccion_id = ubi.id', 'left');
        $builder->join('sgc_paises as pais', 'a.pais = pais.paisid', 'left');
        $builder->join('sgc_estados as est', 'a.estadoid = est.estadoid', 'left');
        $builder->join('sgc_municipio as mun', 'a.municipioid = mun.municipioid', 'left');
        $builder->join('sgc_parroquias as par', 'a.parroquiaid = par.parroquiaid', 'left');
        $builder->join('sgc_red_social as rs', 'a.idrrss = rs.red_s_id', 'left');
        $builder->join('sgc_org_pod_popular as org', 'a.caso_org_id = org.org_id', 'left');

        // Cláusulas WHERE Base obligatorias
        $builder->where('a.borrado', false);
        $builder->groupStart();
            $builder->where('caso_r.vigencia', true);
            $builder->orWhere('caso_r.vigencia IS NULL');
        $builder->groupEnd();

        // Conteo base inalterable del universo de datos inicial (53,503)
        $builderTotal = clone $builder;
        $totalQuery   = $builderTotal->select('COUNT(DISTINCT a.idcaso) as total')->get();
        $totalRow     = $totalQuery->getRow();
        $recordsTotal = $totalRow ? (int)$totalRow->total : 0; 

        // --- Paso 3: Aplicar Filtros Dinámicos del Formulario ---
        if (!empty($params['usuarios'])) {
            $builder->where('a.idusuopr', $params['usuarios']);
        }

        if (!empty($params['desde']) && !empty($params['hasta'])) {
            $builder->where('a.casofec >=', $params['desde']);
            $builder->where('a.casofec <=', $params['hasta']);
        }

        if (!empty($params['edad_min']) && !empty($params['edad_max'])) {
            $builder->where('a.edad >=', $params['edad_min']);
            $builder->where('a.edad <=', $params['edad_max']);
        }

        if (!empty($params['tipo_pi'])) {
            $builder->where('tpinte.tipo_prop_id', $params['tipo_pi']);
        }

        if (!empty($params['tipo_atencion_usu'])) {
            $builder->where('t_antusu.tipo_aten_id', $params['tipo_atencion_usu']);
        }

        if (!empty($params['sexo'])) {
            $builder->where('a.sexo', $params['sexo']);
        }

        if (!empty($params['via_atencion'])) {
            $builder->where('a.idrrss', $params['via_atencion']);
        }

        if (!empty($params['direcciones_caso'])) {
            $builder->where('caso_r.direccion_id', $params['direcciones_caso']);
        }

        if (!empty($params['tipo_beneficiario'])) {
            $builder->where('a.tipo_beneficiario', $params['tipo_beneficiario']);
        }

        if (!empty($params['atencion_cuidadano'])) {
            $builder->where('a.ofiid', $params['atencion_cuidadano']);
        }

        if (!empty($params['estatus'])) {
            $builder->where('a.idest', $params['estatus']);
        }

        if (!empty($params['id_pais'])) {
            $builder->where('a.pais', $params['id_pais']);
        }

        if (!empty($params['id_estado'])) {
            $builder->where('a.estadoid', $params['id_estado']);
        }

        if (!empty($params['id_municipio'])) {
            $builder->where('a.municipioid', $params['id_municipio']);
        }

        if (!empty($params['id_parroquia'])) {
            $builder->where('a.parroquiaid', $params['id_parroquia']);
        }

        if (!empty($params['org_id'])) {
            $builder->where('a.caso_org_id', $params['org_id']);
        }

        if (!empty($params['detalle_atencion'])) {
            $builder->where('a.tipo_atend_id', $params['detalle_atencion']);
        }

        // Buscador Global seguro y sanitizado nativamente
        if (!empty($params['search'])) {
            $search = $params['search'];
            
            $builder->groupStart();
                $builder->like('CAST(a.idcaso AS TEXT)', $search);
                $builder->orLike('TRIM(a.casoced)', $search);
                $builder->orLike('LOWER(a.casonom)', strtolower($search));
                $builder->orLike('LOWER(a.casoape)', strtolower($search));
                $builder->orLike('LOWER(b.estnom)', strtolower($search));
                $builder->orLike('LOWER(t_antusu.tipo_aten_nombre)', strtolower($search));
                $builder->orLike('LOWER(tpinte.tipo_prop_nombre)', strtolower($search));
                $builder->orLike('LOWER(t_bene.tipo_beneficiario_nombre)', strtolower($search));
                $builder->orLike("LOWER(CONCAT(u_ope.usuopnom, ' ', u_ope.usuopape))", strtolower($search));
                $builder->orLike('LOWER(rs.red_s_nom)', strtolower($search));
            $builder->groupEnd();
        }

        // --- Paso 4: Obtener el conteo de registros filtrados dinámicamente ---
        $builderCount = clone $builder;
        $filteredQuery = $builderCount->select('COUNT(DISTINCT a.idcaso) as total')->get();
        $filteredRow   = $filteredQuery->getRow();
        $recordsFiltered = $filteredRow ? (int)$filteredRow->total : 0; 

        // --- Paso 5: Agregar las columnas del SELECT finales para retornar los registros ---
        $builder->select('caso_r.casos_re_id, a.idcaso, a.casotel, TRIM(a.casoced) AS casoced, a.casonom, a.casoape, a.casodesc');
        $builder->select('a.caso_nacionalidad, a.idrrss, a.ofiid, a.estadoid, a.id_tipo_atencion');
        $builder->select("CASE WHEN ubi.descripcion IS NULL THEN 'No aplica' ELSE ubi.descripcion END as descripcion");
        $builder->select('t_bene.tipo_beneficiario_nombre as tipo_beneficiario');
        $builder->select('a.municipioid, a.parroquiaid');
        $builder->select('CONCAT(a.caso_nacionalidad, a.casoced) AS cedula');
        $builder->select("CONCAT(a.casonom, ' ', a.casoape) AS nombre");
        $builder->select("CONCAT(u_ope.usuopnom, ' ', u_ope.usuopape) AS user_name");
        $builder->select("CASE WHEN a.sexo='1' THEN 'MASCULINO' WHEN a.sexo='2' THEN 'FEMENINO' ELSE 'NO DEFINIDO' END as sexo");
        $builder->select('to_char(a.casofec, \'dd/mm/yyyy\') as casofec, a.casofec as casofec_normal, b.estnom');
        $builder->select('tpinte.tipo_prop_nombre, tpinte.tipo_prop_id, t_antusu.tipo_aten_nombre');
        $builder->select('pais.paisnom as pais_nombre, est.estadonom as estado_nombre, mun.municipionom as municipio_nombre, par.parroquianom as parroquia_nombre');
        $builder->select("CASE WHEN rs.red_s_nom IS NULL THEN 'No aplica' ELSE rs.red_s_nom END as via_atencion_nombre");
        $builder->select("CASE WHEN org.org_nombre IS NULL THEN 'No aplica' ELSE org.org_nombre END as organismo_pp_nombre");

        // --- Paso 6: Orden y Paginación de DataTables ---
        if (!empty($params['order_column']) && !empty($params['order_direction'])) {
            $builder->orderBy($params['order_column'], $params['order_direction']);
        } else {
            $builder->orderBy('a.idcaso', 'DESC');
        }

        if ($params['length'] != -1) {
            $builder->limit($params['length'], $params['start']);
        }

        // --- Paso 7: Ejecutar Consulta de Datos ---
        $query = $builder->get();
        $data = $query->getResultArray();

        return [
            "recordsTotal" => (int)$recordsTotal,
            "recordsFiltered" => (int)$recordsFiltered,
            "data" => $data
        ];
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


/**
 * Cuenta los casos agrupados por fecha dentro de un rango opcionalmente filtrado por estado.
 *
 * @param string $startDate Fecha de inicio (puede ser 'null' como string).
 * @param string $endDate   Fecha de fin (puede ser 'null' como string).
 * @param string|int|null $id_estado ID del estado del caso, o 'null' como string si no se filtra.
 * @return \CodeIgniter\Database\Result|CI_DB_result Retorna el objeto resultado de la consulta.
 */
public function contarCasosPorFecha_filtro(string $startDate, string $endDate, $id_estado = 'null')
{
     $db = \Config\Database::connect();
    $builder = $this->dbconn('sgc_casos');
    
    $builder->select('casofec');
    $builder->selectCount('casofec', 'cantCases');
    
    // CORRECCIÓN/MEJORA: Aseguramos que solo se cuenten los casos NO borrados
    $builder->where('borrado', false);
    
    // Filtro de fecha
    if ($startDate !== 'null' && $endDate !== 'null') {
        $builder->where('casofec >=', $startDate);
        $builder->where('casofec <=', $endDate);
    } 
  
    // Filtro de estado
    if ($id_estado !== 'null' && $id_estado !== null) {
        $builder->where('estadoid', $id_estado);
    }
    
    $builder->groupBy('casofec');
    $builder->orderBy('casofec', 'ASC');
    
    $result = $builder->get();
   
    return $result;
}
    

   /**
 * Cuenta los Casos Atendidos por Vía de Atención (Red Social) dentro de un rango de fechas y estado opcional.
 * * @param string $desde Fecha de inicio (puede ser 'null' como string).
 * @param string $hasta Fecha de fin (puede ser 'null' como string).
 * @param string|int $id_estado ID del estado del caso, o 'null' como string si no se filtra.
 * @return array Retorna un array de objetos con el conteo por red social.
 */
public function contarCasosAtendidos_Fecha(string $desde, string $hasta, $id_estado = 'null')
{
    
    $db = \Config\Database::connect();
 
    $subBuilder = $db->table('sgc_casos');
    $subBuilder->select('idrrss');
    $subBuilder->selectCount('*', 'count');
    $subBuilder->where('borrado', false);
    
    // Aplicar filtros de fecha a la subconsulta de casos
    if ($desde !== 'null' && $hasta !== 'null') {
        $subBuilder->where('casofec >=', $desde);
        $subBuilder->where('casofec <=', $hasta);
    }
    
    // Aplicar filtro de estado a la subconsulta de casos
    if ($id_estado !== 'null' && $id_estado !== null) {
        $subBuilder->where('estadoid', $id_estado);
    }
    
    $subBuilder->groupBy('idrrss');
    // Generar la cadena SQL de la subconsulta y aliñarla como 'tot'
    $subquery = $subBuilder->getCompiledSelect();
    
    // --- 2. Construcción de la Consulta Principal ---
    $builder = $db->table('sgc_red_social AS red');
    $builder->select('red.red_s_id, red.red_s_nom');
    
    // COALESCE para mostrar 0 si no hay coincidencias
    $builder->select('COALESCE(tot.count, 0) AS count');

    // Realizar el LEFT JOIN usando la subconsulta generada
    // IMPORTANTE: El JOIN debe pasar el SQL de la subconsulta y el alias 'tot'
    $builder->join("($subquery) AS tot", 'red.red_s_id = tot.idrrss', 'left');
    
    // Filtrar solo las redes sociales que no están borradas
    $builder->where('red.red_s_borrado', false);
    
    $builder->orderBy('red.red_s_nom', 'ASC');
    
    $query = $builder->get();
    return $query->getResult();
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



   public function ContarCasosPorMunicipioYTipoAtencion($estado = null, $desde = null, $hasta = null)
{
    $db = \Config\Database::connect();
    $builder = $db->table('sgc_casos AS c');

    // Mantenemos los nombres de columna tal cual los necesitas en tu vista
    $builder->select('
        m.municipionom, 
        aten.tipo_aten_nombre, 
        COUNT(c.idcaso) AS count 
    ');
    
    // Unimos las tablas con LEFT JOIN tal como en tu SQL
    $builder->join('sgc_municipio AS m', 'c.municipioid = m.municipioid', 'left');
    $builder->join('sgc_tipoatencion_usu AS aten', 'c.id_tipo_atencion = aten.tipo_aten_id', 'left');
    // Filtro obligatorio: casos no borrados ("c"."borrado" = FALSE)
    $builder->where('c.borrado', false);
    if ($estado != 'null' && $estado != '0' && $estado !== null) {
        $builder->where('c.estadoid', $estado);
    }
    // Filtro condicional por el rango de fechas (replicando la lógica existente de tu función)
    if ($desde != 'null' && $hasta != 'null' && $desde !== null && $hasta !== null) {
        $builder->where('c.casofec >=', $desde);
        $builder->where('c.casofec <=', $hasta);
    }
    // Agrupamos por municipio y tipo de atención (GROUP BY)
    $builder->groupBy('m.municipionom, aten.tipo_aten_nombre');
    // Ordenamos por municipio y tipo de atención (ORDER BY)
    $builder->orderBy('m.municipionom, aten.tipo_aten_nombre');
    $query = $builder->get();
    return $query->getResult();
}

     // Método que consulta los estados con filtro de estado
    public function consultar_estados_filtro($estado = null, $desde = null, $hasta = null)
{
    $db = \Config\Database::connect();
    $builder = $db->table('public.sgc_estados AS estados');
    $builder->select('estados.estadoid, estados.estadonom, COUNT(c.estadoid) AS count');
    $builder->join('sgc_casos AS c', 'estados.estadoid = c.estadoid', 'left');
    $builder->where('c.borrado', false);
    if ($estado != 'null' && $estado != '0') {
        $builder->where('c.estadoid', $estado);
    }
    if ($desde != 'null' && $hasta != 'null') {
        $builder->where('c.casofec >=', $desde);
        $builder->where('c.casofec <=', $hasta);
    }
    $builder->groupBy('estados.estadoid, estados.estadonom');
    $builder->orderBy('estados.estadonom');
    $query = $builder->get();
    $resultado = $query->getResult();
    return $resultado;
}


// Método que cuenta los casos atendidos por tipo de atención estadales con filtro de estado
   public function ContarasosTipoSolicitud_Estadal_filtro($estado = null, $desde = null, $hasta = null)
{
    $db = \Config\Database::connect();
    $builder = $db->table('sgc_casos AS c');
    $builder->select('COALESCE(COUNT(c.id_tipo_atencion), 0) AS count, COALESCE(aten.tipo_aten_nombre, \'No Aplica\') AS tipo_aten_nombre, estados.estadonom');
    $builder->join('sgc_tipoatencion_usu AS aten', 'c.id_tipo_atencion = aten.tipo_aten_id', 'left');
    $builder->join('public.sgc_estados AS estados', 'c.estadoid = estados.estadoid', 'left');
    $builder->where('c.borrado', false);
    $builder->where('aten.tipo_aten_borrado', false);
    if ($estado != 'null' && $estado != '0') {
        $builder->where('c.estadoid', $estado);
    }
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



   /**
 * Cuenta los Casos Atendidos por Vía de Atención (Red Social) para el GÉNERO MASCULINO.
 *
 * @param string $desde Fecha de inicio (puede ser 'null' como string).
 * @param string $hasta Fecha de fin (puede ser 'null' como string).
 * @param string|int $id_estado ID del estado del caso, o 'null' como string si no se filtra.
 * @return array Retorna un array de objetos con el conteo por red social.
 */
public function contarCasosAtendidos_MASCULINO($desde = 'null', $hasta = 'null', $id_estado = 'null')
{
    $db = \Config\Database::connect();
    $builder = $db->table('public.sgc_red_social AS rs');

    // 1. SELECT: Usamos COUNT de la tabla 'c' para que el LEFT JOIN funcione (si no hay casos, dará 0)
    $builder->select('rs.red_s_nom, COALESCE(COUNT(c.idrrss), 0) AS count');

    // --- 2. CONSTRUCCIÓN DE LA CONDICIÓN DEL JOIN ---
    
    // IMPORTANTE: En PostgreSQL, los booleanos no llevan comillas. 
    // Al usar un array o dejarlo como string sin escapar manualmente, 
    // evitamos que CI añada comillas erróneas.
    $joinCond = 'rs.red_s_id = c.idrrss AND c.borrado = FALSE AND c.sexo = 1';

    // Manejo de Fechas
    if ($desde !== 'null' && $desde !== null && $hasta !== 'null' && $hasta !== null) {
        // Usamos escape() para seguridad contra Inyección SQL
        $joinCond .= " AND c.casofec >= " . $db->escape($desde);
        $joinCond .= " AND c.casofec <= " . $db->escape($hasta);
    }

    // Manejo de Estado
    if ($id_estado !== 'null' && $id_estado !== null) {
        $joinCond .= " AND c.estadoid = " . $db->escape($id_estado);
    }
    
    // Aplicar el LEFT JOIN
    // El tercer parámetro 'false' evita que CodeIgniter intente poner comillas (escapar) 
    // a toda la cadena de la condición, lo cual es crítico en PostgreSQL.
    $builder->join('public.sgc_casos AS c', $joinCond, 'left', false);

    // 3. Agrupación y Orden
    $builder->groupBy('rs.red_s_id, rs.red_s_nom');
    $builder->orderBy('rs.red_s_nom', 'ASC');

    return $builder->get()->getResult();
}

   /**
 * Cuenta los Casos Atendidos por Vía de Atención (Red Social) para el GÉNERO FEMENINO.
 *
 * @param string $desde Fecha de inicio (puede ser 'null' como string).
 * @param string $hasta Fecha de fin (puede ser 'null' como string).
 * @param string|int $id_estado ID del estado del caso, o 'null' como string si no se filtra.
 * @return array Retorna un array de objetos con el conteo por red social.
 */
public function contarCasosAtendidos_FEMENINO($desde = 'null', $hasta = 'null', $id_estado = 'null')
{
    $db = \Config\Database::connect();
    $builder = $db->table('public.sgc_red_social AS rs');

    // 1. SELECT: Contamos idrrss de la tabla 'c' para que el LEFT JOIN devuelva 0 donde no hay matches
    $builder->select('COALESCE(COUNT(c.idrrss), 0) AS count, rs.red_s_nom');

    // --- 2. LEFT JOIN con todas las condiciones de CASOS ---
    
    // Definimos sexo = 2 para femenino y borrado = FALSE (sin comillas)
    $join_condition = 'rs.red_s_id = c.idrrss AND c.borrado = FALSE AND c.sexo = 2';

    // Agregar filtros de fecha a la condición del JOIN
    if ($desde !== 'null' && $desde !== null && $hasta !== 'null' && $hasta !== null) {
        $join_condition .= " AND c.casofec >= " . $db->escape($desde);
        $join_condition .= " AND c.casofec <= " . $db->escape($hasta);
    }

    // Agregar filtro de estado a la condición del JOIN
    if ($id_estado !== 'null' && $id_estado !== null) {
        $join_condition .= " AND c.estadoid = " . $db->escape($id_estado);
    }
    
    /**
     * IMPORTANTE: El cuarto parámetro 'false' evita que CodeIgniter añada 
     * comillas dobles incorrectas en PostgreSQL a nuestra cadena $join_condition.
     */
    $builder->join('public.sgc_casos AS c', $join_condition, 'left', false);

    // 3. Agrupación y Orden
    $builder->groupBy('rs.red_s_id, rs.red_s_nom');
    $builder->orderBy('rs.red_s_nom', 'ASC'); 

    return $builder->get()->getResult();
}
    
  /**
 * Cuenta los Casos Atendidos por Tipo de Solicitud dentro de un rango de fechas y estado opcional.
 * * @param string $desde Fecha de inicio (puede ser 'null' como string).
 * @param string $hasta Fecha de fin (puede ser 'null' como string).
 * @param string|int $id_estado ID del estado del caso, o 'null' como string si no se filtra.
 * @return array Retorna un array de objetos con el conteo por tipo de solicitud.
 */
public function contarCasosTipoSolicitudFecha($desde = 'null', $hasta = 'null', $id_estado = 'null')
{
    $db = \Config\Database::connect();

    // --- 1. Construcción de la Subconsulta (Conteo de Casos) ---
    // Usamos un Query Builder separado para asegurar el escape de variables
    $subBuilder = $db->table('sgc_casos AS cas');
    $subBuilder->select('id_tipo_atencion');
    $subBuilder->selectCount('*', 'count');
    
    // Asumiendo que 'borrado' es un booleano o 0/1, usamos la forma CI idiomática
    $subBuilder->where('cas.borrado', false);

    // Aplicar filtros de fecha de forma segura
    if ($desde !== 'null' && $hasta !== 'null') {
        $subBuilder->where('cas.casofec >=', $desde);
        $subBuilder->where('cas.casofec <=', $hasta);
    }

    // APLICACIÓN DEL FILTRO DE ESTADO (CORRECCIÓN CLAVE)
    if ($id_estado !== 'null' && $id_estado !== null) {
        $subBuilder->where('cas.estadoid', $id_estado);
    }
    
    $subBuilder->groupBy('cas.id_tipo_atencion');
    // Obtenemos la cadena SQL de la subconsulta ya compilada y escapada
    $subquery = $subBuilder->getCompiledSelect();

    // --- 2. Construcción de la Consulta Principal ---
    $builder = $db->table('sgc_tipoatencion_usu AS tip');
    $builder->select('tip.tipo_aten_id, tip.tipo_aten_nombre');
    
    // COALESCE para mostrar 0 si no hay coincidencias
    $builder->select('COALESCE(tot.count, 0) AS count');

    // Realizar el LEFT JOIN usando la subconsulta generada de forma segura
    $builder->join("($subquery) AS tot", 'tip.tipo_aten_id = tot.id_tipo_atencion', 'left');

    $builder->where('tip.tipo_aten_borrado', false);
    $builder->orderBy('tip.tipo_aten_nombre', 'ASC');
    
    $query = $builder->get();
    return $query->getResult();
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
            ->where('borrado', false)
            ->groupBy('id_tipo_atencion');

        // Subconsulta para obtener los tipos de atención
        $subQueryTipoAtencion = $builder
            ->select('tipo_aten_nombre, tipo_aten_id')
            ->where('tipo_aten_borrado', false)
            ->orderBy('tipo_aten_id', 'ASC');

        // Crear la consulta principal utilizando el Query Builder
        $query = $db->table('sgc_tipoatencion_usu AS tipoaten')
            ->select('tipoaten.tipo_aten_nombre, COALESCE(casos.veces, 0) AS count')
            ->join("({$subQueryCasos->getCompiledSelect()}) AS casos", 'casos.id_tipo_atencion = tipoaten.tipo_aten_id', 'left')
            ->where('tipoaten.tipo_aten_borrado', false)
            ->orderBy('tipoaten.tipo_aten_nombre', 'ASC');

        // Ejecutar la consulta
        $resultado = $query->get()->getResult();
        return $resultado; 
    }


   /**
 * Cuenta los Casos Atendidos por Tipo de Solicitud para GÉNERO MASCULINO, aplicando filtros de fecha y estado.
 *
 * @param string $desde Fecha de inicio (puede ser 'null' como string).
 * @param string $hasta Fecha de fin (puede ser 'null' como string).
 * @param string|int $id_estado ID del estado del caso, o 'null' como string si no se filtra.
 * @return array Retorna un array de objetos con el conteo por tipo de solicitud.
 */
public function contarCasosTipoSolicitudMasculino($desde = 'null', $hasta = 'null', $id_estado = 'null')
{
    $db = \Config\Database::connect();
    $builder = $db->table('sgc_tipoatencion_usu AS tip_ate');
    
    // 1. SELECT: Usamos c.idcaso para que el conteo sea 0 si el LEFT JOIN no encuentra coincidencias
    $builder->select('tip_ate.tipo_aten_nombre, COALESCE(COUNT(c.idcaso), 0) AS count');

    // --- 2. CONSTRUCCIÓN DE LA CONDICIÓN DEL JOIN ---
    
    // Sexo = 1 (Masculino), Borrado = FALSE (Postgres Keyword)
    // Se recomienda usar el número 1 sin comillas si el campo es integer
    $join_condition = 'c.id_tipo_atencion = tip_ate.tipo_aten_id AND c.sexo = 1 AND c.borrado = FALSE';
    
    // Filtros de Fecha
    if ($desde !== 'null' && $desde !== null && $hasta !== 'null' && $hasta !== null) {
        $join_condition .= " AND c.casofec >= " . $db->escape($desde);
        $join_condition .= " AND c.casofec <= " . $db->escape($hasta);
    }
    
    // Filtro de Estado
    if ($id_estado !== 'null' && $id_estado !== null) {
        $join_condition .= " AND c.estadoid = " . $db->escape($id_estado);
    }
    
    // IMPORTANTE: Cuarto parámetro 'false' para evitar el error de columna "FALSE"
    $builder->join('public.sgc_casos AS c', $join_condition, 'left', false);
    
    // 3. Filtros globales de la tabla base
    // Aquí sí podemos usar el booleano nativo de PHP ya que CI lo maneja bien en el WHERE
    $builder->where('tip_ate.tipo_aten_borrado', false);

    $builder->groupBy('tip_ate.tipo_aten_nombre');
    $builder->orderBy('tip_ate.tipo_aten_nombre', 'ASC');
    
    return $builder->get()->getResult(); 
}


/**
 * Cuenta los Casos Atendidos por Tipo de Solicitud para GÉNERO FEMENINO, aplicando filtros de fecha y estado.
 *
 * @param string $desde Fecha de inicio (puede ser 'null' como string).
 * @param string $hasta Fecha de fin (puede ser 'null' como string).
 * @param string|int $id_estado ID del estado del caso, o 'null' como string si no se filtra.
 * @return array Retorna un array de objetos con el conteo por tipo de solicitud.
 */
public function contarCasosTipoSolicitudFemenino($desde = 'null', $hasta = 'null', $id_estado = 'null')
{
    $db = \Config\Database::connect();
    $builder = $db->table('sgc_tipoatencion_usu AS tip_ate');
    
    // 1. SELECT: COALESCE asegura que los tipos de atención sin casos marquen 0
    $builder->select('tip_ate.tipo_aten_nombre, COALESCE(COUNT(c.idcaso), 0) AS count');

    // --- 2. CONSTRUCCIÓN DE LA CONDICIÓN ON DEL JOIN ---
    
    // Sexo = 2 (Femenino), Borrado = FALSE
    // Nota: El sexo se pasa como entero para evitar casts innecesarios en Postgres
    $join_condition = 'c.id_tipo_atencion = tip_ate.tipo_aten_id AND c.sexo = 2 AND c.borrado = FALSE';
    
    // Filtro de Fecha
    if ($desde !== 'null' && $desde !== null && $hasta !== 'null' && $hasta !== null) {
        $join_condition .= " AND c.casofec >= " . $db->escape($desde);
        $join_condition .= " AND c.casofec <= " . $db->escape($hasta);
    }
    
    // Filtro de Estado
    if ($id_estado !== 'null' && $id_estado !== null) {
        $join_condition .= " AND c.estadoid = " . $db->escape($id_estado);
    }
    
    // IMPORTANTE: El cuarto parámetro 'false' evita que CI escape la cadena
    // y transforme FALSE en "FALSE" (que causaría el ErrorException)
    $builder->join('public.sgc_casos AS c', $join_condition, 'left', false);
    
    // 3. Filtros de la tabla base
    $builder->where('tip_ate.tipo_aten_borrado', false);

    $builder->groupBy('tip_ate.tipo_aten_nombre');
    $builder->orderBy('tip_ate.tipo_aten_nombre', 'ASC');
    
    return $builder->get()->getResult(); 
}
    // Método que cuenta los Casos POR ESTATUS
    public function contarCasosEstatus()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('public.sgc_estatus AS estatus');
        $builder->select('estatus.estnom, COALESCE(casos.veces, 0) AS count');
        $builder->join('(SELECT COUNT(c.idcaso) AS veces, c.idest 
                        FROM public.sgc_casos c 
                        WHERE c.borrado = FALSE 
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
        $builder = $db->table('public.sgc_estatus AS estatus');
        $builder->select('COALESCE(estatus.estnom, \'No Aplica\') AS estnom, estados.estadonom, estados.estadoid, casos.casofec, COALESCE(casos.veces, 0) AS count');
        $builder->join('(SELECT COUNT(c.idcaso) AS veces, c.idest, c.estadoid, c.casofec 
                        FROM public.sgc_casos c 
                        where c.borrado = FALSE
                        GROUP BY c.idest, c.estadoid, c.casofec) AS casos', 'casos.idest = estatus.idest', 'left');
        $builder->join('public.sgc_estados AS estados', 'casos.estadoid = estados.estadoid', 'right');
        $builder->where('estatus.borrado', false);
        if ($desde != 'null' && $hasta != 'null') {
            $builder->where('casos.casofec >=', $desde);
            $builder->where('casos.casofec <=', $hasta);
        }
        $builder->orderBy('estados.estadonom', 'ASC');
        $query = $builder->get();
        //echo $db->getLastQuery(); 
        //die();
        $resultado = $query->getResult();
        return $resultado;
    }


    // Método que cuenta los casos estadales por tipo de beneficiario
    public function ContarCasos_Estadal_Tipo_Beneficiario($desde = null, $hasta = null)
    { 
        $db = \Config\Database::connect();
        $builder = $db->table('public.sgc_casos AS c');
        $builder->select('COALESCE(COUNT(c.tipo_beneficiario), 0) AS count, COALESCE(tb.tipo_beneficiario_nombre, \'No Aplica\') AS tipo_beneficiario_nombre, estados.estadonom');
        $builder->join('public.sgc_tipo_beneficiarios AS tb', 'c.tipo_beneficiario = tb.tipo_beneficiario_id', 'right');
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

 
    // //BUSCAMOS LOS CASOS ESTADALES POR ORGANISMO DEL PODER POPULAR
public function ContarCasos_Estadal_Organismo_PP($desde = null, $hasta = null)
{ 
    $db = \Config\Database::connect();
    $builder = $db->table('public.sgc_casos AS c');
    $builder->select('COUNT(c.caso_org_id) AS count, COALESCE(org.org_nombre) AS org_nombre, estados.estadonom');
    $builder->join('public.sgc_org_pod_popular AS org', 'c.caso_org_id = org.org_id', 'right');
    $builder->join('public.sgc_estados AS estados', 'c.estadoid = estados.estadoid', 'right');
    $builder->where('COALESCE(c.borrado, FALSE)', false);
    $builder->where('COALESCE(org.org_borrado, FALSE)', false);
    if ($desde != 'null' && $hasta != 'null') {
        $builder->where('c.casofec >=', $desde);
        $builder->where('c.casofec <=', $hasta);
    }
    // Agrupación y ordenación
    $builder->groupBy('org.org_nombre, estados.estadonom');
    $builder->orderBy('estados.estadonom', 'ASC');
    // Ejecutar la consulta
     //$query = $builder->get();
    $query = $builder->get();
    $resultado = $query->getResult();
    
    return $resultado;
}






    // Método que cuenta los casos estadales por tipo de propiedad intelectual
    public function ContarCasos_Estadal_Tipo_Prop_Intelectual($desde = null, $hasta = null)
    { 
        $db = \Config\Database::connect();
        $builder = $db->table('public.sgc_casos AS c');
        $builder->select('COUNT(tp_proint.tipo_prop_nombre) AS count, tp_proint.tipo_prop_nombre, estados.estadonom');
        $builder->join('public.sgc_tipo_prop_caso AS tip_caso', 'c.idcaso = tip_caso.idcaso');
        $builder->join('public.sgc_tipo_prop_intelec AS tp_proint', 'tip_caso.idtippropint = tp_proint.tipo_prop_id');
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
        $builder = $db->table('public.sgc_casos AS c');
        $builder->select('COALESCE(COUNT(c.id_tipo_atencion), 0) AS count, COALESCE(aten.tipo_aten_nombre, \'No Aplica\') AS tipo_aten_nombre, estados.estadonom');
        $builder->join('public.sgc_tipoatencion_usu AS aten', 'c.id_tipo_atencion = aten.tipo_aten_id', 'right');
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



    // Método que cuenta los casos atendidos por el detalle del  tipo de atención estadales
    public function Contarcasos_Detalle_Tipo_Atencion_Estadal($desde = null, $hasta = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('public.sgc_casos AS c');
        $builder->select('COALESCE(COUNT(c.tipo_atend_id), 0) AS count, COALESCE(deta.tipo_atend_nombre, \'No Aplica\') AS tipo_atend_nombre, estados.estadonom');
        $builder->join('public.sgc_tipoatenciondetalle AS deta', 'c.tipo_atend_id = deta.tipo_atend_id', 'right');
        $builder->join('public.sgc_estados AS estados', 'c.estadoid = estados.estadoid', 'right');
        $builder->where('COALESCE(c.borrado, FALSE)', false);
        $builder->where('COALESCE(deta.tipo_atend_borrado, FALSE)', false);
        if ($desde != 'null' && $hasta != 'null') {
            $builder->where('c.casofec >=', $desde);
            $builder->where('c.casofec <=', $hasta);
        }
        $builder->groupBy('deta.tipo_atend_nombre, estados.estadonom'  );
        $builder->orderBy('estados.estadonom', 'ASC' );
        $query = $builder->get();
        $resultado = $query->getResult();
        //echo $db->getLastQuery(); 
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

    
  /**
     * Cuenta los Casos agrupados por Estatus (sgc_estatus) dentro de un rango de fechas y estado opcional.
     *
     * @param string $desde Fecha de inicio (puede ser 'null' como string).
     * @param string $hasta Fecha de fin (puede ser 'null' como string).
     * @param string|int $id_estado ID del estado del caso, o 'null' como string si no se filtra.
     * @return array Retorna un array de objetos con el conteo por estatus.
     */
    public function contarCasosEstatusFecha($desde = 'null', $hasta = 'null', $id_estado = 'null')
    {
        $db = \Config\Database::connect();
        $builder = $db->table('sgc_estatus AS est');
        
        // El SELECT usa COALESCE para mostrar 0 si no hay casos para ese estatus después del LEFT JOIN
        $builder->select('est.idest, est.estnom, COALESCE(SUM(casos_totales.count), 0) AS count');

        // --- 1. Construcción de la Subconsulta (Conteo total por estatus con filtros) ---
        $subQuery = $db->table('sgc_casos AS c')
            // Seleccionamos solo el campo de unión (idest) y el conteo
            ->select('c.idest, COUNT(c.idest) AS count');

        // **Filtro Clave:** Excluir casos borrados
        $subQuery->where('c.borrado', false); 
        // También puedes usar: ->where('LOWER(TRIM(c.borrado))', 'false'); si el tipo de dato es un texto que almacena 'true'/'false'

        // 2. Aplicar filtros de fecha de forma segura
        if ($desde !== 'null' && $hasta !== 'null') {
            $subQuery->where('c.casofec >=', $desde);
            $subQuery->where('c.casofec <=', $hasta);
        }
        
        // 3. Aplicar filtro de estado
        if ($id_estado !== 'null' && $id_estado !== null) {
            $subQuery->where('c.estadoid', $id_estado);
        }
        
        // **Agrupar SOLAMENTE por el campo de unión (idest)**
        $subQuery->groupBy('c.idest');
        
        // Compilar la subconsulta
        $subQueryString = $subQuery->getCompiledSelect();
        
        // --- 2. JOIN con la consulta principal ---
        // Hacemos LEFT JOIN para que todos los Estatus aparezcan.
        $builder->join("($subQueryString) AS casos_totales", 'est.idest = casos_totales.idest', 'left');
        
        // El GROUP BY de la consulta principal está bien (agrupa por el Estatus)
        $builder->groupBy('est.idest, est.estnom');
        $builder->orderBy('est.estnom', 'ASC');
        
        $query = $builder->get();
        
        // La instrucción `echo $db->getLastQuery(); die();` no se incluye en el resultado final,
        // pero puedes descomentarla para depurar la consulta generada.
        
        return $query->getResult();
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
    $builder = $db->table('public.sgc_tipo_beneficiarios AS tb');
    $builder->select('COALESCE(COUNT(c.tipo_beneficiario), 0) AS count, tb.tipo_beneficiario_nombre');
    $builder->join('public.sgc_casos AS c', 'c.tipo_beneficiario = tb.tipo_beneficiario_id', 'right');
    
   
    $builder->groupStart();
    $builder->where('c.borrado', false);
    if ($desde != 'null' && $hasta != 'null') {
        $builder->where('c.casofec >=', $desde);
        $builder->where('c.casofec <=', $hasta);
    }
    if ($id_estado != 'null' && $id_estado != null) {
        $builder->where('c.estadoid', $id_estado);
    }
    $builder->groupEnd();
    
   
    
    // Esta condición se aplica a la tabla de beneficiarios
    $builder->where('tb.tipo_beneficiario_borrado', false);
    
    $builder->groupBy('tb.tipo_beneficiario_nombre');
    $builder->orderBy('tb.tipo_beneficiario_nombre', 'ASC');
   
    $query = $builder->get();
    // echo $db->getLastQuery(); 
    //die();
    $resultado = $query->getResult();
    return $resultado;
}


    /**
 * Cuenta los Casos agrupados por Tipo de Beneficiario (tb) aplicando filtros de fecha y estado.
 *
 * @param string $desde Fecha de inicio (puede ser 'null' como string).
 * @param string $hasta Fecha de fin (puede ser 'null' como string).
 * @param string|int $id_estado ID del estado del caso, o 'null' como string si no se filtra.
 * @return array Retorna un array de objetos con el conteo por tipo de beneficiario.
 */
public function contarCasos_Tipo_Beneficiario_fecha($desde = 'null', $hasta = 'null', $id_estado = 'null')
{

   
    $db = \Config\Database::connect();
    $builder = $db->table('sgc_tipo_beneficiarios AS tb');
    
    // El SELECT ya está bien: COALESCE(SUM)
    $builder->select('tb.tipo_beneficiario_id, tb.tipo_beneficiario_nombre, COALESCE(SUM(casos_totales.count), 0) AS total_fecha_tipo, COALESCE(SUM(casos_totales.count), 0) AS count');

    // --- 1. Construcción de la Subconsulta (Conteo total por beneficiario) ---
    $subQuery = $db->table('sgc_casos AS c')
        // Seleccionamos solo el campo de unión y el conteo
        ->select('c.tipo_beneficiario, COUNT(c.tipo_beneficiario) AS count');

    // **CORRECCIÓN CLAVE 1:** Excluir casos borrados
    $subQuery->where('c.borrado', false); 

    // 2. Aplicar filtros de fecha de forma segura
    if ($desde !== 'null' && $hasta !== 'null') {
        $subQuery->where('c.casofec >=', $desde);
        $subQuery->where('c.casofec <=', $hasta);
    }
    
    // 3. Aplicar filtro de estado
    if ($id_estado !== 'null' && $id_estado !== null) {
        $subQuery->where('c.estadoid', $id_estado);
    }
    
    // **CORRECCIÓN CLAVE 2:** Agrupar SOLAMENTE por el campo de unión (tipo_beneficiario)
    // No necesitamos agrupar por casofec si luego vamos a SUMAR todos los conteos.
    $subQuery->groupBy('c.tipo_beneficiario');
    
    $subQueryString = $subQuery->getCompiledSelect();
    
    // --- 2. JOIN con la consulta principal ---
    // Cambiado el alias a 'casos_totales' para reflejar que contiene el conteo total por tipo
    $builder->join("($subQueryString) AS casos_totales", 'tb.tipo_beneficiario_id = casos_totales.tipo_beneficiario', 'left');
    
    // El GROUP BY de la consulta principal está bien (agrupa por el tipo de beneficiario)
    $builder->groupBy('tb.tipo_beneficiario_id, tb.tipo_beneficiario_nombre');
    $builder->orderBy('tb.tipo_beneficiario_nombre', 'ASC');
    
    $query = $builder->get();
   
    return $query->getResult();
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
            ->where('c.borrado', false);
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
            ->where('c.borrado', false);
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
        $builder->where('c.borrado', false);
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
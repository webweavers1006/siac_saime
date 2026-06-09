<?php namespace App\Models;

class Mapa_Ayuda_Model extends BaseModel{



public function Listar_Casos_Ayuda()
{
    $db = \Config\Database::connect();
    $builder = $db->table('sgc_casos AS c');

    // Selecciona explícitamente todas las columnas, usando ALIAS entendibles.
    $builder->select([
        // 🔹 CAMPOS PRINCIPALES (sgc_casos)
        'c.idcaso AS id_caso', 
        'c.casofec AS fecha_caso', 
        'c.casoced AS cedula_solicitante', 
        'c.casonom AS nombre_solicitante', 
        'c.casoape AS apellido_solicitante', 
        'c.casotel AS telefono_solicitante',
        'c.casonumsol AS numero_solicitud', 
        'c.idest AS id_estatus', 
        'c.idrrss AS id_rrss', 
        'c.idusuopr AS id_usuario_operador', 
        'c.estadoid AS id_estado', 
        'c.municipioid AS id_municipio',
        'c.parroquiaid AS id_parroquia', 
        'c.ofiid AS id_oficina', 
        'c.casodesc AS descripcion_caso', 
        'c.id_tipo_atencion AS id_tipo_atencion_fk', 
        'c.sexo AS sexo_solicitante',
        'c.caso_nacionalidad AS nacionalidad_caso', 
        'c.borrado AS caso_borrado', 
        'c.tipo_beneficiario AS tipo_beneficiario', 
        'c.direccion AS direccion_caso',
        'c.correo AS correo_solicitante', 
        'c.ente_adscrito_id AS id_ente_adscrito', 
        'c.caso_hora AS hora_caso', 
        'c.edad AS edad_solicitante', 
        'c.fecha_nacimiento AS fecha_nacimiento',
        'c.profesion AS profesion_solicitante', 
        'c.tipo_atend_id AS id_tipo_atencion_detalle', 
        'c.pais AS id_pais', 
        'c.caso_org_id AS id_organizacion_caso',
        
        // 🌐 CAMPOS GEOGRÁFICOS
        'p.paisnom AS nombre_pais',       
        'e.estadonom AS nombre_estado',         
        'm.municipionom AS nombre_municipio',      
        'pqt.parroquianom AS nombre_parroquia',
        
        // 📍 COORDENADAS
        'coor.id_coord AS id_coordenada', 
        'coor.nombre AS nombre_coordenada', 
        'coor.latitud AS latitud_caso', 
        'coor.longitud AS longitud_caso', 
        'coor.fecha_creacion AS fecha_coordenada',
        
        // 📋 DETALLE Y DOCUMENTOS DEL CASO
        't_usu.tipo_aten_nombre AS nombre_tipo_atencion',
        'deta.tipo_atend_nombre AS nombre_tipo_atencion_detalle', 
        'docu.docu_ruta AS ruta_documento', 

        // 💰 CAMPOS DEL PUNTO DE CUENTA
        'pc.id AS id_punto_de_cuenta', 
        'pc.nombre AS pc_nombre_beneficiario', 
        'pc.apellido AS pc_apellido_beneficiario', 
        'pc.monto_aprobado AS pc_monto_aprobado', 
        'pc.causa_beneficio AS pc_causa_beneficio',
        
        // 📄 NUEVOS CAMPOS: DOCUMENTOS DEL PUNTO DE CUENTA
        'docu_pc.docu_ruta AS pc_ruta_documento', // Ruta del documento del punto de cuenta
        'docu_pc.docu_descripcion AS pc_descripcion_documento' // Descripción del documento del punto de cuenta
    ]);

    // Uniones existentes (sin cambios)
    $builder->join('sgc_documentos_casos AS docu', 'c.idcaso = docu.docu_id_caso', 'left');
    $builder->join('sgc_tipoatencion_usu AS t_usu', 'c.id_tipo_atencion = t_usu.tipo_aten_id', 'left');
    $builder->join('sgc_casos_coordenadas AS coor', 'c.idcaso = coor.idcaso', 'left'); 
    $builder->join('sgc_tipoatenciondetalle AS deta', 'c.tipo_atend_id = deta.tipo_atend_id', 'left');

    // Uniones a las tablas geográficas
    $builder->join('sgc_paises AS p', 'p.paisid = c.pais', 'left');
    $builder->join('sgc_estados AS e', 'e.estadoid = c.estadoid', 'left');
    $builder->join('sgc_municipio AS m', 'm.municipioid = c.municipioid', 'left');
    $builder->join('sgc_parroquias AS pqt', 'pqt.parroquiaid = c.parroquiaid', 'left');
    
    // Uniones del Punto de Cuenta (ccpc y pc)
    $builder->join('sgc_caso_punto_cuenta AS ccpc', 
                   'c.idcaso = ccpc.id_caso AND ccpc.borrado = FALSE', 
                   'left', 
                   FALSE); 

    $builder->join('sgc_punto_cuenta AS pc', 
                   'ccpc.id_punto_cuenta = pc.id AND pc.borrado = FALSE', 
                   'left', 
                   FALSE); 
                   
    // 🆕 NUEVA UNIÓN: Documentos del Punto de Cuenta (docu_pc)
    // Se relaciona desde pc.id hasta docu_pc.docu_id_punto_cuenta
    $builder->join('sgc_documentos_punto_cuenta AS docu_pc',
                   'pc.id = docu_pc.docu_id_punto_cuenta',
                   'left');

    // Condiciones WHERE originales (sin cambios)
    $builder->where('c.borrado', FALSE);
    $builder->where('t_usu.act_coordenadas', TRUE);
    $builder->where('coor.borrado', FALSE); 

    $query = $builder->get();
 
    return $query->getResultArray();
}
public function buscar_caso_cordenada($idcaso=null)
{
  
    $db = \Config\Database::connect();
    $builder = $db->table('sgc_casos AS c');

    // Selecciona explícitamente las columnas para evitar conflictos y ambigüedad.
    $builder->select([
   
        'coor.id_coord', 'coor.nombre', 'coor.latitud', 'coor.longitud', 'coor.fecha_creacion'
    ]);

    // Las uniones ahora tienen el 'left' como tercer parámetro.
    $builder->join('sgc_documentos_casos AS docu', 'c.idcaso = docu.docu_id_caso', 'left');
    $builder->join('sgc_tipoatencion_usu AS t_usu', 'c.id_tipo_atencion = t_usu.tipo_aten_id', 'left');
    $builder->join('sgc_casos_coordenadas AS coor', 'c.idcaso = coor.idcaso', 'left');

    $builder->where('c.borrado', FALSE);
    $builder->where('t_usu.act_coordenadas', TRUE);
     $builder->where('coor.idcaso', $idcaso);

    $query = $builder->get();

     //echo $db->getLastQuery(); 
    return $query->getResultArray();
}

}


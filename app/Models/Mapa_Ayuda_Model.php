<?php namespace App\Models;

class Mapa_Ayuda_Model extends BaseModel{





	// Método para listar tipos de estatus
public function Listar_Casos_Ayuda()
{
    $db = \Config\Database::connect();
    $builder = $db->table('sgc_casos AS c');

    // Selecciona explícitamente todas las columnas, usando los nombres geográficos confirmados.
    $builder->select([
        'c.idcaso', 'c.casofec', 'c.casoced', 'c.casonom', 'c.casoape', 'c.casotel',
        'c.casonumsol', 'c.idest', 'c.idrrss', 'c.idusuopr', 'c.estadoid', 'c.municipioid',
        'c.parroquiaid', 'c.ofiid', 'c.casodesc', 'c.id_tipo_atencion', 'c.sexo',
        'c.caso_nacionalidad', 'c.borrado', 'c.tipo_beneficiario', 'c.direccion',
        'c.correo', 'c.ente_adscrito_id', 'c.caso_hora', 'c.edad', 'c.fecha_nacimiento',
        'c.profesion', 'c.tipo_atend_id', 'c.pais', 'c.caso_org_id',
        'coor.id_coord', 'coor.nombre', 'coor.latitud', 'coor.longitud', 'coor.fecha_creacion',
        'deta.tipo_atend_nombre',

        // 🎯 NOMBRES DE CAMPOS GEOGRÁFICOS CORREGIDOS SEGÚN TU ESPECIFICACIÓN
        'p.paisnom AS nombre_pais',       
        'e.estadonom AS nombre_estado',         
        'm.municipionom AS nombre_municipio',      
        'pqt.parroquianom AS nombre_parroquia'     
    ]);

    // Uniones existentes
    $builder->join('sgc_documentos_casos AS docu', 'c.idcaso = docu.docu_id_caso', 'left');
    $builder->join('sgc_tipoatencion_usu AS t_usu', 'c.id_tipo_atencion = t_usu.tipo_aten_id', 'left');
    $builder->join('sgc_casos_coordenadas AS coor', 'c.idcaso = coor.idcaso', 'left');
    $builder->join('sgc_tipoatenciondetalle AS deta', 'c.tipo_atend_id = deta.tipo_atend_id', 'left');

    // 🔗 Uniones a las tablas geográficas (se mantienen igual)
    $builder->join('sgc_paises AS p', 'p.paisid = c.pais', 'left');
    $builder->join('sgc_estados AS e', 'e.estadoid = c.estadoid', 'left');
    $builder->join('sgc_municipio AS m', 'm.municipioid = c.municipioid', 'left');
    $builder->join('sgc_parroquias AS pqt', 'pqt.parroquiaid = c.parroquiaid', 'left');

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


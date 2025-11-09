<?php

namespace App\Models;

use App\Models\BaseModel;

class Mediacion extends BaseModel
{
    protected $table = 'sgc_mediacion';
    protected $primaryKey = 'med_id'; // Debes verificar el nombre real de tu PK
    
    protected $allowedFields = [
        'med_caso_id',
        'med_apo_sol_id',
        'med_contra_id',
        'med_apo_contra_id' 
    ];

/*
       FUNCION PARA OBTENER LOS PARTICIPANTES DE MEDIACION EN FUNCION DEL CASO
    */
 public function buscar_Info_Mediacion($idcaso)
{
    $builder = $this->builder();

    // 1. SELECT con todos los campos, incluyendo los nombres geográficos
    $builder->select('
        m.*,

        -- Datos del Apoderado Solicitante (ter_sol)
        ter_sol.ter_nombre AS nombre_apo_sol,
        ter_sol.ter_identificacion AS id_apo_sol,
        ter_sol.ter_tipo_per AS tipo_per_apo_sol,
        ter_sol.ter_correo AS correo_apo_sol,
        ter_sol.ter_telefono AS telefono_apo_sol,
        ter_sol.ter_pais AS pais_id_apo_sol,
        pais_sol.paisnom AS pais_apo_sol,  
        ter_sol.ter_estado AS estado_id_apo_sol,
        estado_sol.estadonom AS estado_apo_sol, 
        ter_sol.ter_municipio AS municipio_id_apo_sol,
        municipio_sol.municipionom AS municipio_apo_sol, 
        ter_sol.ter_parroquia AS parroquia_id_apo_sol,
        parroquia_sol.parroquianom AS parroquia_apo_sol, 
        ter_sol.ter_direccion AS direccion_apo_sol,
        ter_sol.ter_impre_abogado AS impre_abogado_apo_sol,

        -- Datos de la Contraparte (ter_contra)
        ter_contra.ter_nombre AS nombre_contra,
        ter_contra.ter_identificacion AS id_contra,
        ter_contra.ter_tipo_per AS tipo_per_contra,
        ter_contra.ter_correo AS correo_contra,
        ter_contra.ter_telefono AS telefono_contra,
        ter_contra.ter_pais AS pais_id_contra,
        pais_contra.paisnom AS pais_contra, 
        ter_contra.ter_estado AS estado_id_contra,
        estado_contra.estadonom AS estado_contra,
        ter_contra.ter_municipio AS municipio_id_contra,
        municipio_contra.municipionom AS municipio_contra, 
        ter_contra.ter_parroquia AS parroquia_id_contra,
        parroquia_contra.parroquianom AS parroquia_contra, 
        ter_contra.ter_direccion AS direccion_contra,
        ter_contra.ter_impre_abogado AS impre_abogado_contra,

        -- Datos del Apoderado Contraparte (ter_apo_contra)
        ter_apo_contra.ter_nombre AS nombre_apo_contra,
        ter_apo_contra.ter_identificacion AS id_apo_contra,
        ter_apo_contra.ter_tipo_per AS tipo_per_apo_contra,
        ter_apo_contra.ter_correo AS correo_apo_contra,
        ter_apo_contra.ter_telefono AS telefono_apo_contra,
        ter_apo_contra.ter_pais AS pais_id_apo_contra,
        pais_apo_contra.paisnom AS pais_apo_contra, 
        ter_apo_contra.ter_estado AS estado_id_apo_contra,
        estado_apo_contra.estadonom AS estado_apo_contra,
        ter_apo_contra.ter_municipio AS municipio_id_apo_contra,
        municipio_apo_contra.municipionom AS municipio_apo_contra, 
        ter_apo_contra.ter_parroquia AS parroquia_id_apo_contra,
        parroquia_apo_contra.parroquianom AS parroquia_apo_contra, 
        ter_apo_contra.ter_direccion AS direccion_apo_contra,
        ter_apo_contra.ter_impre_abogado AS impre_abogado_apo_contra
    ');

    // 🚨 Solución a la duplicación
    $builder->distinct();

    // Alias para la tabla principal
    $builder->from($this->table . ' m');

    // --- JOINS para el Apoderado Solicitante (ter_sol) ---
    $builder->join('sgc_terceros ter_sol', 'ter_sol.ter_id = m.med_apo_sol_id', 'left');
    $builder->join('sgc_paises pais_sol', 'pais_sol.paisid = ter_sol.ter_pais', 'left');
    $builder->join('sgc_estados estado_sol', 'estado_sol.estadoid = ter_sol.ter_estado', 'left');
    $builder->join('sgc_municipio municipio_sol', 'municipio_sol.municipioid = ter_sol.ter_municipio', 'left');
    $builder->join('sgc_parroquias parroquia_sol', 'parroquia_sol.parroquiaid = ter_sol.ter_parroquia', 'left');

    // --- JOINS para la Contraparte (ter_contra) ---
    $builder->join('sgc_terceros ter_contra', 'ter_contra.ter_id = m.med_contra_id', 'left');
    $builder->join('sgc_paises pais_contra', 'pais_contra.paisid = ter_contra.ter_pais', 'left');
    $builder->join('sgc_estados estado_contra', 'estado_contra.estadoid = ter_contra.ter_estado', 'left');
    $builder->join('sgc_municipio municipio_contra', 'municipio_contra.municipioid = ter_contra.ter_municipio', 'left');
    $builder->join('sgc_parroquias parroquia_contra', 'parroquia_contra.parroquiaid = ter_contra.ter_parroquia', 'left');

    // --- JOINS para el Apoderado Contraparte (ter_apo_contra) ---
    $builder->join('sgc_terceros ter_apo_contra', 'ter_apo_contra.ter_id = m.med_apo_contra_id', 'left');
    $builder->join('sgc_paises pais_apo_contra', 'pais_apo_contra.paisid = ter_apo_contra.ter_pais', 'left');
    $builder->join('sgc_estados estado_apo_contra', 'estado_apo_contra.estadoid = ter_apo_contra.ter_estado', 'left');
    $builder->join('sgc_municipio municipio_apo_contra', 'municipio_apo_contra.municipioid = ter_apo_contra.ter_municipio', 'left');
    $builder->join('sgc_parroquias parroquia_apo_contra', 'parroquia_apo_contra.parroquiaid = ter_apo_contra.ter_parroquia', 'left');

    // 5. Condición WHERE para filtrar por el caso
    $builder->where('m.med_caso_id', $idcaso);

    $query = $builder->get();
    return $query->getResult();
}


}


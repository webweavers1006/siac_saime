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
    
    // 1. SELECT con todos los campos, incluyendo los nuevos de IMPRE
    $builder->select('
        m.*, 
        
        -- Datos del Apoderado Solicitante (ter_sol)
        ter_sol.ter_nombre AS nombre_apo_sol, 
        ter_sol.ter_identificacion AS id_apo_sol,
        ter_sol.ter_tipo_per AS tipo_per_apo_sol,
        ter_sol.ter_correo AS correo_apo_sol,
        ter_sol.ter_telefono AS telefono_apo_sol,
        ter_sol.ter_pais AS pais_apo_sol, 
        ter_sol.ter_estado AS estado_apo_sol, 
        ter_sol.ter_municipio AS municipio_apo_sol, 
        ter_sol.ter_parroquia AS parroquia_apo_sol,
        ter_sol.ter_direccion AS direccion_apo_sol,
        ter_sol.ter_impre_abogado AS impre_abogado_apo_sol,  
        
        -- Datos de la Contraparte (ter_contra)
        ter_contra.ter_nombre AS nombre_contra,
        ter_contra.ter_identificacion AS id_contra,
        ter_contra.ter_tipo_per AS tipo_per_contra,
        ter_contra.ter_correo AS correo_contra,
        ter_contra.ter_telefono AS telefono_contra,
        ter_contra.ter_pais AS pais_contra, 
        ter_contra.ter_estado AS estado_contra, 
        ter_contra.ter_municipio AS municipio_contra, 
        ter_contra.ter_parroquia AS parroquia_contra,
        ter_contra.ter_direccion AS direccion_contra,
        ter_contra.ter_impre_abogado AS impre_abogado_contra, 
        
        -- Datos del Apoderado Contraparte (ter_apo_contra)
        ter_apo_contra.ter_nombre AS nombre_apo_contra,
        ter_apo_contra.ter_identificacion AS id_apo_contra,
        ter_apo_contra.ter_tipo_per AS tipo_per_apo_contra,
        ter_apo_contra.ter_correo AS correo_apo_contra,
        ter_apo_contra.ter_telefono AS telefono_apo_contra,
        ter_apo_contra.ter_pais AS pais_apo_contra, 
        ter_apo_contra.ter_estado AS estado_apo_contra, 
        ter_apo_contra.ter_municipio AS municipio_apo_contra, 
        ter_apo_contra.ter_parroquia AS parroquia_apo_contra,
        ter_apo_contra.ter_direccion AS direccion_apo_contra,
        ter_apo_contra.ter_impre_abogado AS impre_abogado_apo_contra  
    ');
    
    // 🚨 Solución a la duplicación
    $builder->distinct(); 

    // Alias para la tabla principal
    $builder->from($this->table . ' m'); 

    // 2. JOIN para el Apoderado Solicitante (si existe)
    $builder->join('sgc_terceros ter_sol', 'ter_sol.ter_id = m.med_apo_sol_id', 'left');
    
    // 3. JOIN para la Contraparte (si existe)
    $builder->join('sgc_terceros ter_contra', 'ter_contra.ter_id = m.med_contra_id', 'left');
    
    // 4. JOIN para el Apoderado Contraparte (si existe)
    $builder->join('sgc_terceros ter_apo_contra', 'ter_apo_contra.ter_id = m.med_apo_contra_id', 'left');
    
    // 5. Condición WHERE para filtrar por el caso
    $builder->where('m.med_caso_id', $idcaso);
    
    $query = $builder->get();
    return $query->getResult();
}


}


<?php

namespace App\Models;

use CodeIgniter\Model;

class Organismo_pp_Model extends BaseModel
{
    //     public function listar_Red_Social()
    // {
    //     $db = \Config\Database::connect();
    //     $builder = $db->table('sgc_org_pod_popular');
    //     $builder->select('red_s_id, red_s_nom');
    //     $builder->where('red_s_borrado', false);
    //     $query = $builder->get();
    //     $resultado = $query->getResult();
    //     return $resultado;
    // }



    //Metodo para insertar un ORGANISMO
    public function add_organismo($organismo)
    {
        $builder = $this->dbconn("sgc_org_pod_popular");
        $query = $builder->insert($organismo);
        return $query;
    }

     //Metodo para actualizar una Direccion Administrativa
     public function edit_organimo_pp($organismo)
     {
         $builder = $this->dbconn("sgc_org_pod_popular");
         $query = $builder->update($organismo, 'org_id = ' . $organismo["org_id"]);
         return $query;
     }

    /**
	 * Obtiene la lista de organismos que sin filtros .
	*/
    public function Listar_organismo_pp()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('public.sgc_org_pod_popular');
        $builder->select('org_id, org_nombre, CASE WHEN org_borrado = \'f\' THEN \'Activo\' ELSE \'Inactivo\' END AS borrado');
        //$builder->where('org_borrado', false);
        $query = $builder->get();
        $resultado = $query->getResult();
        return $resultado;
    }

    /**
	 * Obtiene la lista de organismos que no estee borrados .
	 */
     public function Listar_Organismo_PP_filtro()
    {


        $db = \Config\Database::connect();
        $builder = $db->table('public.sgc_org_pod_popular');
        $builder->select('org_id, org_nombre, CASE WHEN org_borrado = \'f\' THEN \'Activo\' ELSE \'Inactivo\' END AS borrado');
        $builder->where('org_borrado', false);
        $query = $builder->get();
        $resultado = $query->getResult();
        return $resultado;

    }
    
    //     public function buscar_formacion_red_social($id_red_social = null)
    // {
    //     $db = \Config\Database::connect();
    //     $builder = $db->table('public.sgc_org_pod_popular');
    //     $builder->select('acc_formacion');
    //     $builder->where('red_s_borrado', false);
    //     $builder->where('red_s_id !=', 3);
    //     if ($id_red_social) {
    //         $builder->where('red_s_id', $id_red_social);
    //     }
    //     $query = $builder->get();
    //     return $query->getResult();
    // }

    // // Buscar hijos vía atención
    // public function buscar_hijos_via_atencion($id_Via_Atencion = null)
    // {
    //     $db = \Config\Database::connect();
    //     $builder = $db->table('public.sgc_via_tipo_atencion');
    //     $builder->where('borrado', false);
    //     if ($id_Via_Atencion !== null) {
    //         $builder->where('via_atencion_id', $id_Via_Atencion);
    //     }
    //     $query = $builder->get();
    //     return $query->getResult(); 
    // }


}

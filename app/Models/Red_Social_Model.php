<?php

namespace App\Models;

use CodeIgniter\Model;

class Red_Social_Model extends BaseModel
{
        public function listar_Red_Social()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('sgc_red_social');
        $builder->select('red_s_id, red_s_nom');
        $builder->where('red_s_borrado', false);
        $query = $builder->get();
        $resultado = $query->getResult();
        return $resultado;
    }



    //Metodo para insertar una Direccion Administrativa
    public function add_ViaAtencion($atencion)
    {
        $builder = $this->dbconn("sgc_red_social");
        $query = $builder->insert($atencion);
        return $query;
    }

     //Metodo para actualizar una Direccion Administrativa
     public function editViaAtencion($atencion)
     {
         $builder = $this->dbconn("sgc_red_social");
         $query = $builder->update($atencion, 'red_s_id = ' . $atencion["red_s_id"]);
         return $query;
     }

    // Método que lista las vías de atención
    public function Listar_Via_Atencion()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('public.sgc_red_social');
        $builder->select('red_s_id, red_s_nom, CASE WHEN red_s_borrado = \'f\' THEN \'Activo\' ELSE \'Inactivo\' END AS borrado');
        $builder->where('red_s_borrado', false);
        $query = $builder->get();
        $resultado = $query->getResult();
        return $resultado;
    }
    public function listar_Red_Social_filtro()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('public.sgc_red_social');
        $builder->select('red_s_id', 'red_s_nom');
        $builder->where('red_s_borrado', false);
        $builder->where('red_s_id !=', 3);
        $query = $builder->get();
        return $query->getResult();
    }
    
        public function buscar_formacion_red_social($id_red_social = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('public.sgc_red_social');
        $builder->select('acc_formacion');
        $builder->where('red_s_borrado', false);
        $builder->where('red_s_id !=', 3);
        if ($id_red_social) {
            $builder->where('red_s_id', $id_red_social);
        }
        $query = $builder->get();
        return $query->getResult();
    }

    // Buscar hijos vía atención
    public function buscar_hijos_via_atencion($id_Via_Atencion = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('public.sgc_via_tipo_atencion');
        $builder->where('borrado', false);
        if ($id_Via_Atencion !== null) {
            $builder->where('via_atencion_id', $id_Via_Atencion);
        }
        $query = $builder->get();
        return $query->getResult(); 
    }


}

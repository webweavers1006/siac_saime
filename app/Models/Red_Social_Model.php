<?php

namespace App\Models;

use CodeIgniter\Model;

class Red_Social_Model extends BaseModel
{
    public function listar_Red_Social()
    {
        $db      = \Config\Database::connect();
        $strQuery = "SELECT red_s_id,red_s_nom ";
        $strQuery .= "FROM public.sgc_red_social  WHERE red_s_borrado='false' ";
        $query = $db->query($strQuery);
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

    public function Listar_Via_Atencion()
    {
        $db      = \Config\Database::connect();
        $strQuery = "SELECT red_s_id,red_s_nom,case when red_s_borrado='f' then 'Activo' else 'Inactivo' end as borrado ";
        $strQuery .= "FROM public.sgc_red_social  WHERE red_s_borrado='false' ";
        $query = $db->query($strQuery);
        $resultado = $query->getResult();
        return $resultado;
    }
    public function listar_Red_Social_filtro()
    {
        $db      = \Config\Database::connect();
        $strQuery = "SELECT red_s_id,red_s_nom ";
        $strQuery .= "FROM public.sgc_red_social  WHERE red_s_borrado='false' and red_s_id <> '3'";
        $query = $db->query($strQuery);
        $resultado = $query->getResult();
        return $resultado;
    }
    
    public function buscar_formacion_red_social($id_red_social=null)
    {

        $db      = \Config\Database::connect();
        $strQuery = "SELECT acc_formacion ";
        $strQuery .= "FROM public.sgc_red_social  WHERE red_s_borrado='false' and red_s_id <> '3'";
        $strQuery .= " AND red_s_id = '$id_red_social'";
        $query = $db->query($strQuery);
        $resultado = $query->getResult();
        return $resultado;
    }

    public function buscar_hijos_via_atencion($id_Via_Atencion=null)
    {

        $db      = \Config\Database::connect();
        $strQuery = "SELECT * ";
        $strQuery .= "FROM public.sgc_via_tipo_atencion  WHERE borrado='false' ";
        $strQuery .= " AND via_atencion_id = '$id_Via_Atencion'";
        $query = $db->query($strQuery);
        $resultado = $query->getResult();
        return $resultado;
    }



}

<?php

namespace App\Models;

use CodeIgniter\Model;

class Tipo_Atencion_Detalle_Model extends BaseModel
{


    //Metodo para insertar una Direccion Administrativa
    public function add_detalle($detalle)
    {
        $builder = $this->dbconn("sgc_tipoatenciondetalle");
        $query = $builder->insert($detalle);
        return $query;
    }

    //Metodo para actualizar una Direccion Administrativa
    public function editDetalle_Atencion($detalle)
    {
        $builder = $this->dbconn("sgc_tipoatenciondetalle");
        $query = $builder->update($detalle, 'tipo_atend_id = ' . $detalle["tipo_atend_id"]);
        return $query;
    }


    public function Listar_Detalle_Atencion()
    {
        $db      = \Config\Database::connect();
        $strQuery = "SELECT d.tipo_atend_id,d.tipo_atend_nombre,tipo_aten.tipo_aten_nombre as tipo_atencion,d.tipo_aten_id,case when d.tipo_atend_borrado='f' then 'Activo' else 'Inactivo' end as tipo_atend_borrado  ";
        $strQuery .= "FROM public.sgc_tipoatenciondetalle as d  ";
        $strQuery .= "join sgc_tipoatencion_usu as tipo_aten on d.tipo_aten_id=tipo_aten.tipo_aten_id ";
        $query = $db->query($strQuery);
        $resultado = $query->getResult();
        return $resultado;
    }

    public function Listar_Detalle_Atencion_filtro()
    {
        $db      = \Config\Database::connect();
        $strQuery = "SELECT d.tipo_atend_id,d.tipo_atend_nombre,tipo_aten.tipo_aten_nombre as tipo_atencion,d.tipo_aten_id,case when d.tipo_atend_borrado='f' then 'Activo' else 'Inactivo' end as tipo_atend_borrado  ";
        $strQuery .= "FROM public.sgc_tipoatenciondetalle as d  ";
        $strQuery .= "join sgc_tipoatencion_usu as tipo_aten on d.tipo_aten_id=tipo_aten.tipo_aten_id ";
        $strQuery .= "where d.tipo_atend_borrado='false'  ";
        $query = $db->query($strQuery);
        $resultado = $query->getResult();
        return $resultado;
    }
    public function buscar_hijos_detalle_atencion($id_tipo_atencion=null)
    {
        $db      = \Config\Database::connect();
        $strQuery = "SELECT d.tipo_atend_id,d.tipo_atend_nombre,d.tipo_aten_id,case when d.tipo_atend_borrado='f' then 'Activo' else 'Inactivo' end as tipo_atend_borrado  ";
        $strQuery .= "FROM public.sgc_tipoatenciondetalle as d  ";
        $strQuery .= "where  d.tipo_aten_id=$id_tipo_atencion  ";
        $query = $db->query($strQuery);
        $resultado = $query->getResult();
        return $resultado;
    }
    
    
}

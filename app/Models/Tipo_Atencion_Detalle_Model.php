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
    $db = \Config\Database::connect();
    $builder = $db->table('public.sgc_tipoatenciondetalle as d');
    $builder->select('d.tipo_atend_id, d.tipo_atend_nombre, tipo_aten.tipo_aten_nombre as tipo_atencion, d.tipo_aten_id');
    $builder->select("CASE WHEN d.tipo_atend_borrado = 'f' THEN 'Activo' ELSE 'Inactivo' END as tipo_atend_borrado");
    $builder->join('sgc_tipoatencion_usu as tipo_aten', 'd.tipo_aten_id = tipo_aten.tipo_aten_id');
    $query = $builder->get();
    $resultado = $query->getResult();
    return $resultado;
}
    
public function Listar_Detalle_Atencion_filtro()
{
    $db = \Config\Database::connect();
    $builder = $db->table('public.sgc_tipoatenciondetalle as d');
    $builder->select('d.tipo_atend_id, d.tipo_atend_nombre, tipo_aten.tipo_aten_nombre as tipo_atencion, d.tipo_aten_id');
    $builder->select("CASE WHEN d.tipo_atend_borrado = 'f' THEN 'Activo' ELSE 'Inactivo' END as tipo_atend_borrado");
    $builder->join('sgc_tipoatencion_usu as tipo_aten', 'd.tipo_aten_id = tipo_aten.tipo_aten_id');
    $builder->where('d.tipo_atend_borrado', false);
    $query = $builder->get();
    $resultado = $query->getResult();
    return $resultado;
}
    
public function buscar_hijos_detalle_atencion($id_tipo_atencion = null)
{
    $db = \Config\Database::connect();
    $builder = $db->table('public.sgc_tipoatenciondetalle as d');
    $builder->select('d.tipo_atend_id, d.tipo_atend_nombre, d.tipo_aten_id');
    $builder->select("CASE WHEN d.tipo_atend_borrado = 'f' THEN 'Activo' ELSE 'Inactivo' END as tipo_atend_borrado");
    if ($id_tipo_atencion !== null) {
        $builder->where('d.tipo_aten_id', $id_tipo_atencion);
    }
    $query = $builder->get();
    $resultado = $query->getResult();
    return $resultado;
}

}

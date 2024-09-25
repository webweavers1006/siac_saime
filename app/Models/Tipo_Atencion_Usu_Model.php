<?php

namespace App\Models;

use CodeIgniter\Model;

class Tipo_Atencion_Usu_Model extends BaseModel
{


    //Metodo para insertar una Direccion Administrativa
    public function add_Atencion($atencion)
    {
        $builder = $this->dbconn("sgc_tipoatencion_usu");
        $query = $builder->insert($atencion);
        return $query;
    }

    //Metodo para actualizar una Direccion Administrativa
    public function editTipoAtencion($atencion)
    {
        $builder = $this->dbconn("sgc_tipoatencion_usu");
        $query = $builder->update($atencion, 'tipo_aten_id = ' . $atencion["tipo_aten_id"]);
        return $query;
    }




    public function Listar_Tipo_Atencion_filtro()
    {
        $db      = \Config\Database::connect();
        $strQuery = "SELECT a_usu.tipo_aten_id,a_usu.tipo_aten_nombre,case when a_usu.tipo_aten_borrado='f' then 'Activo' else 'Inactivo' end as borrado  ";
        $strQuery .= "FROM public.sgc_tipoatencion_usu as a_usu WHERE a_usu.tipo_aten_borrado='false' ";
        $query = $db->query($strQuery);
        $resultado = $query->getResult();
        return $resultado;
    }


    public function Listar_Tipo_Atencion_edit()
    {
        $db      = \Config\Database::connect();
        $strQuery = "SELECT a_usu.tipo_aten_id,a_usu.tipo_aten_nombre,case when a_usu.tipo_aten_borrado='f' then 'Activo' else 'Inactivo' end as borrado  ";
        $strQuery .= "FROM public.sgc_tipoatencion_usu as a_usu  ";
        $query = $db->query($strQuery);
        $resultado = $query->getResult();
        return $resultado;
    }
}

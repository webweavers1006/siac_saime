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




    public function Listar_Tipo_Atencion_act_coordenadas($idTipoAtencion=null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('public.sgc_tipoatencion_usu as a_usu');    
        $builder->select('a_usu.act_punto_cuenta,a_usu.act_coordenadas, a_usu.act_pro_int, a_usu.tipo_aten_id, a_usu.tipo_aten_nombre');
        $builder->select("CASE WHEN a_usu.tipo_aten_borrado = 'f' THEN 'Activo' ELSE 'Inactivo' END as borrado");
        $builder->where('a_usu.tipo_aten_id', $idTipoAtencion);
        $query = $builder->get();
        $resultado = $query->getResult();
        return $resultado;
    }


    public function Listar_Tipo_Atencion_filtro()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('public.sgc_tipoatencion_usu as a_usu');
        $builder->select('a_usu.act_punto_cuenta,a_usu.act_pro_int,a_usu.act_coordenadas,a_usu.tipo_aten_id, a_usu.tipo_aten_nombre');
        $builder->select("CASE WHEN a_usu.tipo_aten_borrado = 'f' THEN 'Activo' ELSE 'Inactivo' END as borrado");
        $builder->where('a_usu.tipo_aten_borrado', false);
        $query = $builder->get();
        $resultado = $query->getResult();
        return $resultado;
    }

    public function Listar_Tipo_Atencion_Sin_Formacion()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('public.sgc_tipoatencion_usu as a_usu');
        $builder->select('a_usu.act_punto_cuenta,a_usu.acc_participantes,a_usu.act_coordenadas, a_usu.act_pro_int, a_usu.tipo_aten_id, a_usu.tipo_aten_nombre');
        $builder->select("CASE WHEN a_usu.tipo_aten_borrado = 'f' THEN 'Activo' ELSE 'Inactivo' END as borrado");
        $builder->where('a_usu.tipo_aten_borrado', false);
        $builder->where('a_usu.acc_formacion <>', 'true');
        $query = $builder->get();
        $resultado = $query->getResult();
        return $resultado;
    }

    public function Listar_Tipo_Atencion_edit()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('public.sgc_tipoatencion_usu as a_usu');
        $builder->select('a_usu.act_punto_cuenta,a_usu.organismo_pp,a_usu.env_correo,a_usu.act_coordenadas,a_usu.acc_participantes, a_usu.act_pro_int, a_usu.tipo_aten_id, a_usu.tipo_aten_nombre');
        $builder->select("CASE WHEN a_usu.tipo_aten_borrado = 'f' THEN 'Activo' ELSE 'Inactivo' END as borrado");
        $query = $builder->get();
        $resultado = $query->getResult();
        return $resultado;
    }

    public function acc_participantes($data)
    {
        $builder = $this->dbconn("public.sgc_tipoatencion_usu")
        ->select('*')
        ->where(['tipo_aten_id' => $data])
        ->get()
        ->getResult();
        return $builder;
    }

}

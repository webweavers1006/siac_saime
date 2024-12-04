<?php

namespace App\Models;

use CodeIgniter\Model;

class Tipo_Beneficiario_Model extends BaseModel
{


    //Metodo para insertar una Direccion Administrativa
    public function add_beneficiarios($add_beneficiarios)
    {
        $builder = $this->dbconn("sgc_tipo_beneficiarios");
        $query = $builder->insert($add_beneficiarios);
        return $query;
    }

    //Metodo para actualizar una Direccion Administrativa
    public function editTipoBeneficiario($Beneficiarios)
    {
        $builder = $this->dbconn("sgc_tipo_beneficiarios");
        $query = $builder->update($Beneficiarios, 'tipo_beneficiario_id = ' . $Beneficiarios["tipo_beneficiario_id"]);
        return $query;
    }




    public function Listar_Tipo_Beneficiarios_filtro()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('public.sgc_tipo_beneficiarios as b');
        $builder->select('b.tipo_beneficiario_id, b.tipo_beneficiario_nombre');
        $builder->select("CASE WHEN b.tipo_beneficiario_borrado = 'f' THEN 'Activo' ELSE 'Inactivo' END as borrado");
        $builder->where('b.tipo_beneficiario_borrado', false);
        $query = $builder->get();
        $resultado = $query->getResult();
        return $resultado;
    }

    public function Listar_Tipo_Beneficiarios()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('public.sgc_tipo_beneficiarios as b');
        $builder->select('b.tipo_beneficiario_id, b.tipo_beneficiario_nombre');
        $builder->select("CASE WHEN b.tipo_beneficiario_borrado = 'f' THEN 'Activo' ELSE 'Inactivo' END as borrado");
        $query = $builder->get();
        $resultado = $query->getResult();
        return $resultado;
    }
}

<?php namespace App\Models;
use CodeIgniter\Model;
class Tipo_Propiedad_Intelectual_Model extends BaseModel
{
    public function Listar_Propiedad_Intelectual()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('public.sgc_tipo_prop_intelec as p_intel');
        $builder->select('p_intel.tipo_prop_id, p_intel.tipo_prop_nombre');
        $builder->where('p_intel.tipo_prop_borrado', false);
        $query = $builder->get();
        $resultado = $query->getResult();
        return $resultado;
    }

    public function Listar_Propiedad_Intelectual_MOD()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('public.sgc_tipo_prop_intelec as p_intel');
        $builder->select('p_intel.tipo_prop_id, p_intel.tipo_prop_nombre');
        $builder->where('p_intel.tipo_prop_borrado', false);
        $builder->where('p_intel.tipo_prop_id !=', 1);
        $query = $builder->get();
        $resultado = $query->getResult();
        return $resultado;
    }


     
    }
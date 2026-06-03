<?php

namespace App\Models;

use CodeIgniter\Model;

class Motivos_Model extends BaseModel
{
    /**
     * Listar motivos activos filtrados por tipo_prop_id (Área).
     * Si $tipoPropId es null, devuelve todos.
     */
    public function listarPorArea($tipoPropId = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('public.sgc_motivos as m');
        $builder->select('m.motivo_id, m.motivo_nombre, m.tipo_prop_id');
        $builder->where('m.motivo_borrado', false);

        if ($tipoPropId !== null && $tipoPropId != '0') {
            $builder->where('m.tipo_prop_id', $tipoPropId);
        }

        $builder->orderBy('m.motivo_nombre', 'ASC');
        $query = $builder->get();
        return $query->getResult();
    }
}

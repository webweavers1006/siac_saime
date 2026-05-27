<?php

namespace App\Models;

use CodeIgniter\Model;

class LineaEstrategica extends BaseModel
{
    protected $table = 'public.sgc_linea_estrategica';

    // Listar todas (incluye borrado para mostrar estatus)
    public function listar_linea_estrategica()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('public.sgc_linea_estrategica as l');
        $builder->select('l.id, l.descripcion');
        $builder->select("CASE WHEN l.borrado = false THEN 'Activo' ELSE 'Inactivo' END as borrado_label");

        $builder->orderBy('l.id', 'DESC');
        $query = $builder->get();
        return $query->getResult();
    }

      public function listar_linea_estrategica_activos()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('public.sgc_linea_estrategica as l');
        $builder->select('l.id, l.descripcion');
        $builder->where('l.borrado', false);
        $builder->orderBy('l.id', 'ASC');
        $query = $builder->get();
        return $query->getResult();
    }




    public function add_linea_estrategica(array $data)
    {
        $builder = $this->dbconn('public.sgc_linea_estrategica');
        return $builder->insert($data);
    }

    public function edit_linea_estrategica(array $data)
    {
        $builder = $this->dbconn('public.sgc_linea_estrategica');
        return $builder->update($data, 'id = ' . (int) ($data['id'] ?? 0));
    }

    public function eliminar_logica(array $data)
    {
        $builder = $this->dbconn('public.sgc_linea_estrategica');
        $id = (int) ($data['id'] ?? 0);

        // borrado=false => ACTIVO
        // borrado=true  => INACTIVO
        return $builder->update(['borrado' => true], 'id = ' . $id);
    }

}


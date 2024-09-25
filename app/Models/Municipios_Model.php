<?php

namespace App\Models;

use CodeIgniter\Model;

class Municipios_Model extends BaseModel
{
    // FUNCION PARA OBTENER LOS MUNICIPIOS


    //Metodo para obtener los municipios por estado
    public function listar_Municipios(String $id_estado)
    {
        $builder = $this->dbconn('sgc_municipio');
        $builder->where('estadoid', $id_estado);
        $query = $builder->get();
        return $query;
    }
    //Metodo para obtener las parroquias de acuerdo al municipio
    public function listar_parroquias($id_municipio)
    {
        $builder = $this->dbconn('sgc_parroquias');
        $builder->where('municipioid', $id_municipio);
        $query = $builder->get();
        return $query;
    }
}

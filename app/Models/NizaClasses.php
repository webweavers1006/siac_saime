<?php

namespace App\Models;

class NizaClasses extends BaseModel {

    public function getAllClasses(){
        $builder = $this->dbconn('sgc_nizaClasificadores');
        $result = $builder->get();
        return $result;
    }

    public function nizaCases($data)
    {
        $builder = $this->dbconn('niza_casos');
        $query = $builder->insertBatch($data);
        return $query;

    }
}
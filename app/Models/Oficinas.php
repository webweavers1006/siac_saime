<?php 
namespace App\Models;

class Oficinas extends BaseModel{

    public function getAll(){
        $builder = $this->dbconn('sgc_oficinas');
        $query = $this->findAll();
        return $query;
    }

}
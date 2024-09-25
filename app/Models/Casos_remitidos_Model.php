<?php

namespace App\Models;

class Casos_remitidos_Model extends BaseModel
{


    //Metodo para insertar un nuevo caso en la BD
    public function remitirCaso(array $remitirCase)
    {
        $builder = $this->dbconn('sgc_casos_remitidos');
        $query = $builder->insert($remitirCase);
        return $query;
    }

 //Metodo que busca el correo del usuario en funcion del caso
 public function buscar_caso_remitido($id_caso)
 {
     $builder = $this->dbconn('public.sgc_casos_remitidos as c');
     $builder->select(
         "c.casos_id,c.idusuop,c.vigencia "
     );
     $builder->where(['c.casos_id' => $id_caso]);
     $query = $builder->get();
     return $query;
 }

 //Metodo que cambia el estatus de la vigencia del caso remitido a false
 public function actualizar_caso_remitido($actualizar_datos)
 {

   
    $builder = $this->dbconn('sgc_casos_remitidos');
    $builder->where('casos_id', $actualizar_datos['casos_id']);
    $query = $builder->update($actualizar_datos);
    return $query;



 }


    
}

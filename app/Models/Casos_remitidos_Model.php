<?php

namespace App\Models;

class Casos_remitidos_Model extends BaseModel
{


    //Metodo para insertar un nuevo caso en la BD
   // Método para insertar un nuevo caso en la BD
    public function remitirCaso(array $remitirCase)
    {
        $builder = $this->dbconn('sgc_casos_remitidos');
        return $builder->insert($remitirCase);
    }

 // Método que busca si el caso ya posee remisiones previas activas
    public function buscar_caso_remitido($id_caso)
    {
        $builder = $this->dbconn('public.sgc_casos_remitidos as c');
        $builder->select("c.casos_id, c.idusuop, c.vigencia");
        $builder->where([
            'c.casos_id' => $id_caso,
            'c.vigencia' => true // Buscamos específicamente el que está activo actualmente
        ]);
        return $builder->get();
    }

 // Método que cambia el estatus de la vigencia del caso remitido anterior a false
    public function actualizar_caso_remitido($actualizar_datos)
    {
        $builder = $this->dbconn('sgc_casos_remitidos');
        $builder->where('casos_id', $actualizar_datos['casos_id']);
        $builder->where('vigencia', true); // CORRECCIÓN: Solo desactivamos el registro que estaba activo
        return $builder->update($actualizar_datos);
    }


    
}

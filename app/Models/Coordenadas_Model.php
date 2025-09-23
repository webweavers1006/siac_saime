<?php

namespace App\Models;

class Coordenadas_Model extends BaseModel
{
   

    //Metodo para insertar un seguimiento del caso
    public function insertarCoordenadas(array $coodenadas)
   
    {
       
        $builder = $this->dbconn("sgc_casos_coordenadas");
        $query = $builder->insert($coodenadas);
        return $query;
    }

    /* //Metodo para actualizar seguimientos del caso
    public function actualizarSeguimiento(array $datosSeguimiento)
    {
        $builder = $this->dbconn("sgc_seguimiento_caso");
        $query = $builder->update($datosSeguimiento, 'idsegcas = ' . $datosSeguimiento["idsegcas"]);
        return $query;
    }

    //Metodo para Eliminar  seguimientos del caso
    public function eliminarSeguimiento(array $datosSeguimiento)
    {
        $builder = $this->dbconn("sgc_seguimiento_caso");
        $query = $builder->update($datosSeguimiento, 'idsegcas = ' . $datosSeguimiento["idsegcas"]);
        return $query;
    } */


    



    //Metodo para la consulta de los seguimientos por fecha 
    public function consultaSeguimientoPorFecha(array $datos)
    {
        $builder = $this->dbconn("sgc_seguimiento_caso a");
        $builder->select("a.idsegcas, b.estllamnom, a.segcoment, a.segfec, c.usuopnom, c.usuopape");
        $builder->join("sgc_estatus_llamadas b", "a.idestllam = b.idestllam");
        $builder->join("sgc_usuario_operador c", "a.idusuopr = c.idusuopr");
        $builder->where("a.segfec BETWEEN '" . $datos["fecha_inicio"] . "' AND '" . $datos["fecha_fin"] . "'");
        $query = $builder->get();
        return $query;
    }

    //Metodo para obtener contadores de la tabla de seguimientos
    public function  contadoresSeguimientos(array $datos)
    {
        $builder = $this->dbconn("sgc_seguimiento_caso a");
        $builder->select("b.estllamnom, COUNT(a.idestllam)");
        $builder->join("sgc_estatus_llamadas b", "a.idestllam = b.idestllam");
        $builder->where("a.segfec BETWEEN '" . $datos["fecha_inicio"] . "' AND '" . $datos["fecha_fin"] . "'");
        $builder->groupBy('b.estllamnom');
        $query = $builder->get();
        return $query;
    }
}

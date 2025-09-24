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


   // Método para buscar las coordenadas

public function buscar_caso_coordenadas(array $coordenadas)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('sgc_casos_coordenadas AS c');
        $builder->select('*');
        $builder->where('c.docu_id_caso', $coordenadas["idcaso"]);
        $query = $builder->get();
        $resultado = $query->getResult();
        return $resultado;
}



    //Metodo para actualizar las coordenadas 
    public function Actualizar_coordenadas(array $coordenadas)
    {
        $builder = $this->dbconn("sgc_casos_coordenadas");
        $query = $builder->update($coordenadas, 'idcaso = ' . $coordenadas["idcaso"]);
        return $query;
    }

     //Metodo para borrar las coordenadas 
    public function borrar_coordenadas(array $coordenadas)
    {
        $builder = $this->dbconn("sgc_casos_coordenadas");
        $query = $builder->update($coordenadas, 'idcaso = ' . $coordenadas["idcaso"]);
        return $query;
    }




   /*  //Metodo para Eliminar  seguimientos del caso
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

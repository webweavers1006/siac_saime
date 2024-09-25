<?php

namespace App\Models;

class Seguimientos extends BaseModel
{
    //Metodo para obtener los seguimientos de un caso
    public function obtenerSeguimientoDeCaso(String $idcaso)
    {
        $db      = \Config\Database::connect();
        $strQuery = "SELECT sg.idusuopr,sg.idsegcas,sg.idestllam,sg.segcoment,sg.segfec ";
        $strQuery .= ",to_char(sg.segfec,'dd-mm-yyyy') as fecha_segui ";
        $strQuery .= ",b.estllamnom as desc_est_llamada";
        $strQuery .= ",CONCAT(usuop.usuopnom, ' ',' ', usuop.usuopape) AS user_name ";
        $strQuery .= "FROM sgc_seguimiento_caso sg  ";
        $strQuery .= " join sgc_estatus_llamadas b on sg.idestllam = b.idestllam   ";
        $strQuery .= " join sgc_usuario_operador usuop on  sg.idusuopr = usuop.idusuopr   ";
        $strQuery .= " join sgc_casos d on sg.idcaso = d.idcaso  ";
        $strQuery .= " join sgc_estatus e on d.idest = e.idest ";
        $strQuery .= " WHERE sg.idcaso= $idcaso";
        $strQuery .= " and sg.borrado='false'";
        $strQuery .= " ORDER BY sg.segfec  ASC";
        $query = $db->query($strQuery);
        $resultado = $query->getResult();
        return $resultado;
    }

    //Metodo para insertar un seguimiento del caso
    public function insertarSeguimiento(array $datosSeguimiento)
   
    {
       
        $builder = $this->dbconn("sgc_seguimiento_caso");
        $query = $builder->insert($datosSeguimiento);
        return $query;
    }

    //Metodo para actualizar seguimientos del caso
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
    }





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

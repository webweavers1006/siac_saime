<?php

namespace App\Models;

class Seguimientos extends BaseModel
{
    // Método para obtener los seguimientos de un caso
    public function obtenerSeguimientoDeCaso(String $idcaso)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('sgc_seguimiento_caso sg');
        $builder->select('sg.idusuopr, sg.idsegcas, sg.idestllam, sg.segcoment, sg.segfec');
        $builder->select("to_char(sg.segfec, 'dd-mm-yyyy') as fecha_segui");
        $builder->select('b.estllamnom as desc_est_llamada');
        $builder->select("CONCAT(usuop.usuopnom, ' ', usuop.usuopape) AS user_name");
        $builder->select('dir.descripcion as direccion_usuario');
        $builder->join('sgc_estatus_llamadas b', 'sg.idestllam = b.idestllam');
        $builder->join('sgc_usuario_operador usuop', 'sg.idusuopr = usuop.idusuopr');
        $builder->join('sgc_direcciones_administrativas dir', 'usuop.id_direccion_administrativa = dir.id', 'left');
        $builder->join('sgc_casos d', 'sg.idcaso = d.idcaso');
        $builder->join('sgc_estatus e', 'd.idest = e.idest');
        $builder->where('sg.idcaso', $idcaso);
        $builder->where('sg.borrado', false);
        $builder->orderBy('sg.segfec', 'ASC');
        $query = $builder->get();
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
        $builder->where('a.segfec >=', $datos['fecha_inicio']);
        $builder->where('a.segfec <=', $datos['fecha_fin']);
        $query = $builder->get();
        return $query;
    }

    //Metodo para obtener contadores de la tabla de seguimientos
    public function  contadoresSeguimientos(array $datos)
    {
        $builder = $this->dbconn("sgc_seguimiento_caso a");
        $builder->select("b.estllamnom, COUNT(a.idestllam)");
        $builder->join("sgc_estatus_llamadas b", "a.idestllam = b.idestllam");
        $builder->where('a.segfec >=', $datos['fecha_inicio']);
        $builder->where('a.segfec <=', $datos['fecha_fin']);
        $builder->groupBy('b.estllamnom');
        $query = $builder->get();
        return $query;
    }
}

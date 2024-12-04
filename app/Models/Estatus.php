<?php namespace App\Models;

class Estatus extends BaseModel{




    //Metodo para insertar una Direccion Administrativa
    public function add_estatus($estatus)
    {
        $builder = $this->dbconn("public.sgc_estatus");
        $query = $builder->insert($estatus);
        return $query;
    }

    //Metodo para actualizar una Direccion Administrativa
    public function editTipoEstatus($estatus)
    {
        $builder = $this->dbconn("public.sgc_estatus");
        $query = $builder->update($estatus, 'idest = ' . $estatus["idest"]);
        return $query;
    }


	// Método para listar tipos de estatus
public function Listar_Tipo_Estatus()
{
    $db = \Config\Database::connect();
    $builder = $db->table('sgc_estatus AS e');
    $builder->select('e.idest, e.estnom, CASE WHEN e.borrado = \'f\' THEN \'Activo\' ELSE \'Inactivo\' END AS borrado');
    $query = $builder->get();
    $resultado = $query->getResult();
    return $resultado;
}

// Método para listar tipos de atención con filtro
public function Listar_Tipo_Atencion_filtro()
{
    $db = \Config\Database::connect();
    $builder = $db->table('sgc_estatus AS e');
    $builder->select('e.tipo_aten_id, e.tipo_aten_nombre, CASE WHEN e.borrado = \'f\' THEN \'Activo\' ELSE \'Inactivo\' END AS borrado');
    $builder->where('e.borrado', false);
    $query = $builder->get();
    $resultado = $query->getResult();
    return $resultado;
}


	//Metodo para obtener los estatus de los casos
	public function estatusCaso(){
		$builder = $this->dbconn('sgc_estatus');
		$query = $builder->get();
		return $query;
	}

	//Metodo para obtener los estatus de las llamadas
	public function estatusLlamadas(){
		$builder = $this->dbconn('sgc_estatus_llamadas');
		$query = $builder->get();
		return $query;
	}

	//Metodo para cambiar el estatus de un caso
	public function cambioEstatusCaso(Array $datos){
		$builder = $this->dbconn('sgc_casos');
		$query = $builder->update(["idest" => $datos["idest"]],"idcaso = ".$datos["idcaso"]);
		return $query;
	}

}
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


	public function Listar_Tipo_Estatus()
    {
        $db      = \Config\Database::connect();
        $strQuery = "SELECT e.idest,e.estnom,case when e.borrado='f' then 'Activo' else 'Inactivo' end as borrado  ";
        $strQuery .= "FROM public.sgc_estatus as e  ";
        $query = $db->query($strQuery);
        $resultado = $query->getResult();
        return $resultado;
    }


    public function Listar_Tipo_Atencion_filtro()
    {
        $db      = \Config\Database::connect();
        $strQuery = "SELECT e.tipo_aten_id,e.tipo_aten_nombre,case when e.borrado='f' then 'Activo' else 'Inactivo' end as borrado  ";
        $strQuery .= "FROM public.sgc_estatus as e WHERE e.borrado='false' ";
        $query = $db->query($strQuery);
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
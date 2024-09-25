<?php

namespace App\Models;

class PropiedadIntelectual extends BaseModel
{

	//Metodo para obtener todos los tipos de propiedad Intelectual
	public function getTipoPI()
	{
		$builder = $this->dbconn('sgc_tipo_prop_intelec');
		$query = $builder->get();
		return $query;
	}

	//Metodo para insertar el tipos de propiedad intelectual de los casos
	public function insertarTipoPICaso($tipoPI)
	{
		$builder = $this->dbconn('sgc_tipo_prop_caso');
		$query = $builder->insert($tipoPI);
		return $query;
	}
	//Metodo para actulizar  el tipos de propiedad intelectual de los casos
	public function ActualizarTipoPICaso($tipoPI)
	{
		$builder = $this->dbconn('sgc_tipo_prop_caso');
		$query = $builder->update($tipoPI, 'idcaso = ' . $tipoPI["idcaso"]);
		return $query;
	}
}

<?php

namespace App\Models;

class Usuarios extends BaseModel
{

	//Metodo para obtener el usuario solo por el correo electronico

	public function obtenerUsuario(String $correo)
	{

		$db      = \Config\Database::connect();
		$strQuery = "SELECT * ";
		$strQuery .= "FROM sgc_usuario_operador a ";
		$strQuery .= " join sgc_roles b on b.idrol = a.idrol   ";
		$strQuery .= " WHERE a.usuopemail= '$correo'";
		$query = $db->query($strQuery);
		$resultado = $query->getResult();
		return $resultado;


	}

	//Metodo queo btiene usuarios registrados en el sistema
	public function getAllUsers()
	{
		$builder = $this->dbconn('sgc_usuario_operador a');
		$builder->select('a.idusuopr,a.usercargo,a.id_direccion_administrativa,a.idusuopr,a.usuopnom,a.usuopape,a.usuopemail,a.usuoppass,a,usuopborrado,b.rolnom,b.idrol');
		$builder->join("sgc_roles b", 'a.idrol = b.idrol');
		$query = $builder->get();
		return $query;
	}

	//Metodo para registrar un nuevo usuario

	public function addUsuario(array $datos)
	{
		$builder = $this->dbconn('sgc_usuario_operador');
		$query = $builder->insert($datos);
		return $query;
	}

	public function ultimo_id_insertado()
	{
		$db      = \Config\Database::connect();
		$strQuery = "SELECT last_value  ";
		$strQuery .= "FROM sgc_usuario_operador_idusuopr_seq ";
		$query = $db->query($strQuery);
		$resultado = $query->getResult();
		return $resultado;
	}


	

	//Metodo para obtener usuario por ID
	public function obtenerUsuarioPorId(String $id)
	{
		$builder = $this->dbconn('sgc_usuario_operador a');
		$builder->select('a.idusuopr , a.usuopnom, a.usuopape, a.usuopemail,a.usuoppass, b.idrol');
		$builder->join('sgc_roles b', 'b.idrol = a.idrol');
		$builder->where('a.idusuopr', $id);
		$query = $builder->get();
		return $query;
	}

	//Metodo para actualizar los usuarios
	public function actualizarUsuario(array $datos)
	{
		$builder = $this->dbconn('sgc_usuario_operador');
		$query = $builder->update($datos, 'idusuopr = ' . $datos["idusuopr"]);
		return $query;
	}
}

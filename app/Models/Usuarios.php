<?php

namespace App\Models;
use InvalidArgumentException;
class Usuarios extends BaseModel
{

	public function obtenerUsuario(String $correo)
	{
		$db = \Config\Database::connect();
		$builder = $db->table('sgc_usuario_operador a');
		$builder->select('*');
		$builder->join('sgc_roles b', 'b.idrol = a.idrol');
		$builder->where('a.usuopemail', $correo);
		$resultado = $builder->get()->getResult();
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


public function getAllUsers_filtro()
	{
		$builder = $this->dbconn('sgc_usuario_operador a');
		$builder->select('a.idusuopr,a.usercargo,a.id_direccion_administrativa,a.idusuopr,a.usuopnom,a.usuopape,a.usuopemail,a.usuoppass,a,usuopborrado,b.rolnom,b.idrol');
		$builder->join("sgc_roles b", 'a.idrol = b.idrol');
		$builder->where('a.usuopborrado', false);
		$query = $builder->get();
		return $query;
	}




public function getAllUsers_filtro_Pliticas_Publicas($direccion_administrativa = null)
	{
		$builder = $this->dbconn('sgc_usuario_operador a');
		$builder->select('a.idusuopr,a.usercargo,a.id_direccion_administrativa,a.usuopnom,a.usuopape,a.usuopemail,a.usuopborrado,b.rolnom,b.idrol');
		$builder->join("sgc_roles b", 'a.idrol = b.idrol');
		$builder->where('a.usuopborrado', false);

		if (!empty($direccion_administrativa) && $direccion_administrativa != '0') {
			$builder->where('a.id_direccion_administrativa', $direccion_administrativa);
		}

		$query = $builder->get();
		return $query;
	}



	public function getAllUsers_operadores()
	{
		$builder = $this->dbconn('sgc_usuario_operador a');
		$builder->select('a.idusuopr,a.acceso_audi,a.usercargo,a.id_direccion_administrativa,a.idusuopr,a.usuopnom,a.usuopape,a.usuopemail,a.usuoppass,a.usuopborrado,b.rolnom,b.idrol');
		$builder->join("sgc_roles b", 'a.idrol = b.idrol');
		$query = $builder->get();
		return $query->getResult(); // También debes agregar getResult() para obtener los resultados de la consulta
	}

	public function addUsuario(array $datos)
	{
		$builder = $this->dbconn('sgc_usuario_operador');
		$query = $builder->insert($datos);
		return $query === true; // Devuelve true si la inserción fue exitosa, false en caso contrario
	}

	public function ultimo_id_insertado()
	{
		$db = \Config\Database::connect();
		$ultimoId = $db->insertID();
		return $ultimoId;
	}
	
	public function obtenerUsuarioPorId(String $id)
	{
		$builder = $this->dbconn('sgc_usuario_operador a');
		$builder->select('a.idusuopr,a.acceso_audi,a.usuopnom, a.usuopape, a.usuopemail, a.usuoppass, b.idrol');
		$builder->join('sgc_roles b', 'b.idrol = a.idrol');
		$builder->where('a.idusuopr = ?', $id); // Utilizar un parámetro para evitar inyecciones
		$query = $builder->get();
		return $query->getResult(); // Obtener los resultados de la consulta
	}
	// Método para actualizar los usuarios
	public function actualizarUsuario(array $datos)
	{
		// Valide y sane los datos de entrada
		$datos = $this->validarDatos($datos);
		$builder = $this->dbconn('sgc_usuario_operador');
		$builder->where('idusuopr', $datos["idusuopr"]);
		$builder->set($datos); // Set the values to update
		$query = $builder->update();
		return $query;
	}

	private function validarDatos(array $datos)
	{
		$validados = array();
		foreach ($datos as $key => $value) {
			if (is_bool($value)) {
				// Si el valor es un booleano, no se aplica ninguna transformación
				$validados[$key] = $value;
			} else {
				// Elimina cualquier espacio en blanco innecesario
				$value = trim($value);
				// NO aplicar FILTER_FLAG_STRIP_HIGH para preservar acentos
				$value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
				$validados[$key] = $value;
			}
		}
		return $validados;
	}

	
}

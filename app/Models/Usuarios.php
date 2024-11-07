<?php

namespace App\Models;
use InvalidArgumentException;
class Usuarios extends BaseModel
{

	//Metodo para obtener el usuario solo por el correo electronico

	// public function obtenerUsuario(String $correo)
	// {

	// 	$db      = \Config\Database::connect();
	// 	$strQuery = "SELECT * ";
	// 	$strQuery .= "FROM sgc_usuario_operador a ";
	// 	$strQuery .= " join sgc_roles b on b.idrol = a.idrol   ";
	// 	$strQuery .= " WHERE a.usuopemail= '$correo'";
	// 	$query = $db->query($strQuery);
	// 	$resultado = $query->getResult();
	// 	return $resultado;


	// }

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

	// public function getAllUsers()
	// {
	// 	$builder = $this->dbconn('sgc_usuario_operador a');
	// 	$builder->select('a.idusuopr,a.acceso_audi,a.usercargo,a.id_direccion_administrativa,a.idusuopr,a.usuopnom,a.usuopape,a.usuopemail,a.usuoppass,a.usuopborrado,b.rolnom,b.idrol');
	// 	$builder->join("sgc_roles b", 'a.idrol = b.idrol');
	// 	$query = $builder->get();
	// 	return $query->getResult(); // También debes agregar getResult() para obtener los resultados de la consulta
	// }


	//Metodo para registrar un nuevo usuario

	// public function addUsuario(array $datos)
	// {
	// 	$builder = $this->dbconn('sgc_usuario_operador');
	// 	$query = $builder->insert($datos);
	// 	return $query;
	// }


	public function addUsuario(array $datos)
	{
		$builder = $this->dbconn('sgc_usuario_operador');
		$query = $builder->insert($datos);
		return $query === true; // Devuelve true si la inserción fue exitosa, false en caso contrario
	}



	// public function ultimo_id_insertado()
	// {
	// 	$db      = \Config\Database::connect();
	// 	$strQuery = "SELECT last_value  ";
	// 	$strQuery .= "FROM sgc_usuario_operador_idusuopr_seq ";
	// 	$query = $db->query($strQuery);
	// 	$resultado = $query->getResult();
	// 	return $resultado;
	// }

	public function ultimo_id_insertado()
	{
		$db = \Config\Database::connect();
		$ultimoId = $db->insertID();
		return $ultimoId;
	}
	//Metodo para obtener usuario por ID
	// public function obtenerUsuarioPorId(String $id)
	// {
	// 	$builder = $this->dbconn('sgc_usuario_operador a');
	// 	$builder->select('a.idusuopr , a.usuopnom, a.usuopape, a.usuopemail,a.usuoppass, b.idrol');
	// 	$builder->join('sgc_roles b', 'b.idrol = a.idrol');
	// 	$builder->where('a.idusuopr', $id);
	// 	$query = $builder->get();
	// 	return $query;
	// }

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
            // Aplica reglas de validación y saneamiento generales
            $value = filter_var($value, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
            // Verifica si el valor es un string
            if (is_string($value)) {
                // Aplica reglas de validación y saneamiento adicionales para strings
				$value = preg_replace('/[^a-zA-Z0-9\s\.\,\-\@\$\yZz\/]/', '', $value);
            } elseif (is_numeric($value)) {
                // Aplica reglas de validación y saneamiento adicionales para números
                $value = filter_var($value, FILTER_SANITIZE_NUMBER_INT);
            }
            $validados[$key] = $value;
        }
    }
    return $validados;
}

	
}

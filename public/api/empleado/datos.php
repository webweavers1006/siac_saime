<?php
header('Access-Control-Allow-Origin:  http://sihic.com');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
$cedula = "";
$apikey = "";
$filtroAnd = "";

if (isset($_GET['cedula'])) 
{
	//módulo de conexion a la BD
	require('Conexion_class.php');
	//Me conecto a la BD con las credenciales que están por allá
	$con = new Conexion_class();
	$conexion = $con->conectar();
	//Verifico si me pude conectar
	if (!isset($conexion)) {
		//('Problemas en la conexión, favor verificar  ...');
		//No se conectó;
		$respuesta =
			[
				"cedula"   => '777',
			];
	} else 
	{
		//die('Se Conectó al SIGEFIRRHH');
		//Se conectó;
		$cedula = $_GET['cedula'];
		$filtroAnd .= " AND p.cedula IN ($cedula)";
		//Armo la Consulta:
		$sqlConsulta = "SELECT ";
		$sqlConsulta .= "DISTINCT(p.cedula) AS cedula,";
		$sqlConsulta .= " concat(trim(p.primer_nombre),' ',trim(p.segundo_nombre)) AS nombres,";
		$sqlConsulta .= "concat(trim(p.primer_apellido),' ',trim(p.segundo_apellido)) AS apellidos,";
		$sqlConsulta .= "p.fecha_nacimiento,";
		$sqlConsulta .= "p.nacionalidad AS nacper,";
		$sqlConsulta .= "TRIM(d.nombre) AS ubicacion,";
		$sqlConsulta .= "TRIM(c.descripcion_cargo) AS cargo ";
		$sqlConsulta .= "FROM ";
		$sqlConsulta .= "  public.personal AS p ";
		$sqlConsulta .= "JOIN ";
		$sqlConsulta .= " trabajador AS t on p.id_personal= t.id_personal ";
		$sqlConsulta .= "JOIN";
		$sqlConsulta .= " dependencia AS d ON t.id_dependencia=d.id_dependencia ";
		$sqlConsulta .= "JOIN";
		$sqlConsulta .= "  cargo AS c ON t.id_cargo=c.id_cargo ";
		$sqlConsulta .= "where ";
		$sqlConsulta .= "t.estatus='A'";
		if ($filtroAnd != "") {
		$sqlConsulta .= "$filtroAnd ";
		}
		$sqlConsulta .= "GROUP BY ";
		$sqlConsulta .= "p.cedula, nombres, apellidos,p.fecha_nacimiento,p.nacionalidad,d.nombre,c.descripcion_cargo";
		//Obtengo los registros de la consulta
		$Rs = $con->registros($sqlConsulta);
		$num_rows = pg_num_rows($Rs);
		if ($num_rows>0) 
		{	
			//Verifico si hay registros
			if (!$Rs) 
			{
				//No hay registros
				//echo('No existen registros coincidentes');
				$respuesta =
					[
						"cedula"   => '000',
					];
			} 
			else 
			{
				//Hay registros
				//Esta es la Respuesta de la API
				//Aqui guardo todos los registros de la consulta
				//$respuesta=[];
				//while($registro=pg_fetch_assoc($Rs))
				//Obtengo un arreglo asociativo con los registros de la consulta 

				while ($campo = $con->arrCamposAsociativos($Rs)) {
					foreach ($campo as &$value) {
						$encoding = mb_detect_encoding($value);
						if ($encoding != 'UTF-8') {
							$value = iconv($encoding, 'UTF-8', $value);
						}
					}
					$respuesta = [
						"cedula"   => $campo['cedula'],
						"nombres"  => $campo['nombres'] . ".",
						"apellidos" => $campo['apellidos'] . ".",
						"cargo"    => $campo['cargo'],
						"ubicacion" => $campo['ubicacion'],
						"fecha_nacimiento" => $campo['fecha_nacimiento'],
						"nacper" => $campo['nacper'],
					];
				}
				
				
			}
		}else
		{
			$respuesta =
			[
			"cedula"   => '888',
			];

		}


		

		
	}
}
else {
	//echo('No se recibió la cedula del titular ');
	$respuesta =
		[
			"cedula"   => '999',
		];
}
//$respuesta = json_encode($respuesta);
$json = json_encode($respuesta, JSON_UNESCAPED_UNICODE);
echo $json;






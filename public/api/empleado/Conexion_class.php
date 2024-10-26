<?php
/* 1.- Se crea la Clase */
class Conexion_class
{
     /* 2.- Creamos los atributos */
     public $host;
     public $dbname;
     public $user;
     public $clave;
     public $puerto;
     public $conexion;
     public $url;

     /* 3.- Creación del constructor */
     function __construct()
     {
     }

     /* 4.- Creación de la función que carga los valores
     * para la conexión */
     function cargarValores()
     {
	  
          // prueba de cambios finales 

	  $this->host    ="172.0.11.190";
	  $this->dbname  ="sigefirrhh";
	  $this->user    ="postgres";
	  $this->clave   ="postgres";
	  $this->puerto  =5432;
	  $this->conexion="host='$this->host' dbname='$this->dbname' user='$this->user' password='$this->clave' port='$this->puerto'";
	  return $this->conexion;
     }
     /* 5.- Función que se utilizará al instanciar
      *  la clase para conectarnos a la BD */
     function conectar()
     {
	  $this->cargarValores();
	  $this->url=pg_connect($this->conexion);
	  //return true;
	  return $this->url;
     }
     /* 6.- Función para obtener los registros de la consulta */
     function registros($consulta)
     {
	  //return pg_query($con,$consulta);
	  return pg_query($this->url,$consulta);
     }
     /* 7.- Función para obtener un arreglo asociativo con los registros de la consulta */
     function arrCamposAsociativos($resultSet)
     {
	  return pg_fetch_assoc($resultSet);
     }
     /* 8.-Función para destruir la conexión */
     function destruir()
     {
	  pg_close($this->url);
     }

}
//Instyancio la clase para probar:
/*
$conexion = new Conexion_class();

$conexion->conectar();
//var_dump($conexion);

if($conexion->conectar()==true)
{
     //echo("Conexion Exitosa");
     $conexion->destruir();
}
else
{
     echo("No se pudo conectar");
}
*/

/*
     function conectar()
     {
	  $host    ="localhost";
	  $dbname  ="sigesp";
	  $user    ="postgres";
	  $clave   ="postgres";
	  $conexion="";
	  $puerto  =5432;

	  $conexion=pg_connect("host=$host dbname=$dbname port=$puerto user=$user password=$clave")
		    or die("Error al Conectar" . pg_last_error());

	  return $conexion;
     }
 */
?>

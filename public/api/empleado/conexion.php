<?php
     function conectar()
     {
	  $host    ="localhost";
	  $dbname  ="sigesp";
	  $puerto  =5433;
	  $user    ="postgres";
	  $clave   ="postgres";
	  $conexion="";
	  $conexion=pg_connect("host=$host dbname=$dbname port=$puerto user=$user password=$clave")
		    or die("Error al Conectar" . pg_last_error());
	  return $conexion;
     }
?>

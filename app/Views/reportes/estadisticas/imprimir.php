<?php

$estadisticas = $_POST["estadisticas"]; // Obtén las estadísticas del formulario

// // Imprime las estadísticas en la página
// echo $estadisticas;

// O genera un archivo de impresión
$archivo = fopen("impresion.txt", "w");
fwrite($archivo, $estadisticas);
fclose($archivo);

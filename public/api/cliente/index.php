<?php
/**
 * En este caso, queremos aumentar el coste predeterminado de BCRYPT a 12.
 * Observe que también cambiamos a BCRYPT, que tendrá siempre 60 caracteres.
 */
$opciones = [
    'cost' => 12,
];
echo password_hash("rasmuslerdorf", PASSWORD_BCRYPT, $opciones)."\n";
?>


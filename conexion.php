<?php
// db_connect.php

$servidor = 'localhost';
$usuario = 'root';
$clave = '';
$base_de_datos = 'mercadocampesino3';

try {
    // Crear una conexión PDO a la base de datos
    $con = new PDO("mysql:host=$servidor;dbname=$base_de_datos", $usuario, $clave);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Mostrar el mensaje de error en caso de fallo en la conexión
    die('Error en la conexión: ' . $e->getMessage());
}
?>
<?php

$server = 'localhost';   // Dirección del servidor de base de datos (en este caso, localmente)
$username = 'root';      // Nombre de usuario de la base de datos
$password = '';          // Contraseña de la base de datos
$database = 'ptemtelco'; // Nombre de la base de datos que quieres conectar

try {
  // Crear una nueva instancia de PDO con los datos de conexión
  $conn = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
  
  // Establecer el modo de errores de PDO para que lance excepciones en caso de error
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
  //funciones de cararacteres especiales
  $conn->exec("SET CHARACTER SET utf8");
  $conn->exec("SET NAMES utf8");
  
} catch (PDOException $e) {
  // Capturar cualquier excepción PDO que ocurra durante la conexión
  die('Connection Failed: ' . $e->getMessage());
}

?>

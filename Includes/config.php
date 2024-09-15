<?php
// Datos de conexión a la base de datos
$servername = "localhost";  // servidor, una IP o dominio
$username = "root";         // Usuario de la base de datos
$password = "";             // Contraseña del usuario de la base de datos
$dbname = "yarotec";        // Nombre de la base de datos

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>

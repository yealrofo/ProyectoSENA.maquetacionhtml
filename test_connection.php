<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "usuarios_yarotec";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
echo "Conexión exitosa a la base de datos.";
$conn->close();
?>

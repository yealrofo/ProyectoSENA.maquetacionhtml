<?php
// Habilitar la visualización de errores (solo para depuración)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require 'config.php';

header('Content-Type: application/json');

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    echo json_encode(['error' => 'Usuario no autenticado']);
    exit;
}

// Obtener el nombre del usuario activo
$usuario = $_SESSION['usuario'];

// Consultar el número de productos en seguimiento
$resultSeguimiento = $conn->query("SELECT COUNT(*) as count FROM productos WHERE seguimiento = 1");
$productosSeguimiento = $resultSeguimiento->fetch_assoc()['count'];

// Consultar el número de productos con alerta o precio más bajo
$resultAlerta = $conn->query("SELECT COUNT(*) as count FROM productos WHERE precio_actual <= precio_ideal");
$productosAlerta = $resultAlerta->fetch_assoc()['count'];

// Devolver la información en formato JSON
echo json_encode([
    'usuario' => $usuario,
    'productosSeguimiento' => $productosSeguimiento,
    'productosAlerta' => $productosAlerta
]);

// Cerrar la conexión a la base de datos
$conn->close();
?>

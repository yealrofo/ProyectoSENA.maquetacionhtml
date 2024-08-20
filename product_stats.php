<?php
require 'config.php';

header('Content-Type: application/json');

// Obtener el número de productos en seguimiento
$sql_seguimiento = "SELECT COUNT(*) as seguimiento FROM productos";
$result_seguimiento = $conn->query($sql_seguimiento);
$row_seguimiento = $result_seguimiento->fetch_assoc();
$seguimiento = $row_seguimiento['seguimiento'];

// Obtener el número de productos con alerta (precio actual menor que el precio ideal)
$sql_alertas = "SELECT COUNT(*) as alertas FROM productos WHERE precio_actual < precio_ideal";
$result_alertas = $conn->query($sql_alertas);
$row_alertas = $result_alertas->fetch_assoc();
$alertas = $row_alertas['alertas'];

echo json_encode([
    'success' => true,
    'seguimiento' => $seguimiento,
    'alertas' => $alertas
]);

$conn->close();
?>

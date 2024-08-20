<?php
require 'config.php';
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'No se ha iniciado sesión.']);
    exit;
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT nombre_usuario, apellido_usuario FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode([
        'success' => true,
        'nombre_usuario' => $row['nombre_usuario'],
        'apellido_usuario' => $row['apellido_usuario']
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Usuario no encontrado.']);
}

$stmt->close();
$conn->close();
?>

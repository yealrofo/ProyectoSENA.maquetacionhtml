<?php
require 'config.php';

$data = json_decode(file_get_contents("php://input"), true);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $data['usuario'] ?? null;
    $clave_ingreso = $data['password'] ?? null;

    if (!$usuario || !$clave_ingreso) {
        echo json_encode(['success' => false, 'message' => 'Faltan datos para el login.']);
        exit;
    }

    $sql = "SELECT * FROM usuarios WHERE usuario = ? OR correo_electronico = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $usuario, $usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($clave_ingreso, $user['clave_ingreso'])) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Credenciales incorrectas.']);
    }

    $stmt->close();
    $conn->close();
}
?>

<?php
require 'config.php';

$data = json_decode(file_get_contents("php://input"), true);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $llave = $data['key'] ?? null;
    $nombre_usuario = $data['nombre'] ?? null;
    $apellido_usuario = $data['apellido'] ?? null;
    $cargo = $data['cargo'] ?? null;
    $correo_electronico = $data['email'] ?? null;
    $clave_ingreso = $data['password'] ?? null;
    $usuario = $data['usuario'] ?? null;

    if ($llave !== 'yarotec666') {
        echo json_encode(['success' => false, 'message' => 'Llave de registro incorrecta.']);
        exit;
    }

    if (!$llave || !$nombre_usuario || !$apellido_usuario || !$cargo || !$correo_electronico || !$clave_ingreso || !$usuario) {
        echo json_encode(['success' => false, 'message' => 'Faltan datos para el registro.']);
        exit;
    }

    $clave_ingreso_encriptada = password_hash($clave_ingreso, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (llave, nombre_usuario, apellido_usuario, cargo, correo_electronico, clave_ingreso, usuario)
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $llave, $nombre_usuario, $apellido_usuario, $cargo, $correo_electronico, $clave_ingreso_encriptada, $usuario);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al registrar usuario: ' . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
?>

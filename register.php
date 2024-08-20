<?php
// Habilitar la visualización de errores (solo para depuración)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'config.php';

header('Content-Type: application/json');

// Obtener los datos enviados en formato JSON
$data = json_decode(file_get_contents("php://input"), true);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $llave = $data['key'] ?? null;
    $nombre_usuario = $data['nombre'] ?? null;
    $apellido_usuario = $data['apellido'] ?? null;
    $cargo = $data['cargo'] ?? null;
    $correo_electronico = $data['email'] ?? null;
    $clave_ingreso = $data['password'] ?? null;
    $usuario = $data['usuario'] ?? null;

    // Validar la llave de registro
    if ($llave !== 'yarotec666') {
        echo json_encode(['success' => false, 'message' => 'Llave de registro incorrecta.']);
        exit;
    }

    // Validar que todos los campos estén completos
    if (!$llave || !$nombre_usuario || !$apellido_usuario || !$cargo || !$correo_electronico || !$clave_ingreso || !$usuario) {
        echo json_encode(['success' => false, 'message' => 'Faltan datos para el registro.']);
        exit;
    }

    // Verificar si el usuario ya existe
    $checkUserSql = "SELECT * FROM usuarios WHERE usuario = ?";
    $stmt = $conn->prepare($checkUserSql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'El nombre de usuario ya está en uso.']);
        $stmt->close();
        $conn->close();
        exit;
    }
    $stmt->close();

    // Verificar si el correo ya existe
    $checkEmailSql = "SELECT * FROM usuarios WHERE correo_electronico = ?";
    $stmt = $conn->prepare($checkEmailSql);
    $stmt->bind_param("s", $correo_electronico);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'El correo electrónico ya está en uso.']);
        $stmt->close();
        $conn->close();
        exit;
    }
    $stmt->close();

    // Encriptar la contraseña
    $clave_ingreso_encriptada = password_hash($clave_ingreso, PASSWORD_DEFAULT);

    // Preparar la consulta SQL para insertar el nuevo usuario
    $sql = "INSERT INTO usuarios (llave, nombre_usuario, apellido_usuario, cargo, correo_electronico, clave_ingreso, usuario)
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    try {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssss", $llave, $nombre_usuario, $apellido_usuario, $cargo, $correo_electronico, $clave_ingreso_encriptada, $usuario);

        // Ejecutar la consulta y verificar el resultado
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Registro exitoso.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al registrar usuario: ' . $stmt->error]);
        }

        // Cerrar el statement
        $stmt->close();
    } catch (mysqli_sql_exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error en el registro: ' . $e->getMessage()]);
    }

    // Cerrar la conexión
    $conn->close();
}
?>

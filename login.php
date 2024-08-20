<?php
// Conexión a la base de datos
$host = '127.0.0.1';
$db = 'usuarios_yarotec';
$user = 'root';
$password = '';

$mysqli = new mysqli($host, $user, $password, $db);

if ($mysqli->connect_error) {
    die('Error de Conexión (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

// Obtener datos enviados desde el cliente
$data = json_decode(file_get_contents('php://input'), true);

$usuario = $data['usuario'];
$password = $data['password'];

// Buscar el usuario en la base de datos
$stmt = $mysqli->prepare("SELECT id, clave_ingreso FROM usuarios WHERE usuario = ?");
$stmt->bind_param("s", $usuario);
$stmt->execute();
$stmt->store_result();

$response = array();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($id, $hash);
    $stmt->fetch();

    if (password_verify($password, $hash)) {
        session_start();
        $_SESSION['user_id'] = $id;
        $response['success'] = true;
    } else {
        $response['success'] = false;
        $response['message'] = 'Contraseña incorrecta';
    }
} else {
    $response['success'] = false;
    $response['message'] = 'Usuario no encontrado';
}

$stmt->close();
$mysqli->close();

// Enviar respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($response);
?>

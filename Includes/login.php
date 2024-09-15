<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "yarotec";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Error de conexión a la base de datos']));
}

$data = json_decode(file_get_contents('php://input'), true);

$usuario = $data['usuario'];
$password = $data['password'];

$stmt = $conn->prepare("SELECT id, clave FROM usuarios WHERE usuario = ? OR correo_electronico = ?");
$stmt->bind_param("ss", $usuario, $usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['clave'])) {
        session_start();
        $_SESSION['user_id'] = $user['id'];
        echo json_encode(['success' => true, 'message' => 'Inicio de sesión exitoso']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Credenciales inválidas']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Credenciales inválidas']);
}

$stmt->close();
$conn->close();
?>
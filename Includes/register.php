<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root"; // Cambia esto si es necesario
$password = ""; // Cambia esto si es necesario
$dbname = "yarotec";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Error de conexión: ' . $conn->connect_error]));
}

$data = json_decode(file_get_contents("php://input"));

$clave_ingreso = $data->key;
$nombre = $data->nombre;
$apellido = $data->apellido;
$cargo = $data->cargo;
$email = $data->email;
$usuario = $data->usuario;
$password = $data->password;

// Verificar clave de registro
if ($clave_ingreso !== 'yarotec666') {
    echo json_encode(['success' => false, 'message' => 'Clave de registro incorrecta']);
    exit();
}

// Verificar si el correo electrónico ya está registrado
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE correo_electronico = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'El correo electrónico ya está registrado']);
    exit();
}

// Verificar si el nombre de usuario ya está registrado
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE usuario = ?");
$stmt->bind_param("s", $usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'El nombre de usuario ya está registrado']);
    exit();
}

// Cifrar la contraseña antes de insertarla en la base de datos
$password_hashed = password_hash($password, PASSWORD_DEFAULT);

// Insertar nuevo usuario con contraseña hasheada
$stmt = $conn->prepare("INSERT INTO usuarios (clave_ingreso, nombre_usuario, apellido_usuario, cargo, correo_electronico, usuario, clave) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss", $clave_ingreso, $nombre, $apellido, $cargo, $email, $usuario, $password_hashed);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Usuario registrado con éxito']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al registrar usuario: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>

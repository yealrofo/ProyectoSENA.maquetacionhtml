<?php
require 'config.php';

// Obtener los datos del producto desde la solicitud
$data = json_decode(file_get_contents("php://input"), true);

$nombre = $data['nombre'];
$categoria = $data['categoria'];
$subcategoria = $data['subcategoria'];
$url = $data['url'];
$precioActual = $data['precioActual'];
$precioIdeal = $data['precioIdeal'];

// Extraer la imagen del producto usando web scraping
// Esto es solo un ejemplo, para un uso real se debe considerar la legalidad y ética de hacer scraping en Amazon.
$image_url = ''; // Aquí deberías implementar el web scraping para obtener la URL de la imagen del producto

// Preparar la consulta SQL para insertar el nuevo producto
$sql = "INSERT INTO productos (nombre, categoria, subcategoria, url, precio_actual, precio_ideal, imagen)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssdds", $nombre, $categoria, $subcategoria, $url, $precioActual, $precioIdeal, $image_url);

// Ejecutar la consulta y verificar el resultado
if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al agregar el producto: ' . $stmt->error]);
}

// Cerrar la conexión y el statement
$stmt->close();
$conn->close();
?>

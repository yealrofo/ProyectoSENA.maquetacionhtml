<?php
require 'config.php';

// Consulta SQL para obtener los productos en promoción
$sql = "SELECT c.nombre AS categoria, p.id, p.nombre, p.precio_actual, p.porcentaje_diferencia, p.imagen 
        FROM productos p
        JOIN subcategorias s ON p.subcategoria_id = s.id
        JOIN categorias c ON s.categoria_id = c.id
        WHERE p.precio_actual < p.precio_ideal";

$result = $conn->query($sql);

$productos = [];
while ($row = $result->fetch_assoc()) {
    $categoria = $row['categoria'];
    $producto = [
        'id' => $row['id'],
        'nombre' => $row['nombre'],
        'precio_actual' => $row['precio_actual'],
        'porcentaje_diferencia' => $row['porcentaje_diferencia'],
        'imagen' => $row['imagen']
    ];

    if (!isset($productos[$categoria])) {
        $productos[$categoria] = ['nombre' => $categoria, 'productos' => []];
    }

    $productos[$categoria]['productos'][] = $producto;
}

echo json_encode(array_values($productos));

$conn->close();
?>

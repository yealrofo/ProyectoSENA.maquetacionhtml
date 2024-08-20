<?php
require 'config.php';

// Consulta SQL para obtener los datos de los productos
$sql = "SELECT c.nombre AS categoria, s.nombre AS subcategoria, p.id, p.nombre, p.precio_actual, p.porcentaje_diferencia, p.precio_bajo, p.precio_alto, p.imagen 
        FROM productos p
        JOIN subcategorias s ON p.subcategoria_id = s.id
        JOIN categorias c ON s.categoria_id = c.id";

$result = $conn->query($sql);

$productos = [];
while ($row = $result->fetch_assoc()) {
    $categoria = $row['categoria'];
    $subcategoria = $row['subcategoria'];
    $producto = [
        'id' => $row['id'],
        'nombre' => $row['nombre'],
        'precio_actual' => $row['precio_actual'],
        'porcentaje_diferencia' => $row['porcentaje_diferencia'],
        'precio_bajo' => $row['precio_bajo'],
        'precio_alto' => $row['precio_alto'],
        'imagen' => $row['imagen']
    ];

    if (!isset($productos[$categoria])) {
        $productos[$categoria] = ['nombre' => $categoria, 'subcategorias' => []];
    }

    if (!isset($productos[$categoria]['subcategorias'][$subcategoria])) {
        $productos[$categoria]['subcategorias'][$subcategoria] = ['nombre' => $subcategoria, 'productos' => []];
    }

    $productos[$categoria]['subcategorias'][$subcategoria]['productos'][] = $producto;
}

echo json_encode(array_values($productos));

$conn->close();
?>

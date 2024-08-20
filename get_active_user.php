<?php
session_start(); // Iniciar la sesión

// Comprobar si el usuario está almacenado en la sesión
if (isset($_SESSION['usuario'])) {
    echo json_encode(['usuario' => $_SESSION['usuario']]);
} else {
    echo json_encode(['usuario' => null]);
}
?>

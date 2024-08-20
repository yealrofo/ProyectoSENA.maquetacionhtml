// index.js

// Función para obtener información del usuario y productos
function obtenerInformacion() {
    // Realizar una solicitud al servidor para obtener los datos
    fetch('get_info.php')
        .then(response => response.json())
        .then(data => {
            // Actualizar el nombre del usuario activo
            document.getElementById('usuarioActivo').innerText = 'Usuario Activo: ' + data.usuario;
            // Actualizar el número de productos en seguimiento
            document.getElementById('productosSeguimiento').innerText = 'Número de productos en seguimiento: ' + data.productosSeguimiento;
            // Actualizar el número de productos con alerta o precio más bajo
            document.getElementById('productosAlerta').innerText = 'Número de productos con alerta o precio más bajo: ' + data.productosAlerta;
        })
        .catch(error => console.error('Error al obtener la información:', error));
}

// Llamar a la función para obtener la información al cargar la página
document.addEventListener('DOMContentLoaded', obtenerInformacion);



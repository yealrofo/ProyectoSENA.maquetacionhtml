document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Evitar que el formulario se envíe normalmente

    const usuario = document.getElementById('usuario').value;
    const password = document.getElementById('password').value;

    // Crear objeto de datos para enviar
    const data = {
        usuario: usuario,
        password: password
    };

    // Hacer la solicitud al servidor
    fetch('../Includes/login.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.text();
    })
    .then(text => {
        console.log('Respuesta del servidor:', text);
        try {
            const data = JSON.parse(text);
            if (data.success) {
                window.location.href = 'index.html'; // Redirigir al index si el inicio de sesión es exitoso
            } else {
                alert(data.message); // Mostrar mensaje de error
            }
        } catch (error) {
            console.error('Error al parsear JSON:', error);
            alert('Error en la respuesta del servidor: ' + text);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error en la comunicación con el servidor: ' + error.message);
    });
});
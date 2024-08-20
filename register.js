document.getElementById('registerForm').addEventListener('submit', function(e) {
    e.preventDefault();

    // Obtener los datos del formulario
    const data = {
        key: document.getElementById('key').value,
        nombre: document.getElementById('nombre').value,
        apellido: document.getElementById('apellido').value,
        cargo: document.getElementById('cargo').value,
        email: document.getElementById('email').value,
        usuario: document.getElementById('usuario').value,
        password: document.getElementById('password').value,
    };

    // Enviar los datos al servidor
    fetch('register.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            alert(result.message || 'Registro exitoso');
            window.location.href = 'login.html'; // Redirigir al login después del registro
        } else {
            alert(result.message || 'Error en el registro');
        }
    })
    .catch(error => console.error('Error:', error));
});

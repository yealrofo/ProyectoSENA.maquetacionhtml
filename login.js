document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Evita el comportamiento predeterminado del formulario

    // Recopila los datos del formulario
    const data = {
        usuario: document.getElementById('usuario').value,
        password: document.getElementById('password').value
    };

    // Envía los datos al servidor mediante fetch API
    fetch('login.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            window.location.href = 'index.html'; // Redirige a la página principal
        } else {
            alert('Error de inicio de sesión: ' + result.message);
        }
    })
    .catch(error => console.error('Error:', error));
});

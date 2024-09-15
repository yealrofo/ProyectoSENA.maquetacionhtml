document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registerForm');

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const key = document.getElementById('key').value;
        const nombre = document.getElementById('nombre').value;
        const apellido = document.getElementById('apellido').value;
        const email = document.getElementById('email').value;
        const usuario = document.getElementById('usuario').value;
        const password = document.getElementById('password').value;
        const cargo = document.getElementById('cargo').value;

        if (key !== 'yarotec666') {
            alert('Clave de registro incorrecta');
            return;
        }

        const userData = {
            key: key,
            nombre: nombre,
            apellido: apellido,
            email: email,
            usuario: usuario,
            password: password,
            cargo: cargo
        };

        fetch('../Includes/register.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(userData),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Usuario registrado con éxito');
                window.location.href = 'login.html'; // Redirigir al login después del registro
            } else {
                alert('Error al registrar usuario: ' + data.message);
            }
        })
        .catch((error) => {
            console.error('Error:', error);
            alert('Error al registrar usuario');
        });
    });
});

document.getElementById('registerForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const data = {
        key: document.getElementById('key').value,
        nombre: document.getElementById('nombre').value,
        apellido: document.getElementById('apellido').value,
        cargo: document.getElementById('cargo').value,
        email: document.getElementById('email').value,
        usuario: document.getElementById('usuario').value,
        password: document.getElementById('password').value,
    };

    try {
        const response = await fetch('register.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();

        if (result.success) {
            alert('Usuario registrado exitosamente');
            document.getElementById('registerForm').reset();
        } else {
            alert('Error: ' + result.message);
        }
    } catch (error) {
        console.error('Error:', error);
    }
});

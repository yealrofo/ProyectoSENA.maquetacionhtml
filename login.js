document.getElementById('loginForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const data = {
        usuario: document.getElementById('usuario').value,
        password: document.getElementById('password').value,
    };

    try {
        const response = await fetch('login.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();

        if (result.success) {
            window.location.href = 'index.html';
        } else {
            alert('Error: ' + result.message);
        }
    } catch (error) {
        console.error('Error:', error);
    }
});

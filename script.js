function showLogin() {
    // Implementar lógica para mostrar la página de ingreso de usuario
    alert("Mostrar página de ingreso de usuario");
}

function showRegistro() {
    // Implementar lógica para mostrar la página de registro de nuevo usuario
    alert("Mostrar página de registro de nuevo usuario");
}

function obtenerFechaYHora() {
    const now = new Date();
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric', hour12: true };
    return now.toLocaleDateString('es-ES', options);
}
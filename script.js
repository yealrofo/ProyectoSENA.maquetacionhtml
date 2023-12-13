function showLogin() {
    
    alert("Mostrar página de ingreso de usuario");
}

function showRegistro() {
    
    alert("Mostrar página de registro de nuevo usuario");
}

function obtenerFechaYHora() {
    const now = new Date();
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric', hour12: true };
    return now.toLocaleDateString('es-ES', options);
}
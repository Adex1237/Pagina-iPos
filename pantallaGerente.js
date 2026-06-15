// 1. RELEJO EN TIEMPO REAL COHERENTE CON LA HORA LOCAL
function actualizarReloj() {
    const fecha = new Date();
    let horas = fecha.getHours();
    const minutos = String(fecha.getMinutes()).padStart(2, '0');
    const ampm = horas >= 12 ? 'p.m.' : 'a.m.';
    
    horas = horas % 12;
    horas = horas ? horas : 12; 
    const horasFormateadas = String(horas).padStart(2, '0');

    document.getElementById('txtReloj').textContent = `${horasFormateadas}:${minutos} ${ampm}`;
}

// Iniciar reloj e intervalos
actualizarReloj();
setInterval(actualizarReloj, 1000);

// 2. SISTEMA INTERNO DE NAVEGACIÓN (SPA)
const menuItems = document.querySelectorAll('.menu-item');
const sections = document.querySelectorAll('.main-section');

menuItems.forEach(item => {
    item.addEventListener('click', (e) => {
        e.preventDefault(); 
        
        // Quitar estado activo al menú actual
        menuItems.forEach(menu => menu.classList.remove('active'));
        // Añadir estado activo al botón presionado
        item.classList.add('active');

        // Ocultar todas las pantallas del contenedor principal
        sections.forEach(section => section.classList.remove('active'));
        
        // Mostrar la pantalla correspondiente mediante el data-target
        const targetId = item.getAttribute('data-target');
        document.getElementById(targetId).classList.add('active');
    });
});

// 3. CONTROL DEL DROPDOWN DE PERFIL Y CERRAR SESIÓN
const btnPerfil = document.getElementById('btnPerfil');
const menuDesplegable = document.getElementById('menuDesplegable');
const btnCerrarSesion = document.getElementById('btnCerrarSesion');

// Alternar (abrir/cerrar) el menú al hacer clic en el perfil
btnPerfil.addEventListener('click', (e) => {
    e.stopPropagation(); // Evita que el evento se propague al documento
    menuDesplegable.classList.toggle('show');
});

// Cerrar el menú automáticamente si el usuario hace clic fuera de él
document.addEventListener('click', () => {
    menuDesplegable.classList.remove('show');
});

// Acción del botón Cerrar Sesión
btnCerrarSesion.addEventListener('click', (e) => {
    e.preventDefault();
    
    // Simulación de salida del sistema redirigiendo al login/perfiles
    alert("Cerrando sesión en POS Pro... Redirigiendo a la pantalla de selección de perfil.");
    
    // Aquí puedes cambiar "index.html" por el nombre real de tu archivo de selección de perfiles
    window.location.href = "index.html"; 
});
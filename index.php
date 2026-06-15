<?php
// 1. CONEXIÓN MAESTRA A POSTGRESQL (Ajusta los datos de tu BD local)
$host = "localhost";
$port = "5432";
$dbname = "ProyectoFinal"; // <--- CAMBIA ESTO por el nombre real de tu BD en Postgres
$user = "postgres"; 
$password = "sabrina"; // <--- CAMBIA ESTO por tu contraseña de Postgres Admin

$connection_string = "host={$host} port={$port} dbname={$dbname} user={$user} password={$password}";
$dbconn = pg_connect($connection_string);

if (!$dbconn) {
    die("Error crítico: No se pudo conectar a la base de datos de PostgreSQL.");
}

// 2. CONSULTA REAL (Usando tu tabla 'roles' del script SQL)
$query = "SELECT * FROM roles ORDER BY rolid ASC";
$result = pg_query($dbconn, $query);

if (!$result) {
    die("Error en la consulta SQL: " . pg_last_error($dbconn));
}

$roles = pg_fetch_all($result);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Pro - Selecciona tu perfil</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght=400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
        <header class="header">
            <div class="logo-container">
                <div class="logo-box"><i class="fa-solid fa-shop"></i></div>
                <div class="logo-text">
                    <span class="system-subtitle">SISTEMA</span>
                    <h1 class="system-title">POS Pro</h1>
                </div>
            </div>
            <p class="current-date">15 jun 2026, 03:35 p.m.</p>
            <h2 class="section-title">Selecciona tu perfil</h2>
        </header>

        <main class="profiles-grid">
            <?php 
            if ($roles):
                foreach ($roles as $rol): 
                    $descripcion = $rol['descripcion']; // 'Vendedor', 'Gerente', 'Cajero'
                    $iniciales = "";
                    $avatar_class = "avatar-grey";
                    $icon_class = "fa-user";

                    // Asignación de diseño basada en tus inserciones reales de la BD
                    if (strtolower($descripcion) == 'gerente') {
                        $iniciales = "GR";
                        $avatar_class = "avatar-orange";
                        $icon_class = "fa-shield-halved text-orange";
                    } elseif (strtolower($descripcion) == 'cajero') {
                        $iniciales = "CJ";
                        $avatar_class = "avatar-grey";
                        $icon_class = "fa-user";
                    } elseif (strtolower($descripcion) == 'vendedor') {
                        $iniciales = "VD";
                        $avatar_class = "avatar-blue";
                        $icon_class = "fa-briefcase";
                    }
            ?>
                <div class="profile-card" onclick="openLoginModal('<?php echo strtolower($descripcion); ?>')">
                    <div class="avatar <?php echo $avatar_class; ?>"><?php echo $iniciales; ?></div>
                    <div class="profile-role">
                        <i class="fa-solid <?php echo $icon_class; ?>"></i> 
                        <span><?php echo $descripcion; ?></span>
                    </div>
                    <div class="profile-shift text-muted">
                        Turno: <?php echo (strtolower($descripcion) == 'gerente') ? 'Completo' : 'Matutino'; ?>
                    </div>
                </div>
            <?php 
                endforeach; 
            else:
                echo "<p>No se encontraron roles en la base de datos.</p>";
            endif;
            ?>
        </main>

        <footer class="footer">
            <p>POS Pro v2.5.0 · 11 tablas activas</p>
        </footer>
    </div>

    <div id="loginModal" class="modal-overlay">
    <div class="modal-content">
        <button class="close-modal" onclick="closeLoginModal()">&times;</button>
        
        <h3 id="modalUserName">Iniciar Sesión</h3>
        <p class="modal-subtitle">Introduce la contraseña del usuario PostgreSQL</p>
        
        <form action="login_process.php" method="POST">
            <input type="hidden" name="db_user" id="modalDbUser">
            
            <div class="input-group">
                <i class="fa-solid fa-lock input-icon"></i>
                <input type="password" name="db_password" placeholder="Contraseña de la BD" required>
            </div>
            
            <button type="submit" class="submit-btn">Conectar e Ingresar</button>
        </form>
    </div>
</div>

    <script>
        function openLoginModal(username) {
            document.getElementById('modalDbUser').value = username;
            document.getElementById('modalUserName').innerText = "Acceder como " + username.charAt(0).toUpperCase() + username.slice(1);
            document.getElementById('loginModal').classList.add('active');
        }

        function closeLoginModal() {
            document.getElementById('loginModal').classList.remove('active');
        }

        window.onclick = function(event) {
            const modal = document.getElementById('loginModal');
            if (event.target == modal) {
                closeLoginModal();
            }
        }
    </script>
</body>
</html>
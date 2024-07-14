<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    header("Location: ../index.html");
    exit();
}

include('db_connection.php');
$username = $_SESSION['username'];

// Obtener el rol del usuario
$query = "SELECT role FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
$role = $user['role'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Juegos UCSI 2024</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="https://unpkg.com/phosphor-icons">
    <script src="../assets/js/dashboard.js" defer></script>
</head>
<body>
    <div class="app">
        <header class="app-header">
            <div class="app-header-logo">
                <div class="logo">
                    <span class="logo-icon">
                        <img src="https://assets.codepen.io/285131/almeria-logo.svg" />
                    </span>
                    <h1 class="logo-title">
                        <span>Juegos UCSI</span>
                        <span>2024</span>
                    </h1>
                </div>
            </div>
            <div class="app-header-actions">
                <button class="user-profile">
                    <span><?php echo $_SESSION['username']; ?></span>
                    <span>
                        <img src="https://assets.codepen.io/285131/almeria-avatar.jpeg" />
                    </span>
                </button>
            </div>
            <div class="app-header-mobile">
                <button class="icon-button large">
                    <i class="ph-list"></i>
                </button>
            </div>
        </header>
        <div class="app-body">
            <div class="app-body-navigation">
                <nav class="navigation">
                    <a href="#">
                        <i class="ph-browsers"></i>
                        <span>Dashboard</span>
                    </a>
                    <?php if ($role == 'admin') { ?>
                    <a href="../php_frm/register_usuario.html">
                        <i class="ph-check-square"></i>
                        <span>Agregar Usuarios</span>
                    </a>
                    <a href="listar_deportistas.php">
                        <i class="ph-check-square"></i>
                        <span>Listado de Jugadores</span>
                    </a>
                    <a href="../fixture/admin.php">
                        <i class="ph-plus"></i>
                        <span>Crear Fixture</span>
                    </a>
                    <a href="../noche_inaugural/agregar_evento.php">
                        <i class="ph-plus"></i>
                        <span>Noche Inaugural</span>
                    </a>
                    
                    <?php } ?>
                    <?php if ($role == 'delegado' || $role == 'admin') { ?>
                    <a href="../php_frm/register_deportistas.html">
                        <i class="ph-clipboard-text"></i>
                        <span>Registrar Deportistas</span>
                    </a>
                    <?php } ?>
                    <a href="listar_deportistas.php">
                        <i class="ph-check-square"></i>
                        <span>Listado de Jugadores</span>
                    </a>
                    <a href="logout.php">
                        <i class="ph-sign-out"></i>
                        <span>Cerrar Sesión</span>
                    </a>
                </nav>
                <footer class="footer">
                    <h1>Juegos UCSI<small>©</small></h1>
                    <div>
                        Juegos UCSI 2024 ©<br />
                        All Rights Reserved 2024
                    </div>
                </footer>
            </div>
            <div class="app-body-main-content">
                <h2>Bienvenido, <?php echo $role == 'admin' ? 'Administrador' : 'Delegado'; ?></h2>
                <!-- Aquí puedes agregar el contenido principal del dashboard -->
            </div>
        </div>
    </div>
</body>
</html>

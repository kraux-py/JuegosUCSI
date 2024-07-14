<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.html");
    exit();
}

include('db_connection.php');
$username = $_SESSION['username'];

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
    <title>Admin - Juegos UCSI 2024</title>
    <link rel="stylesheet" href="../assets/css/fixturead.css">
</head>
<body>
    <div class="container">
        <h1>Panel de Administración</h1>
        <div class="button-container">
            <?php if ($role == 'admin'): ?>
                <a href="agregar_fixture.php" class="btn">Agregar Partidos</a>
            <?php endif; ?>
            <a href="listar_fixture.php" class="btn">Ver Fixture</a>
            <a href="agregar_categoria.php" class="btn">Agregar Categoría</a>
            <a href="crear_fixture.php" class="btn">Crear Fixture dependiendo el dia</a>
            <a href="javascript:history.back()" class="btn">Volver</a>

        </div>
    </div>
</body>
</html>

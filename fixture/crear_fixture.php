<?php
include('db_connection.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $query = "INSERT INTO fixtures (nombre) VALUES ('$nombre')";
    if (mysqli_query($conn, $query)) {
        header('Location: listar_fixture.php');
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Fixture - Juegos UCSI 2024</title>
    <link rel="stylesheet" href="../assets/css/forms.css">
</head>
<body>
    <h1>Crear Fixture</h1>
    <form action="crear_fixture.php" method="post">
        <label for="nombre">Nombre del Fixture:</label>
        <input type="text" id="nombre" name="nombre" required>
        <button type="submit">Crear Fixture</button>
    </form>
    <a href="dashboard.php" class="button">Volver al Dashboard</a>
</body>
</html>

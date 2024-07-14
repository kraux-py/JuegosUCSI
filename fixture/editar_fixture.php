<?php
include('db_connection.php');
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.html");
    exit();
}

$id = $_GET['id'];
$query = "SELECT * FROM fixture WHERE id = $id";
$result = mysqli_query($conn, $query);
$fixture = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $equipo1 = $_POST['equipo1'];
    $equipo2 = $_POST['equipo2'];
    $score1 = $_POST['score1'];
    $score2 = $_POST['score2'];

    $query = "UPDATE fixture 
              SET fecha = '$fecha', hora = '$hora', equipo1 = '$equipo1', equipo2 = '$equipo2', 
                  score1 = '$score1', score2 = '$score2'
              WHERE id = $id";

    if (mysqli_query($conn, $query)) {
        header("Location: listar_fixture.php");
        exit();
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
    <title>Editar Fixture - Juegos UCSI 2024</title>
    <link rel="stylesheet" href="../assets/css/forms.css">
</head>
<body>
    <h1>Editar Fixture</h1>
    <form action="editar_fixture.php?id=<?php echo $id; ?>" method="post">
        <label for="fecha">Fecha:</label>
        <input type="date" id="fecha" name="fecha" value="<?php echo $fixture['fecha']; ?>" required>
        
        <label for="hora">Hora:</label>
        <input type="time" id="hora" name="hora" value="<?php echo $fixture['hora']; ?>" required>
        
        <label for="equipo1">Equipo 1:</label>
        <input type="text" id="equipo1" name="equipo1" value="<?php echo $fixture['equipo1']; ?>" required>
        
        <label for="equipo2">Equipo 2:</label>
        <input type="text" id="equipo2" name="equipo2" value="<?php echo $fixture['equipo2']; ?>" required>
        
        <label for="score1">Puntuación Equipo 1:</label>
        <input type="number" id="score1" name="score1" value="<?php echo $fixture['score1']; ?>" required>
        
        <label for="score2">Puntuación Equipo 2:</label>
        <input type="number" id="score2" name="score2" value="<?php echo $fixture['score2']; ?>" required>
        
        <button type="submit">Actualizar Partido</button>
        <a href="javascript:history.back()" class="btn">Volver</a>
    </form>
</body>
</html>

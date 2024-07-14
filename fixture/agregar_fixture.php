<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('db_connection.php');
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../index.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $equipo1 = $_POST['equipo1'];
    $equipo2 = $_POST['equipo2'];
    $score1 = $_POST['score1'];
    $score2 = $_POST['score2'];
    $categoria_id = $_POST['categoria_id'];
    $fixture_id = $_POST['fixture_id'];

    $query = "INSERT INTO fixture (fecha, hora, equipo1, equipo2, score1, score2, categoria_id, fixture_id) 
              VALUES ('$fecha', '$hora', '$equipo1', '$equipo2', '$score1', '$score2', '$categoria_id', '$fixture_id')";

    if (mysqli_query($conn, $query)) {
        echo "Partido agregado exitosamente.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

$categorias_query = "SELECT * FROM categorias";
$categorias_result = mysqli_query($conn, $categorias_query);

$fixtures_query = "SELECT * FROM fixtures";
$fixtures_result = mysqli_query($conn, $fixtures_query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Fixture - Juegos UCSI 2024</title>
    <link rel="stylesheet" href="../assets/css/forms.css">
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap");

        :root {
            --white: #ffffff;
            --light-gray: #f9f9f9;
            --gray: #333;
            --blue: #007BFF;
            --dark-blue: #0056b3;
            --light-blue: #a3d0ff;
            --border-radius: 8px;
            --box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        body {
            background: var(--light-blue);
            font-family: Roboto, sans-serif;
            color: var(--gray);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 20px;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        h1 {
            text-align: center;
            margin-bottom: 2rem;
            font-size: 2rem;
            color: var(--blue);
        }

        .container {
            background: var(--white);
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 2rem;
            max-width: 600px;
            width: 100%;
            text-align: center;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: var(--white);
            background-color: var(--blue);
            text-align: center;
            text-decoration: none;
            border-radius: var(--border-radius);
            margin-top: 1rem;
            transition: background-color 0.3s ease, transform 0.2s;
        }

        .button:hover {
            background-color: var(--dark-blue);
            transform: translateY(-2px);
        }

        form {
            background: var(--light-gray);
            padding: 2rem;
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            text-align: left;
        }

        form label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
            color: var(--gray);
        }

        form input[type="text"],
        form input[type="password"],
        form input[type="number"],
        form select {
            width: 100%;
            padding: 0.5rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: var(--border-radius);
            box-sizing: border-box;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        form input[type="text"]:focus,
        form input[type="password"]:focus,
        form input[type="number"]:focus,
        form select:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25);
        }

        form input[type="submit"],
        button[type="submit"] {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background: var(--blue);
            color: var(--white);
            border: none;
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s;
        }

        form input[type="submit"]:hover,
        button[type="submit"]:hover {
            background: var(--dark-blue);
            transform: translateY(-2px);
        }

        .category-field {
            margin-bottom: 1rem;
        }

        .category-field label {
            margin-bottom: 0.25rem;
        }

        .category-field select {
            width: calc(100% - 1rem);
        }

        form .info-text {
            font-size: 0.875rem;
            color: #555;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <h1>Agregar Fixture</h1>
    <form action="agregar_fixture.php" method="post">
        <label for="fecha">Fecha:</label>
        <input type="date" id="fecha" name="fecha" required>
        
        <label for="hora">Hora:</label>
        <input type="time" id="hora" name="hora" required>
        
        <label for="equipo1">Equipo 1:</label>
        <input type="text" id="equipo1" name="equipo1" required>
        
        <label for="equipo2">Equipo 2:</label>
        <input type="text" id="equipo2" name="equipo2" required>
        
        <label for="score1">Puntuación Equipo 1:</label>
        <input type="number" id="score1" name="score1" required>
        
        <label for="score2">Puntuación Equipo 2:</label>
        <input type="number" id="score2" name="score2" required>
        
        <label for="categoria_id">Categoría:</label>
        <select id="categoria_id" name="categoria_id" required>
            <?php while($categoria = mysqli_fetch_assoc($categorias_result)): ?>
                <option value="<?php echo $categoria['id']; ?>"><?php echo $categoria['nombre']; ?></option>
            <?php endwhile; ?>
        </select>
        
        <label for="fixture_id">Seleccionar Fixture:</label>
        <select id="fixture_id" name="fixture_id" required>
            <?php while($fixture = mysqli_fetch_assoc($fixtures_result)): ?>
                <option value="<?php echo $fixture['id']; ?>"><?php echo $fixture['nombre']; ?></option>
            <?php endwhile; ?>
        </select>
        
        <button type="submit">Agregar Partido</button>
        <a href="javascript:history.back()" class="btn">Volver</a>
    </form>
</body>
</html>

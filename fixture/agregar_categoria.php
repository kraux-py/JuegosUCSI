<?php
include('db_connection.php');
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];

    $query = "INSERT INTO categorias (nombre) VALUES ('$nombre')";

    if (mysqli_query($conn, $query)) {
        echo "Categoría agregada exitosamente.";
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
    <title>Agregar Categoría - Juegos UCSI 2024</title>
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
    <div class="container">
        <h1>Agregar Categoría</h1>
        <form action="agregar_categoria.php" method="post">
            <label for="nombre">Nombre de la Categoría:</label>
            <input type="text" id="nombre" name="nombre" required>
            <button type="submit">Agregar Categoría</button>
            <a href="javascript:history.back()" class="btn">Volver</a>
        </form>
    </div>
</body>
</html>


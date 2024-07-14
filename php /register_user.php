<?php
include('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Escapar entradas para evitar inyecciones SQL
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);
    $role = mysqli_real_escape_string($conn, $role);

    // Insertar usuario en la base de datos
    $query = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";
    if (mysqli_query($conn, $query)) {
        echo "Usuario registrado exitosamente.";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}
?>
<?php
// register_deportista.php

// Aquí iría tu lógica de registro, por ejemplo:
// conectar a la base de datos
// insertar los datos del deportista
// cerrar la conexión a la base de datos

// Si el registro es exitoso, muestra el mensaje y redirige
echo '<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Exitoso</title>
    <style>
        .message {
            position: fixed;
            top: 20%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background-color: #dff0d8;
            color: #3c763d;
            border: 1px solid #d6e9c6;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="message">Registro exitoso. Serás redirigido al dashboard ...</div>
    <script>
        setTimeout(function() {
            window.location.href = "dashboard.php"; // Cambia esto a la ruta de tu dashboard
        }, 2000);
    </script>
</body>
</html>';
?>

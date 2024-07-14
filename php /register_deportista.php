<?php
include('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $edad = $_POST['edad'];
    $numero_cedula = $_POST['numero_cedula'];
    $universidad = $_POST['universidad'];
    $numero_remera = $_POST['numero_remera'];
    $modalidades = $_POST['modalidades'];

    // Escapar entradas para evitar inyecciones SQL
    $nombre = mysqli_real_escape_string($conn, $nombre);
    $apellido = mysqli_real_escape_string($conn, $apellido);
    $edad = mysqli_real_escape_string($conn, $edad);
    $numero_cedula = mysqli_real_escape_string($conn, $numero_cedula);
    $universidad = mysqli_real_escape_string($conn, $universidad);
    $numero_remera = mysqli_real_escape_string($conn, $numero_remera);

    // Concatenar categorías seleccionadas y verificar cada una
    $categorias = [];
    $duplicado = false;
    for ($i = 1; $i <= $modalidades; $i++) {
        $categoria = mysqli_real_escape_string($conn, $_POST["categoria$i"]);
        $categorias[] = $categoria;

        // Verificar si el deportista ya está registrado en esta categoría
        $query = "SELECT * FROM deportistas WHERE nombre = '$nombre' AND apellido = '$apellido' AND categorias LIKE '%$categoria%'";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            $duplicado = true;
            break;
        }
    }

    if ($duplicado) {
        // Deportista duplicado encontrado
        echo "<script>
            alert('El deportista ya está registrado en una de las modalidades seleccionadas.');
            setTimeout(function() {
                window.location.href = '../register_deportista.html';
            }, 2000);
        </script>";
    } else {
        // Insertar deportista en la base de datos
        $categorias_string = implode(',', $categorias);
        $query = "INSERT INTO deportistas (nombre, apellido, edad, numero_cedula, universidad, numero_remera, categorias) VALUES ('$nombre', '$apellido', '$edad', '$numero_cedula', '$universidad', '$numero_remera', '$categorias_string')";
        if (mysqli_query($conn, $query)) {
            echo "<script>
                alert('Deportista registrado exitosamente.');
                setTimeout(function() {
                    window.location.href = 'dashboard.php';
                }, 2000);
            </script>";
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
        }
    }
}
?>

<?php
include('db_connection.php');
session_start();

if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
    $query = "DELETE FROM fixture";
    if (mysqli_query($conn, $query)) {
        header('Location: listar_fixture.php');
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "No tienes permisos para realizar esta acción.";
}
?>

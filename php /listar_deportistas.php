<?php
include('db_connection.php');

$universidad = isset($_GET['universidad']) ? $_GET['universidad'] : '';
$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';

// Construir consulta SQL con filtros
$query = "SELECT * FROM deportistas WHERE 1=1";

if ($universidad != '') {
    $query .= " AND universidad = '$universidad'";
}

if ($categoria != '') {
    $query .= " AND categorias LIKE '%$categoria%'";
}

$result = mysqli_query($conn, $query);

// Verificar si hay errores en la consulta
if (!$result) {
    die("Error en la consulta: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Deportistas - Juegos UCSI 2024</title>
    <link rel="stylesheet" href="../assets/css/listado.css">
    <style>
        .filter-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Listado de Deportistas</h1>
    <div class="filter-container">
        <form method="GET" action="listar_deportistas.php">
            <label for="universidad">Universidad:</label>
            <select id="universidad" name="universidad">
                <option value="">Todas</option>
                <option value="UCSI" <?php if ($universidad == 'UCSI') echo 'selected'; ?>>UCSI</option>
                <option value="FCA" <?php if ($universidad == 'FCA') echo 'selected'; ?>>FCA</option>
                <option value="UNA" <?php if ($universidad == 'UNA') echo 'selected'; ?>>UNA</option>
            </select>
            
            <label for="categoria">Categoría:</label>
            <select id="categoria" name="categoria">
                <option value="">Todas</option>
                <option value="handball" <?php if ($categoria == 'handball') echo 'selected'; ?>>Handball</option>
                <option value="futsal" <?php if ($categoria == 'futsal') echo 'selected'; ?>>Futsal</option>
                <option value="futbol" <?php if ($categoria == 'futbol') echo 'selected'; ?>>Fútbol de campo</option>
                <option value="basket" <?php if ($categoria == 'basket') echo 'selected'; ?>>Basket</option>
                <option value="volley" <?php if ($categoria == 'volley') echo 'selected'; ?>>Volley</option>
            </select>
            
            <input type="submit" value="Filtrar">
            <a href="javascript:history.back()" class="button">Volver</a>
        </form>
    </div>
    
    <table>
        <tr>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Edad</th>
            <th>Número de Cédula</th>
            <th>Universidad</th>
            <th>Número de Remera</th>
            <th>Categorías</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo htmlspecialchars($row['nombre']); ?></td>
            <td><?php echo htmlspecialchars($row['apellido']); ?></td>
            <td><?php echo htmlspecialchars($row['edad']); ?></td>
            <td><?php echo htmlspecialchars($row['numero_cedula']); ?></td>
            <td><?php echo htmlspecialchars($row['universidad']); ?></td>
            <td><?php echo htmlspecialchars($row['numero_remera']); ?></td>
            <td><?php echo htmlspecialchars($row['categorias']); ?></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>

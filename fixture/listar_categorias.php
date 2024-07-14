<?php
include('db_connection.php');
session_start();

// Obtener categorías
$categorias_query = "SELECT * FROM categorias";
$categorias_result = mysqli_query($conn, $categorias_query);

// Verificar si hay una categoría seleccionada
$categoria_id = isset($_GET['categoria_id']) ? $_GET['categoria_id'] : 0;

// Consulta para obtener fixtures según la categoría seleccionada
if ($categoria_id) {
    $query = "SELECT f.*, c.nombre as categoria FROM fixture f LEFT JOIN categorias c ON f.categoria_id = c.id WHERE f.categoria_id = $categoria_id";
} else {
    $query = "SELECT f.*, c.nombre as categoria FROM fixture f LEFT JOIN categorias c ON f.categoria_id = c.id";
}

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error en la consulta: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fixture - Juegos UCSI 2024</title>
    <link rel="stylesheet" href="../assets/css/fixture.css">
    <style>
        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            background-color: #007BFF;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
            margin-right: 10px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }

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

        .r18-actions a {
            display: inline-block;
            padding: 5px 10px;
            font-size: 14px;
            color: white;
            background-color: #007BFF;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 5px;
            transition: background-color 0.3s ease;
        }

        .r18-actions a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Fixture de los Juegos UCSI 2024</h1>
    
    <form method="get" action="listar_fixture.php">
        <label for="categoria_id">Seleccionar Categoría:</label>
        <select id="categoria_id" name="categoria_id" onchange="this.form.submit()">
            <option value="0">Todas las Categorías</option>
            <?php while($categoria = mysqli_fetch_assoc($categorias_result)): ?>
                <option value="<?php echo $categoria['id']; ?>" <?php if($categoria['id'] == $categoria_id) echo 'selected'; ?>><?php echo $categoria['nombre']; ?></option>
            <?php endwhile; ?>
        </select>
    </form>

    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
        <a href="eliminar_todos_fixture.php" class="btn">Eliminar Todos los Fixtures</a>
    <?php endif; ?>

    <div class="r18-container">
        <?php if(mysqli_num_rows($result) > 0): ?>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
                <div class="r18-items">
                    <div class="r18-time">
                        <div class="r18-hour"><?php echo $row['hora']; ?></div>
                        <div class="r18-text">
                            <span><?php echo date('l', strtotime($row['fecha'])); ?></span>
                            <span><?php echo date('d F', strtotime($row['fecha'])); ?></span>
                        </div>
                    </div>
                    <div class="r18-separator"></div>
                    <div class="r18-columns">
                        <div class="r18-team-l" data-score="<?php echo $row['score1']; ?>">
                            <span class="r18-name"><?php echo $row['equipo1']; ?></span>
                            <span class="r18-score"><?php echo $row['score1']; ?></span>
                        </div>
                        <div class="r18-team-r" data-score="<?php echo $row['score2']; ?>">
                            <span class="r18-score"><?php echo $row['score2']; ?></span>
                            <span class="r18-name"><?php echo $row['equipo2']; ?></span>
                        </div>
                    </div>
                    <div class="r18-text">
                        <span>Categoría: <?php echo $row['categoria']; ?></span>
                    </div>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                        <div class="r18-actions">
                            <a href="editar_fixture.php?id=<?php echo $row['id']; ?>">Editar</a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No hay fixtures disponibles para esta categoría.</p>
        <?php endif; ?>
        <a href="javascript:history.back()" class="btn">Volver</a>
    </div>
</body>
</html>

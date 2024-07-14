<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('db_connection.php');
session_start();

// Obtener categorías y fixtures
$categorias_query = "SELECT * FROM categorias";
$categorias_result = mysqli_query($conn, $categorias_query);

$fixtures_query = "SELECT * FROM fixtures";
$fixtures_result = mysqli_query($conn, $fixtures_query);

// Verificar si hay una categoría seleccionada
$categoria_id = isset($_GET['categoria_id']) ? $_GET['categoria_id'] : 0;
$fixture_id = isset($_GET['fixture_id']) ? $_GET['fixture_id'] : 0;

// Consulta para obtener fixtures según la categoría seleccionada
if ($fixture_id) {
    $query = "SELECT f.*, c.nombre as categoria FROM fixture f LEFT JOIN categorias c ON f.categoria_id = c.id WHERE f.fixture_id = $fixture_id";
} else {
    $query = "SELECT f.*, c.nombre as categoria FROM fixture f LEFT JOIN categorias c ON f.categoria_id = c.id";
}

$result = mysqli_query($conn, $query);

// Obtener eventos de la noche inaugural
$noche_inaugural_query = "SELECT * FROM noche_inaugural ORDER BY fecha, hora";
$noche_inaugural_result = mysqli_query($conn, $noche_inaugural_query);

if (!$result || !$noche_inaugural_result) {
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
        
        <label for="fixture_id">Seleccionar Fixture:</label>
        <select id="fixture_id" name="fixture_id" onchange="this.form.submit()">
            <option value="0">Noche Inaugural</option>
            <?php while($fixture = mysqli_fetch_assoc($fixtures_result)): ?>
                <option value="<?php echo $fixture['id']; ?>" <?php if($fixture['id'] == $fixture_id) echo 'selected'; ?>><?php echo $fixture['nombre']; ?></option>
            <?php endwhile; ?>
        </select>
    </form>

    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
        <a href="eliminar_todos_fixture.php" class="r18-actions">Eliminar Todos los Fixtures</a>
    <?php endif; ?>

    <div class="r18-container">
        <?php if ($fixture_id == 0): ?>
            <h2>Eventos de la Noche Inaugural</h2>
            <?php if(mysqli_num_rows($noche_inaugural_result) > 0): ?>
                <?php while($evento = mysqli_fetch_assoc($noche_inaugural_result)): ?>
                    <div class="r18-items">
                        <div class="r18-time">
                            <div class="r18-hour"><?php echo $evento['hora']; ?></div>
                            <div class="r18-text">
                                <span><?php echo date('l', strtotime($evento['fecha'])); ?></span>
                                <span><?php echo date('d F', strtotime($evento['fecha'])); ?></span>
                            </div>
                        </div>
                        <div class="r18-separator"></div>
                        <div class="r18-text">
                            <span><?php echo $evento['descripcion']; ?></span>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No hay eventos disponibles para la noche inaugural.</p>
            <?php endif; ?>
        <?php else: ?>
            <h2>Partidos del Fixture</h2>
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
        <?php endif; ?>
        <a href="javascript:history.back()" class="r18-actions">Volver</a>
    </div>
</body>
</html>

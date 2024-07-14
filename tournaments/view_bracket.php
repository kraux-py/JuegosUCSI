<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('db_connection.php');

$tournament_id = isset($_GET['tournament_id']) ? $_GET['tournament_id'] : 0;

if ($tournament_id == 0) {
    echo "No se ha especificado un torneo.";
    exit;
}

// Verificar si el usuario ha iniciado sesión y su rol
if (!isset($_SESSION['username'])) {
    header("Location: ../index.html");
    exit();
}

$username = $_SESSION['username'];
$query = "SELECT role FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
$role = $user['role'];

// Obtener todos los partidos del torneo
$query = "SELECT m.id, t1.name AS team1_name, t2.name AS team2_name, m.round 
          FROM matches m 
          JOIN teams t1 ON m.team1_id = t1.id 
          JOIN teams t2 ON m.team2_id = t2.id 
          WHERE m.tournament_id = $tournament_id 
          ORDER BY m.round, m.id";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error al obtener los partidos: " . mysqli_error($conn));
}

$matches = [];
while ($row = mysqli_fetch_assoc($result)) {
    $matches[$row['round']][] = [
        'team1_name' => $row['team1_name'],
        'team2_name' => $row['team2_name']
    ];
}

// Verificar si se obtuvieron partidos
if (empty($matches)) {
    echo "No se encontraron partidos para este torneo.";
    exit;
}

// Preparar los datos para Bracket.js
$teams = [];
$results = [];

foreach ($matches as $round => $match_list) {
    $round_results = [];
    foreach ($match_list as $match) {
        $team1 = isset($match['team1_name']) ? $match['team1_name'] : "TBD";
        $team2 = isset($match['team2_name']) ? $match['team2_name'] : "TBD";
        $teams[] = [$team1, $team2];
        $round_results[] = [null, null];
    }
    $results[] = $round_results;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Llaves del Torneo - Juegos UCSI 2024</title>
    <link rel="stylesheet" href="../assets/css/forms.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-bracket/0.11.0/jquery.bracket.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-bracket/0.11.0/jquery.bracket.min.js"></script>
    <style>
        body {
            background-color: #2C2F33;
            color: #FFFFFF;
            font-family: Arial, sans-serif;
            text-align: center;
        }
        h1 {
            color: #7289DA;
        }
        .bracket-container {
            margin: 0 auto;
            max-width: 1200px;
            overflow-x: auto;
            padding: 20px;
        }
        .bracket-container .bracket {
            background-color: #23272A;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            min-width: 1000px;
        }
        .btn {
            background-color: #7289DA;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 20px 2px;
            cursor: pointer;
            border-radius: 8px;
        }
        .btn:hover {
            background-color: #5b6eae;
        }
        .navbar {
            display: flex;
            justify-content: center;
            background-color: #23272A;
            padding: 10px;
            border-bottom: 2px solid #7289DA;
        }
        .navbar a {
            color: #FFFFFF;
            padding: 10px 20px;
            text-decoration: none;
            font-size: 16px;
        }
        .navbar a:hover {
            background-color: #5b6eae;
            border-radius: 8px;
        }
        /* Estilos para los boxes de los equipos */
        .jqBracket .team {
            background-color: rgba(85, 85, 85, 0.8) !important; /* Fondo gris oscuro con opacidad */
            color: #FFF !important; /* Texto blanco */
            padding: 5px !important;
            font-size: 14px !important;
            border-radius: 4px !important;
            text-align: center !important;
        }
        .jqBracket .connector {
            background-color: #7289DA !important;
        }
        .jqBracket .match {
            margin-bottom: 10px !important;
        }
        .jqBracket .score {
            background-color: rgba(255, 92, 0, 0.8) !important; /* Fondo naranja con opacidad */
            color: #FFF !important; /* Texto blanco */
            border-radius: 4px !important;
            padding: 5px !important;
        }
        .jqBracket .round {
            background-color: transparent !important;
        }
        .jqBracket .match .team .label {
            color: #FFF !important; /* Color del texto de los equipos */
        }
        .round-title {
            color: #7289DA;
            font-size: 1.5rem;
            margin: 10px 0;
        }
        .bracket {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }
        .bracket > div {
            text-align: center;
        }
    </style>
</head>
<body>
    <header class="navbar">
        <a href="../index.html">Inicio</a>
        <a href="select_tournament.php">Seleccionar Torneo</a>
        <a href="view_fixture.php?tournament_id=<?php echo $tournament_id; ?>">Ver Fixture</a>
    </header>
    <h1>Llaves del Torneo</h1>
    <div class="bracket-container">
        <div id="tournament-bracket" class="bracket"></div>
    </div>

    <script>
        $(function() {
            const data = {
                teams: <?php echo json_encode($teams); ?>,
                results: <?php echo json_encode($results); ?>
            };

            console.log(data); // Depuración en el navegador

            const saveFn = <?php echo $role == 'admin' ? 'function(data) {
                $.ajax({
                    type: "POST",
                    url: "update_bracket.php",
                    data: { data: JSON.stringify(data), tournament_id: ' . $tournament_id . ' },
                    success: function(response) {
                        console.log("Guardado con éxito:", response);
                    },
                    error: function(error) {
                        console.error("Error al guardar:", error);
                    }
                });
            }' : 'null'; ?>;

            $('#tournament-bracket').bracket({
                init: data,
                teamWidth: 140,
                scoreWidth: 30,
                matchMargin: 30,
                roundMargin: 50,
                save: saveFn
            });
        });
    </script>
</body>
</html>

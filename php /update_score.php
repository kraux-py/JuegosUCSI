<?php
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $match_id = $_POST['match_id'];
    $team = $_POST['team'];
    $score = $_POST['score'];

    $score_field = $team == '1' ? 'score1' : 'score2';
    
    $query = "UPDATE matches SET $score_field = '$score' WHERE id = '$match_id'";
    if (mysqli_query($conn, $query)) {
        echo "Score updated successfully.";
    } else {
        echo "Error updating score: " . mysqli_error($conn);
    }
}
?>

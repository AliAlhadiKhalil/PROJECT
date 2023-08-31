<?php
require 'config.php';
// Retrieve the quiz results from the database
$sql = "SELECT * FROM scores WHERE quiz_id=$quiz_id ORDER BY score DESC";
$result = $conn->query($sql);

// Check for errors with the query
if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Quiz Scores</title>
    <link rel="stylesheet" href="./css/score.css">
</head>
<body>
    <h1><?php echo $quiz_title; ?> Scores</h1>
    <table>
        <tr>
            <th>id</th>
            <th>Username</th>
            <th>Last Top Scores</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) {
            
            $query="SELECT * FROM users WHERE user_id={$row['user_id']}";
            $s=$conn->query($query);
            $z=$s->fetch_assoc()?>
            <tr>
                <td><?php echo $row['user_id']; ?></td>
                <td><?php echo $z['username']; ?></td>
                <td><?php echo $row['score'].'/100'; ?></td>
                
            </tr>
    
        <?php } ?>
    </table>
    <?php $conn->close(); ?>
</body>
</html>
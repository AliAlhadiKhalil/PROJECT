<!DOCTYPE html>
<html>
<head>
	<title>Results</title>
	<link rel="stylesheet" type="text/css" href="./css/showResult.css">
	<style>
		button{
			background-color: #005f99;
			border-radius: 5px;
			color: #fff;
			display: inline-block;
			font-weight: bold;
			padding: 0.5rem 1rem;
			text-decoration: none;
			transition: background-color 0.3s ease;
		}
	</style>
</head>

<body>
	<div class="container">
		<h1>Score</h1>
		<div class="score-details">
			<?php
			require 'config.php';
			// Retrieve the score, name, and ID from the URL parameters
            $incorrect=$_SESSION['incorrect'];
            
			$score = $_SESSION['score'];
			$name = $_SESSION['user_name'];
			$id = $_SESSION['user_id'];

			// Display the score, name, and ID
			echo '<p style="display:inline-block;" >Username: <span>' . $name . '</span></p>';
			echo '<p style="display:inline-block;" >ID: <span>' . $id . '</span></p>';
			echo '<p style="display:inline-block;" >Score: <span>'. $score .'/100</span></p>';
            echo '<p>Incorrect Questions:';
            echo '<span><ol>';
            foreach ($incorrect as $q) {
                $query="SELECT * FROM questions WHERE question_id=$q";
                $c=$conn->query($query);
                $r=$c->fetch_assoc();
                echo '<li>' . $r['question_text'] . '</li>';
            }
            echo '</ol></span></p>';
			?>
		</div>
		<button onclick="window.location.href = 'quizzes.php'">return to quizzes page</button>
	</div>
</body>
</html>
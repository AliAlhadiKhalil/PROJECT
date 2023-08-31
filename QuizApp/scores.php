
<?php
    require 'config.php';
	if (!isset($_SESSION['user_email'])) {
		header('Location: index.php');
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Quiz App - Scores</title>
	<link rel="stylesheet" type="text/css" href="./css/styless.css">
</head>
<body>
	<header>
		<h1>Quiz App</h1>
		<nav>
			<ul>
				<li>
					<div class="nav-item">
						<span>Id:</span>
						<span><?php echo ' '.$_SESSION['user_id'];?></span>
					</div>
				</li>
				<li>
					<div class="nav-item">
						<span>Username:</span>
						<span><?php echo ' '.$_SESSION['user_name'];?></span>
					</div>
				</li>
				<li><a href="quizzes">Quizzes</a></li>
				<li><a href="scores">Scores</a></li>
				<li><a href="profile">Profile</a></li>
				<li><a href="settings">Settings</a></li>
			</ul>
		</nav>
	</header>
	<main>
		<h2>quiz scores:</h2>
		<ul>
			<li><a href="scoreGeneralKnowledge.php">GeneralKnowledge</a></li>
			<li><a href="scoreMath.php">Math</a></li>
			<li><a href="scoreGeography.php">Geography</a></li>
			<li><a href="scoreScience.php">Science</a></li>
		</ul>
	</main>
	<footer>
		<p>&copy; 2023 Quiz App</p>
	</footer>
</body>
</html>

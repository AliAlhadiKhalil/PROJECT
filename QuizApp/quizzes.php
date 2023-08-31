<?php
    require 'config.php';
	if (!isset($_SESSION['user_email'])) {
		header('Location: index.php');
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Quiz App - Quizzes</title>
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
		<h2>Welcome to Quiz App</h2>
		<h3>Quizzes:</h3>
		<div class="quiz-container">
			<div class="quiz-card">
				<h3>General Knowledge Quiz</h3>
				<p>Test your general knowledge of a variety of topics</p>
				<a href="questionsGeneralKnowledge.php">Start Quiz</a>
			</div>
			<div class="quiz-card">
				<h3>Math Quiz</h3>
				<p>Test your knowledge of world of math</p>
				<a href="questionsMath.php">Start Quiz</a>
			</div>
			<div class="quiz-card">
				<h3>Geography Quiz</h3>
				<p>Test your knowledge of geography and planet</p>
				<a href="questionsGeography.php">Start Quiz</a>
			</div>
			<div class="quiz-card">
				<h3>Science Quiz</h3>
				<p>Test your knowledge of science and technology</p>
				<a href="questionsScience.php">Start Quiz</a>
			</div>
			
			
		</div>
	</main>
	<footer>
		<p>&copy; 2023 Quiz App</p>
	</footer>
</body>
</html>
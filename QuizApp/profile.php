<?php
require 'config.php';
// Check if user is logged in
if (!isset($_SESSION['user_email'])) {
	header("Location: login.php");
	exit();
}

// Get user's profile information from the session
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
$user_email = $_SESSION['user_email'];

// Retrieve the user's quiz scores from the database
$sql = "SELECT * FROM scores WHERE user_id='$user_id'";
$result = $conn->query($sql);

// Check for errors with the query
if (!$result) {
    die("Query failed: " . $conn->error);
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Quiz App - Profile</title>
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
		<div class="profile-box">
			<h1><?php echo $user_name; ?></h2>

			<h2>Your Quiz Scores</h2>
			<table>
				<tr>
					<th>Quiz Name</th>
					<th>Score</th>
				</tr>
				<?php while ($row = $result->fetch_assoc()):
				$query = "SELECT * FROM quizzes WHERE quiz_id='{$row['quiz_id']}'";
				$res = $conn->query($query); 
				$r=$res->fetch_assoc();
				?>
					<tr>
						<td><?php echo $r['quiz_name']; ?></td>
						<td><?php echo $row['score'].'/100'; ?></td>
					</tr>
				<?php endwhile; ?>
			</table>
		</div>
	</main>
	<footer>
		<p>&copy; 2023 Quiz App</p>
	</footer>
</body>
</html>

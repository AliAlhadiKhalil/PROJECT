<?php
	require 'config.php';
	if(isset($_POST['submit'])){
		$email = $_POST['Email'];
		$password = $_POST['Password'];
		$query="SELECT * FROM users WHERE email='$email' ";
		$result=$conn->query($query);
		$row=$result->fetch_assoc();
		if($row){
			if(password_verify($password, $row['password'])){
				$_SESSION['user_id']= $row['user_id'];
				$_SESSION['user_name']= $row['username'];
				$_SESSION['user_email'] = $row['email'];
				$_SESSION['user_password']= $row['password'];
				header('location: quizzes.php');
				exit(); // add this to stop executing the rest of the code
			}
			else{
				echo "<script> alert('Wrong password');</script>";
			}
		} 
		else {
			echo "<script> alert('User not registered');</script>";
		}
	} 
 $conn->close();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login - Quiz App</title>
	<link rel="stylesheet" href="./css/loginn.css">
</head>
<body>
	<div class="container">
		<h1>Login</h1>
		<form method="post">
			<label for="email">Email:</label>
			<input type="email" id="email" name="Email" required>
			<label for="password">Password:</label>
			<input type="password" id="password" name="Password" required>
			<input type="submit" name="submit" value="Login" class="btn">
		</form>
		<p>Don't have an account? <a href="register.php">Register here</a>.</p>
	</div>
</body>
</html>


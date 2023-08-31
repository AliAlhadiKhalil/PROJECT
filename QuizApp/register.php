<?php
    require 'config.php';
	function check_user_role($name, $email){
		if($name !=NULL && $email !=NULL){
			$admin_proxy=array('mjf'=> 'mjf@gmail.com','ali khalil'=> 'ali.khalil@hotmail.com', 'mustafa'=> 'mustafa@gmail.com', 'admin'=> 'admin@admin.com');
			if(isset($admin_proxy[$name]) && $admin_proxy[$name] == $email){
				return true;
			}
			
		}
		return false;
	}
	if(isset($_POST['submit'])) {
		$name = $_POST['Name'];
		$email = $_POST['Email'];
		$password = $_POST['Password'];
        $confirmpass = $_POST['confirm_password'];

		$hash = password_hash($password, PASSWORD_BCRYPT);

		$query = "SELECT * FROM users WHERE email='$email'";$results=$conn->query($query);
		$sql = "SELECT * FROM users WHERE username='$name'";$result=$conn->query($sql);
		
		if($results->num_rows > 0) {
            echo "<script> alert('Emailhas already taken'); </script>";
		} else if($result->num_rows > 0) {
            echo "<script> alert('Username has already taken'); </script>";	
		} else if($password == $confirmpass){
				$is_admin = check_user_role($name,$email);
				$sql ='';
				if($is_admin){
					$sql = "INSERT INTO users (username,password, email,  role) VALUES ('$name', '$hash', '$email', 'admin')";
				}else{
					$sql = "INSERT INTO users (username, password, email) VALUES ('$name', '$hash', '$email')";
				}
                $conn->query($sql);
                echo "<script> alert('Registeration Successful'); location.href = 'home.php';</script>";
				$_SESSION['user_email'] = $row['email'];
				header('location: quizzes.php');
            }
            else{
                echo "<script> alert('Password does not match Confirm Password'); </script>";
            }   
	}
        $conn->close();
?>

<!DOCTYPE html>
<html>
    
<head>
	<title>Register - Quiz App</title>
	<link rel="stylesheet" href="./css/loginn.css">
</head>
<body>
	<div class="container">
		<h1>Register</h1>
		<form method="post">
			<label for="name">Username:</label>
			<input type="text" id="name" name="Name" required>
			<label for="email">Email:</label>
			<input type="email" id="email" name="Email" required>
			<label for="password">Password:</label>
			<input type="password" id="password" name="Password" required>
			<label for="confirm_password">Confirm Password:</label>
			<input type="password" id="confirm_password" name="confirm_password" required>
			<input type="submit" name="submit" value="Register" class="btn" >
		</form>
		<p>Already have an account? <a href="index.php">Login here</a>.</p>
	</div>
</body>
</html>
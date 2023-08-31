
<?php
$errors = [];
require 'config.php';
// Check if user is logged in
if (!isset($_SESSION['user_email'])) {
	header("Location: login.php");
	exit();
}

// Get user's profile information from the session
$user_id=$_SESSION['user_id'];;
$user_name = $_SESSION['user_name'];
$user_email = $_SESSION['user_email'];
$user_password = $_SESSION['user_password'];
// Handle form submission
//if ($_SERVER['REQUEST_METHOD'] == 'POST') {
if(isset($_POST["submit"])){
	// Get form data
	$new_name = $_POST['name'];
	$new_email = $_POST['email'];
	$check_password=$_POST['password'];
    $new_password = $_POST['newpassword'];
	// Validate form data
	
    $q="SELECT * FROM users WHERE email='$new_email' AND user_id!='$user_id'";
    $res=$conn->query($q);
	
	if($res->num_rows > 0){
       $errors[] = "there is an account refering to this email ";
    }
	if (empty($new_name)) {
		$errors[] = "Name is required";
	}
    if (password_verify($check_password, $user_password)==false) {
		$errors[] = "enter your correct password";
	}
	if (empty($new_email)) {
		$errors[] = "Email is required";
	} elseif (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
		$errors[] = "Invalid email format";
	}

	// If there are no errors, update the user's profile information
	if (count($errors) == 0) {
        
		$_SESSION['user_name'] = $new_name;
		$_SESSION['user_email'] = $new_email;
		$hash =password_hash($new_password, PASSWORD_BCRYPT);
		$_SESSION['user_password'] = $hash;
		
        $query="UPDATE users SET username='$new_name', password='$hash', email='$new_email', date_registered='NOW()' WHERE user_id='$user_id' ";
        $conn->query($query);
        
		// TODO: Update the user's profile information in the database
		$message = "Profile updated successfully";
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Edit Profile</title>
	<link rel="stylesheet" type="text/css" href="./css/editprofile.css">
</head>
<body>
	<div class="edit-profile-box">
		<h1>Edit Profile</h1>
		
        <br><br>
		<form method="POST">
			<label for="name">Userame:</label>
			<input type="text" name="name" value="<?php echo $user_name; ?>"><br><br>
			<label for="email">Email:</label>
			<input type="email" name="email" value="<?php echo $user_email; ?>"><br><br>
            <label for="password">Password:</label>
			<input type="password" name="password" value=""><br><br>
			<label for="password">New Password:</label>
			<input type="password" name="newpassword" value="">
			
            <br><br>
			<input type="submit" name="submit" value="Save">
		</form>
		<?php if (count($errors) > 0): ?>
				<div class="error-message">
					<?php foreach ($errors as $error): ?>
						<p><?php echo $error; ?></p>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		<?php if (isset($message)): ?>
			<div class="success-message"><?php echo $message; ?></div>
		<?php endif; ?>
	</div>
</body>
</html>
<?php
require 'config.php';
if(isset($_SESSION['user_email'])){
    $email = $_SESSION['user_email'];
    $query = "select * from users where email = '$email'" ;
    $res = $conn->query($query);
    $role = $res->fetch_assoc();
    if($role['role']== "user"){
        echo "<script>alert('you are not admin')</script>";
    } else{

        if(isset($_POST['add_user'])){
            $username=$_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $query = "INSERT INTO users (username,email, password, role) VALUES ('$username','$email', '$hash', 'user')";
            
            $check_email = $conn->query("select * from users where email = '$email'"); //check if the posted email is previously in database
            if($check_email && $check_email->num_rows > 0){ // if >0 then there exist an email
                echo "<script>
                    alert('it seems this email: ".$email." is previously registered! insertion will not be proceed');
                    </script>";
            }
            else if( $check_email->num_rows === 0 && $res = $conn->query($query)){
                echo "<script>
                alert('user ".$username." is added');
                location.href = edit_users.php;
                </script>";
            }else{
                echo "error exists";
            }
        }

        if(isset($_POST['delete_user'])){
            $user_email = $_POST['user_email'];
            $query = "DELETE FROM users WHERE email='$user_email'";
            $check_email = $conn->query("select * from users where email = '$user_email'");
            if($check_email && $check_email->num_rows === 0){
                echo "<script>
                    alert('this email: ".$user_email." is not found!');
                    </script>";
            }
            else if($res = $conn->query($query)){
                echo "<script>
                    alert('user is deleted');
                    location.href = edit_users.php;
                </script>";
            }
            
        } ?>
        <html>
        <head>
            <title>Admin Page</title>
            <link rel="stylesheet" type="text/css" href="./css/edit_users.css">
        </head>
        <body>
            <h1>Welcome Admin!</h1>
            <h2>Add User:</h2>
            <form method="post">
                <label>Username:</label>
                <input type="text" name="username" required>
                <br>
                <label>Email:</label>
                <input type="text" name="email" required>
                <br>
                <label>Password:</label>
                <input type="password" name="password" required>
                <br>
                <input type="submit" name="add_user" value="Add User">
            </form>
            <h2>Delete User:</h2>
            <form method="post">
                <label>User Email:</label>
                <input type="text" name="user_email" required>
                <br>
                <input type="submit" name="delete_user" value="Delete User">
            </form>
        </body>
        </html> 
 
<?php   }
} ?>        
                  


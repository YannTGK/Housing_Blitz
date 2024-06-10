<?php
include_once(__DIR__."/classes/database.php");

if (!empty($_POST)){
    $conn = Db::getConnection();
    // Get the data from POST
    $Username = $_POST['Username'];
    $Password = $_POST['Password'];
    $confirmPassword = $_POST['confirm_password']; // New field for password confirmation
    
    // Check if username and password are not empty
    if (empty($Username) || empty($Password)) {
        $error = "Username and password cannot be empty!";
    }
    // Check if passwords match
    elseif ($Password !== $confirmPassword) {
        $error = "Passwords do not match!";
    } else {
        // Check if the username already exists in the database
        $query = "SELECT * FROM account WHERE username = '$Username'";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            $error = "Username already exists!";
        } else {
            // Hash password with bcrypt
            $options = [
                'cost' => 12
            ];

            $Password = password_hash($Password, PASSWORD_DEFAULT, $options);

            // Send the data to the users table
            $query = "INSERT into account (username, password, role) VALUES('$Username','$password', 'user')";
            $result = $conn->query($query);

            session_start(); // Start session
            $_SESSION['loggedin'] = true;
            header("Location: index.php"); // Redirect to another page after successful submission
            exit; // Make sure to exit after redirection
        }
    }
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign up</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="signup">
        <div class="form form--login">
            <form action="" method="post">
                <h2 form__title>Sign Up</h2>
                <div class="form__field">
                    <label for="Username">Gebruikersnaam</label>
                    <input type="text" name="Username">
                </div>
                <div class="form__field">
                    <label for="Password">Wachtwoord</label>
                    <input type="password" name="Password">
                </div>
                <div class="form__field">
                    <label for="ConfirmPassword">Herhaal wachtwoord</label> <!-- New field for password confirmation -->
                    <input type="password" name="confirm_password">
                </div>

                <?php if(isset($error)): ?> <!-- Display error message if validation fails -->
                    <div class="form__field">
                        <p style="color: red;"><?php echo $error; ?></p>
                    </div>
                <?php endif; ?>

                <div class="form__field">
                    <input type="submit" value="Sign Up" class="btn btn--primary">    
                </div>
            </form>
        </div>
    </div>
	<div class="back">
		<p>Heb je al een account?</p>
		<a href="login.php">login</a>
	</div>
</body>
</html>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once(__DIR__."/classes/database.php");

function canLogin($Pusername, $Ppassword){
    $conn = Db::getConnection();
    $Pusername = $conn->real_escape_string($Pusername);
    $sql = "SELECT password, username, role, firstname, lastname, id, birthday FROM users WHERE username = '$Pusername'";
    $result = $conn->query($sql);

    if ($result === false) {
        // Query is mislukt
        die("Query error: " . $conn->error);
    }

    $user = $result->fetch_assoc();

    if ($user !== null && password_verify($Ppassword, $user['password'])) {
        return $user; 
    } else {
        return false;
    }
}


$error = ""; // Initialize error message variable

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $Username = isset($_POST['Username']) ? $_POST['Username'] : '';
    $Password = isset($_POST['Password']) ? $_POST['Password'] : '';
    $rememberMe = isset($_POST['rememberMe']) ? true : false;

    // Check if username and password are empty
    if(empty($Username) || empty($Password)) {
        $error = "Gebruikersnaam of wachtwoord is leeg!";
    } else {
        $user = canLogin($Username, $Password);
        if($user){
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['role'] = $user['role'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['firstname'] = $user['firstname'];
            $_SESSION['lastname'] = $user['lastname'];
            $_SESSION['birthday'] = $user['birthday'];
            $_SESSION['id'] = $user['id'];
            
            if ($rememberMe) {
                // Set cookies to remember the user for 30 days
                setcookie('username', $user['username'], time() + (86400 * 30), "/");
                setcookie('id', $user['id'], time() + (86400 * 30), "/");
            }

            header("Location: index.php");
            exit; 
        } else {
            $error = "Onjuist wachtwoord of gebruikersnaam";
        }
    }
}
?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login Housing Blitz</title>
        <link rel="stylesheet" href="styles/normalize.css">
        <link rel="stylesheet" href="styles/style.css">
        <link rel="stylesheet" href="styles/login.css">
    </head>
    <body>
        <div class="display">
            <h1>Welkom op <strong>Housing Blitz</strong></h1>
            <h3>Waar jouw kans op woning gezocht wordt</h3>
        </div>    
        <div class="login">
            <div class="loginHolder">
                <div class="loginHeader">
                    <h2>Account Login</h2>
                    <p>Als je al lid bent kan je hier inloggen.</p>
                </div>
                    
                <form class="introLogin" action="login.php" method="post">
                    <div class="form">
                        <label for="Username">Gebruikersnaam</label>
                        <input type="text" id="Username" name="Username" autocomplete="username" required>
                    </div>

                    <div class="form">
                        <label for="Password">Wachtwoord</label>
                        <input type="password" id="Password" name="Password" autocomplete="current-password" required>
                    </div>

                    <div class="checkboxHolder">
                        <input type="checkbox" name="rememberMe" id="rememberMe">
                        <label for="rememberMe">Houd me ingelogd</label>
                    </div>

                    <div class="buttonHolder">
                        <?php if(!empty($error)): ?>
                            <div class="form__error">
                                <p style="color: red;"><?php echo $error; ?></p>
                            </div>
                        <?php endif; ?> 

                        <div class="btn">
                            <input type="submit" value="Login" class="formButton">
                        </div>
                    </div>
                </form>


                <div class="signupinfo">
                    <p>Nog geen account?</p>
                    <a href="signup.php">Signup</a>
                </div>
            </div>
        
        </div>

    </body>
</html>

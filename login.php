<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once(__DIR__."/classes/database.php");

function canLogin($Pusername, $Ppassword){
    $conn = Db::getConnection();
    $Pusername = $conn->real_escape_string($Pusername);
    $sql = "SELECT password, username, role, id FROM account WHERE Username = '$Pusername'";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();
    if ($user !== null && password_verify($Ppassword, $user['password'])) {
        return $user; 
    } else {
        return false;
    }
}

$error = ""; // Initialize error message variable

if(!empty($_POST)){
    $Username = $_POST['Username'];
    $Password = $_POST['Password'];

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
            $_SESSION['id'] = $user['id'];
            header("Location:index.php");
            exit; 
        } else {
            $error = "Onjuist wachtwoord of gebruikersnaam";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Little sun login</title>
    <link rel="stylesheet" href="styles/normalize.css">
</head>
<body>    
    <div class="login">
        <div class="loginHolder">
            <div class="loginInfo">
                <h2>Account Login</h2>
                <?php if(!empty($error)): ?>
                    <div class="form__error">
                        <p style="color: red;"><?php echo $error; ?></p>
                    </div>
                <?php endif; ?> 
            </div>
                
            <form class="introLogin" method="post">
                <div class="form">
                    <label for="Username">Gebruikersnaam</label>
                    <input type="text" name="Username">
                </div>
                <div class="form">
                    <label for="Password">Wachtwoord</label>
                    <input type="password" name="Password">
                </div>

                <div class="btn">
                    <input type="submit" value="Login" class="formButton">
                </div>
            </form>
        </div>
    </div>

    <div class="signup">
        <p>Nog geen account? Maak hier je account aan</p>
        <a href="signup.php">Signup</a>
    </div>
</body>
</html>

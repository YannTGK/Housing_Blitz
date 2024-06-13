<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once(__DIR__."/classes/database.php");
include_once(__DIR__."/classes/user.php");



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
    <title>Housing Blitz Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="welcome-section">
            <h1>Welkom op <strong>Housing Blitz</strong></h1>
            <p>Waar jouw kans op woning gezocht wordt</p>
            <div class="logo">
                <img src="logo-placeholder.png" alt="Holder Logo">
            </div>
        </div>
        <div class="login-section">
    
            <h2>Account Login</h2>
            <p>If you are already a member you can login with your email address and password.</p>
            <form action="login.php" method="POST">
                <label for="email">Email address or phone number</label>
                <input type="text" id="email" name="email" required>
                
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                
                <div class="remember-me">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Remember me</label>
                </div>
                
                <button type="submit">Login</button>
            </form>
            <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
        </div>
    </div>
    <style>
        body {
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-color: #f7f7f7;
}

.container {
    display: flex;
    width: 800px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

.welcome-section {
    background-color: #8c8c8c;
    color: #ffffff;
    padding: 20px;
    width: 50%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
}

.welcome-section h1 {
    margin-bottom: 10px;
}

.welcome-section p {
    margin-bottom: 20px;
}

.welcome-section .logo img {
    max-width: 100px;
}

.login-section {
    background-color: #ffffff;
    padding: 40px;
    width: 50%;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.login-section .back-link {
    text-decoration: none;
    color: #555;
    margin-bottom: 10px;
}

.login-section h2 {
    margin-bottom: 10px;
}

.login-section p {
    margin-bottom: 20px;
    color: #777;
}

.login-section form {
    display: flex;
    flex-direction: column;
}

.login-section label {
    margin-bottom: 5px;
    color: #555;
}

.login-section input[type="text"],
.login-section input[type="password"] {
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.remember-me {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
}

.remember-me input {
    margin-right: 10px;
}

.login-section button {
    padding: 10px;
    background-color: #007bff;
    border: none;
    color: #fff;
    border-radius: 5px;
    cursor: pointer;
}

.login-section button:hover {
    background-color: #0056b3;
}

.login-section a {
    color: #007bff;
    text-decoration: none;
}

.login-section a:hover {
    text-decoration: underline;
}
    </style>
</body>
</html>
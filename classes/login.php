<?php
session_start();
require_once __DIR__ . "/classes/user.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $gebruiker = $_POST['gebruiker'];
    $password = $_POST['password'];

    $user = new User();
    $loggedInUser = $user->login($gebruiker, $password);

    if ($loggedInUser) {
        $_SESSION['user'] = $loggedInUser;
        exit();
    } else {
        echo "Invalid gebruikersnaam of password";
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
    <div class="login-screen">
        <div class="login-right">
            <div class="login-form">
                <h1>Login to your account</h1>
                <form action="login.php" method="post">
                    <label for="gebruiker">Gebruiker</label>
                    <input type="gebruiker" name="gebruiker" placeholder="Gebruiker">
                    <label for="password">Password</label>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit">Login</button>
                </form>
        </div>
    </div>
</body>
</html>

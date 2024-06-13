<?php 
session_start();
if(!isset($_SESSION['loggedin'])){
    header("Location: login.php");
    exit; 
}

// Logout logic
if(isset($_GET['logout'])) {
    session_unset(); // Unset all session variables
    session_destroy(); // Destroy the session
    header("Location: login.php"); // Redirect to the login page
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="styles/normalize.css">
  <link rel="stylesheet" href="styles/style.css">
  <link rel="stylesheet" href="styles/home.css">
  <title>Littlesun</title>
</head>
<body>
    <h1>Hello 
        <?php if(isset($_SESSION['firstname'])){
            $role = $_SESSION['firstname'];
            echo $role;
            } else {
            echo "firstname niet gevonden in sessie.";
            } 
        ?>
        <?php if(isset($_SESSION['lastname'])){
            $role = $_SESSION['lastname'];
            echo $role;
            } else {
            echo "lastname niet gevonden in sessie.";
            } 
        ?>
    </h1>
    <p>Welcome to your dashboard!</p>
    <p>
        <?php if(isset($_SESSION['role'])){
            $role = $_SESSION['role'];
            echo $role;
            } else {
            echo "Rol niet gevonden in sessie.";
            } 
        ?>
    </p>
    <p>
        <?php if(isset($_SESSION['username'])){
            $role = $_SESSION['username'];
            echo $role;
            } else {
            echo "username niet gevonden in sessie.";
            } 
        ?>
    </p>
    <p>
        <?php if(isset($_SESSION['birthday'])){
            $role = $_SESSION['birthday'];
            echo $role;
            } else {
            echo "birthday niet gevonden in sessie.";
            } 
        ?>
    </p>
    <p>
        <?php if(isset($_SESSION['id'])){
            $role = $_SESSION['id'];
            echo $role;
            } else {
            echo "id niet gevonden in sessie.";
            } 
        ?>
    </p>
    <a href="?logout">Logout</a>
</body>
</html>

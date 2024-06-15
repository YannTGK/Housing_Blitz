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
    <?php include_once(__DIR__ . "/classes/nav.php") ?>

    <div class="screen">
        <h3 class="housingLetter">
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
            - Housing Blitz
        </h3>

        <div class="content">
            

        </div>
    </div>
</body>
</html>

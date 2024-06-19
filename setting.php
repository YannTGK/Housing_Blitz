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
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Housing Blitz - Instellingen</title>
    <link rel="stylesheet" href="styles/normalize.css">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/setting.css">
</head>
<body>

<?php include_once(__DIR__ . "/classes/nav.php") ?>

<div class="screen">
    <div class="screenHead">
        <h3 class="housingLetter">
            <?php if(isset($_SESSION['firstname'])){
                echo $_SESSION['firstname'];
            } else {
                echo "firstname niet gevonden in sessie.";
            } ?>
            <?php if(isset($_SESSION['lastname'])){
                echo $_SESSION['lastname'];
            } else {
                echo "lastname niet gevonden in sessie.";
            } ?>
            - Housing Blitz
        </h3>
    </div>
    
    <section class="settings">
        <h2>Instellingen</h2>
        <div class="settings-options">
            <div class="option" onclick="openModal()">Notificaties</div>
            <div class="option">Taal instellingen</div>
            <div class="option">Privacy & Policy</div>
            <div class="option">Feedback</div>
            <div class="option">Toegankelijkheid</div>
        </div>
    </section>
</div>

<!-- Modal -->
<div id="notificationModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h3>Allow notifications ?</h3>
        <label class="switch">
            <input type="checkbox" id="notificationToggle">
            <span class="slider round"></span>
        </label>
        <p>Do you want to get notified when something changes about your position or percentage</p>
    </div>
</div>

<script src="script/settings.js"></script>

</body>
</html>
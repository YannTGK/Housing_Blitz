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

?><!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Housing Blitz - Instellingen</title>
    <link rel="stylesheet" href="styles/normalize.css">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/contactsend.css">
</head>
<body>

<?php include_once(__DIR__ . "/classes/nav.php") ?>

<div class="screen">
    <div class="screenHead">
        <a href="index.php" class="backLogo"></a>
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

    <main class="content">
            <section class="confirmation">
                <div class="confirmation-message">
                    <h2>We hebben je vraag goed ontvangen</h2>
                    <img src="images/check.svg" alt="">
                </div>
                <div class="confirmation-info">
                    <h3>Hou je mailbox in de gaten</h3>
                    <p>Er wordt zo snel als mogelijk geantwoord op je verzoek. Hou hiervoor je mailbox in de gaten. Heb je nog extra vragen, twijfel zeker niet om contact met ons op te nemen.</p>
                    <address>
                        Stadsbestuur Mechelen<br>
                        Huis van de Mechelaar<br>
                        Reuzenstraat 1, 2800 Mechelen<br>
                        T 0800 20 800, <a href="mailto:onthaal@mechelen.be">onthaal@mechelen.be</a>
                    </address>
                </div>
            </section>
        </main>


    </body>
    </html>
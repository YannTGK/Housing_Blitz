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
    <link rel="stylesheet" href="styles/herleiding.css">
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
            <section class="redirect-info">
                <h2>Je wordt herleid naar de officiële website van derde</h2>
                <div class="logos">
                    <img src="images/image6.png" alt="Vlaanderen Logo">
                </div>
                <div class="success-message">
                    <h3>Veel succes</h3>
                    <p>Ondervindt u problemen en wenst u hulp bij het vinden van informatie of het uitvoeren van een actie?</p>
                    <p>Hebt u een vraag of opmerking over de toegankelijkheid van <a href="https://vlaanderen.be">Vlaanderen.be</a> of over deze toegankelijkheidsverklaring?</p>
                    <p>Neem contact op via het <a href="https://www.vlaanderen.be/1700-contactformulier">1700-contactformulier</a>, bel het gratis nummer 1700 of start een <a href="https://chat.vlaanderen.be">chatgesprek</a>, elke werkdag bereikbaar van 9 tot 19 uur.</p>
                </div>
            </section>
        </main>
    </div>


</body>
</html>
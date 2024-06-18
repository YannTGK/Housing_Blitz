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
    <link rel="stylesheet" href="styles/contact.css">
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

    <section class="contact">
                <div class="contact-info">
                    <h2>Contacteer een maatschappelijke werker</h2>
                    <p>Heb je hulp nodig om je aanvraag tot een sociale woning tot een succes te brengen? Twijfel dan zeker niet om contact op te nemen met een maatschappelijke werker. Zij helpen je een hogere slaagkans te behalen voor een sociale woning.</p>
                    <p class="small">Je persoonlijke gegevens worden altijd zonder naam gedeeld naar de maatschappelijke werker. Dit zodat hij je beter kan helpen met je aanvraag. We volgen altijd de GDPR privacy wetgeving.</p>
                    <hr>
                    <h3>Je lokale maatschappelijke zetel</h3>
                    <p>Je woont in stad Mechelen. Heb je specifieke vragen voor je stad, kan je rechtstreeks met hun contact nemen.</p>
                    
                    <hr>
                    <address>
                        <strong>MECHELEN</strong><br>
                        Stadsbestuur Mechelen<br>
                        Huis van de Mechelaar<br>
                        Reuzenstraat 1, 2800 Mechelen<br>
                        T 0800 20 800, <a href="mailto:onthaal@mechelen.be">onthaal@mechelen.be</a>
                    </address>
                </div>
                <div class="contact-form">
                    <form action="contactsend.php" method="post">
                        <div class="form-group">
                            <label for="voornaam">Voornaam *</label>
                            <input type="text" id="voornaam" name="voornaam" placeholder="e.g Peter" required>
                        </div>
                        <div class="form-group">
                            <label for="achternaam">Achternaam *</label>
                            <input type="text" id="achternaam" name="achternaam" placeholder="e.g Devalck" required>
                        </div>
                        <div class="form-group">
                            <label for="email">E-mail *</label>
                            <input type="email" id="email" name="email" placeholder="e.g Peterdevalck@gmail.com" required>
                        </div>
                        <div class="form-group">
                            <label for="telefoon">Telefoon nummer</label>
                            <input type="tel" id="telefoon" name="telefoon" placeholder="e.g +32 408 83 74 36">
                        </div>
                        <div class="form-group">
                            <label for="vraag">Je vraag *</label>
                            <textarea id="vraag" name="vraag" placeholder="Waarom neem je contact op? Probeer zo precies mogelijk te zijn." required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="bijlage">Bijlage toevoegen</label>
                            <input type="file" id="bijlage" name="bijlage">
                        </div>
                        <button type="submit">Verzenden</button>
                    </form>
                </div>
            </section>

    </div>

    </body>
    </html>
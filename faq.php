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
    <link rel="stylesheet" href="styles/faq.css">
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
    
    <section class="faq">
        <h2>FAQ - vragen</h2>
        <div class="faq-item">
            <div class="faq-question">
                <h3>1. Wat is het verschil tussen een huurpremie en een subsidie?</h3>
            </div>
            <div class="faq-answer">
                <p>Een huurpremie is meestal een financiële tegemoetkoming die wordt toegekend aan huurders met een laag inkomen en een hoge huurlast, terwijl een subsidie een bredere term is die verschillende vormen van financiële steun kan omvatten.</p>
                <img src="path_to_het_juridisch_loket_logo" alt="Het Juridisch Loket Logo">
            </div>
        </div>
        <div class="faq-item">
            <div class="faq-question">
                <h3>2. Hoe wordt de hoogte van een huurpremie of subsidie bepaald?</h3>
            </div>
            <div class="faq-answer">
                <p>De hoogte wordt vaak bepaald op basis van verschillende factoren, waaronder het inkomen van de huurder, de huurprijs van de woning en eventuele specifieke behoeften of omstandigheden.</p>
                <img src="path_to_vlaanderen_logo" alt="Vlaanderen Logo">
            </div>
        </div>
        <div class="faq-item">
            <div class="faq-question">
                <h3>3. Wat moet ik doen als mijn inkomen verandert tijdens de looptijd van de premie of subsidie?</h3>
            </div>
            <div class="faq-answer">
                <p>Het is belangrijk om eventuele wijzigingen in je inkomen tijdig door te geven aan de relevante instantie om ervoor te zorgen dat je recht blijft hebben op de premie of subsidie.</p>
                <img src="path_to_vlaanderen_logo" alt="Vlaanderen Logo">
            </div>
        </div>
        <div class="faq-item">
            <div class="faq-question">
                <h3>4. Zijn er specifieke huurpremieprogramma's voor mensen met een handicap en zo ja, welke criteria worden gebruikt om de mate van ondersteuning te bepalen?</h3>
            </div>
            <div class="faq-answer">
                <p>Sommige regio's bieden specifieke huurpremieprogramma's voor mensen met een handicap. Naast financiële gegevens kunnen criteria voor de mate van ondersteuning factoren omvatten zoals de aard en ernst van de handicap, de noodzaak van aangepaste huisvesting en de beschikbaarheid van ondersteunende diensten.</p>
                <img src="path_to_ku_leuven_logo" alt="KU Leuven Logo">
            </div>
        </div>
    </section>
</div>


</body>
</html>
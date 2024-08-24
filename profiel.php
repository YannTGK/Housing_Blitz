<?php 
include_once(__DIR__."/classes/database.php");

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

$conn = Db::getConnection();

// Check if user_id is set in the session
if(isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];

    
} else {
    echo "Gebruiker ID niet gevonden in sessie.";
    exit;
}
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="styles/normalize.css">
  <link rel="stylesheet" href="styles/style.css">
  <link rel="stylesheet" href="styles/profiel.css">
  <title>Housing Blitz</title>
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

        <div class="content">
            <div class="left under">
                
                <div class="woonWens">
                    <h2>Woon wensen</h2>
                    <img src="images/profiel_zetel.svg" alt="">
                    <div class="Text">
                        <div class="next">
                            <strong>Type</strong>
                            <p>Huis</p>
                        </div>
                        <div class="next">
                            <strong>Wensprijs</strong>
                            <p>€850</p>
                        </div>
                        <div class="next">
                            <strong>Grootte</strong>
                            <p>
                                120m.m - 3 slaapkamers
                            </p>
                        </div>
                        <div class="next">
                            <strong>Locatie</strong>
                            <p>Regio Antwerpen</p>
                        </div>
                        <div class="next">
                            <strong>Voorzieningen</strong>
                            <p>Balkon, tuin, parking</p>
                        </div>
                        <div class="next">
                            <strong>Toegankelijkheid</strong>
                            <p>Geen</p>
                        </div>
                        <div class="next">
                            <strong>Speciale eisen</strong>
                            <p>Geen</p>
                        </div>
                    </div>
                    <a href="woonwensen.php" class="button2">Bewerken</a>
                </div>
            </div>
            <div class="middle under">
                <div class="topMiddle">
                    <div class="upperside">
                        <div class="gezinsinfo">
                            <h3>Gezinsinformatie</h3>
                            <div class="Text">
                                <div class="next2">
                                    <strong>Burgerlijke staat</strong>
                                    <p>ongehuwd</p>
                                </div>
                                <div class="next2">
                                    <strong>Woonstituatie</strong>
                                    <p>Alleenstaande ouder</p>
                                </div>
                                <div class="next2">
                                    <strong>Kinderen ten laste</strong>
                                    <p>Emma (12), dochter; <br>
                                    Kevin (10), zoon;</p>
                                </div>
                            </div>
                        </div>
                  
                  
                        <div class="gezinsinfo">
                            <h3>Financiele informatie</h3>
                            <div class="Text">
                                <div class="next2">
                                    <strong>Netto-inkomen</strong>
                                    <p>Loondienst €1350</p>
                                </div>
                                <div class="next2">
                                    <strong>Uitgaven</strong>
                                    <p>Maandelijkse leningen €150; Alimentatie €100</p>
                                </div>
                                <div class="next2">
                                    <strong>Uitkering bewijzen</strong>
                                    <p>Geen</p>
                                </div>
                                <div class="next2">
                                    <strong>Belastingaangiften</strong>
                                    <p> ingediend </p>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <a href="persoonlijkeInfo.php" class="button2">Bewerken</a>   
                </div>
                <div class="botMiddle">
                    <div class="gezinsinfo2">
                        <h3>Huidige woonsituatie</h3>
                        <div class="Text">
                            <div class="next">
                                <strong>Type</strong>
                                <p>Appartement</p>
                            </div>
                            <div class="next">
                                <strong>Huurprijs</strong>
                                <p>€1100</p>
                            </div>
                            <div class="next">
                                <strong>Einde contract</strong>
                                <p>23/06/2025</p>
                            </div>
                            <div class="next">
                                <strong>Grootte</strong>
                                <p> 90m.m - 2 slaapkamers </p>
                            </div>
                            <div class="next">
                                <strong>Adres</strong>
                                <p> Sint-Katelijnestraat 7B/3, 2800 Mechelen, België </p>
                            </div>
                        </div>

                    </div>
                    <a href="woonsituatie.php" class="button2">Bewerken</a>
                </div>
            </div>
           
            

   
</body>
</html>

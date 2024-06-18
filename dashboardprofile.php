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
    <link rel="stylesheet" href="styles/dashboardprofile.css">
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
        
            <section class="welcome">
                <div class="welcome-card">
                    <img src="path_to_avatar_image" alt="Avatar">
                    <h2>Welkom terug, John!</h2>
                </div>
            </section>
            <section class="main-dashboard">
                <div class="card woon-wensen">
                    <h2>Woon wensen</h2>
                    <img src="path_to_image" alt="Woon wensen">
                    <p>Type: Huis<br>
                        Wensprijs: €850<br>
                        Grootte: 120m² - 3 slaapkamers<br>
                        Locatie: Regio-Antwerpen<br>
                        Voorzieningen: Balkon, tuin, parking<br>
                        Toegankelijkheid: Geen<br>
                        Speciale eisen: Geen
                    </p>
                    <button>Voorkeuren aanpassen</button>
                </div>
                <div class="card gezin-financien">
                    <h2>Gezinsinformatie</h2>
                    <p>Burgerlijke staat: ongehuwd<br>
                        Woonstatus: alleenstaande ouder<br>
                        Kinderen te lasten: 2<br>
                        Emma (12), dochter; Kevin (10), zoon
                    </p>
                    <h2>Financiele informatie</h2>
                    <p>Netto-inkomen: Loondienst €1653<br>
                        Uitgaven: Maandelijkse leningen €150; Alimentatie €100<br>
                        Uitkering bewijzen: geen<br>
                        Belastingaangiften: ingediend
                    </p>
                    <button>Bewerken</button>
                </div>
                <div class="card huidige-woonsituatie">
                    <h2>Huidige woonsituatie</h2>
                    <p>Type: Appartement<br>
                        Huurprijs: €1100<br>
                        Eind contract: 23/06/2025<br>
                        Grootte: 90m² - 2 slaapkamers<br>
                        Adres: Sint-Katelijnestraat 7B/3, 2800 Mechelen, België
                    </p>
                    <a href="#">Pas hier aan</a>
                </div>
                <div class="card documenten-upload">
                    <h2>Documenten uploaden</h2>
                    <p>Met deze documenten kunnen wij bijna automatische aanvragen voor jouw invullen. Je gegevens zijn veilig met ons.</p>
                    <div class="progress-bar">
                        <div class="progress" style="width: 70%;"></div>
                        <span>70%</span>
                    </div>
                    <p>Alle nodige documenten uploaden doe je <a href="#">hier</a>.</p>
                </div>
                <div class="card itsme-status">
                    <h2>Status</h2>
                    <div class="itsme-status-content">
                        <div class="itsme-status-icon">✔️</div>
                        <p>Je bent verbonden met de Itsme app. De meeste gegevens worden automatisch geladen.</p>
                    </div>
                </div>
            </section>
        </main>
    </div>


    </body>
</html>
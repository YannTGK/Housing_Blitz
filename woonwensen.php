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
    <link rel="stylesheet" href="styles/woonwensen.css">
</head>
<body>

<?php include_once(__DIR__ . "/classes/nav.php") ?>

    <div class="screen">
        <div class="screenHead">
            <a href="profiel.php" class="backLogo"></a>
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
            <form action="#" class="group">
                <div class="left">
                    <h1>Woon wensen</h1>
                    <img src="images/profiel_zetel.svg" alt="image of a home">
                    <div class="radio radio1">
                        <h3>Type</h3>
                        <label><input type="radio" name="type" value="alleenstaand-huis"> Alleenstaand huis</label>
                        <label><input type="radio" name="type" value="appartement"> Appartement</label>
                        <label><input type="radio" name="type" value="rijtjeshuis"> Rijtjeshuis</label>
                        <label><input type="radio" name="type" value="twee-onder-een-kapwoning"> Twee-onder-een-kapwoning</label>
                        <label><input type="radio" name="type" value="woonboot"> Woonboot</label>
                    </div>
                </div>
                <div class="middle">
                    <div class="radio radio2">
                        <h3>Locatie</h3>
                        <label><input type="radio" name="location" value="antwerpen"> Antwerpen</label>
                        <label><input type="radio" name="location" value="vlaams-brabant"> Vlaams-Brabant</label>
                        <label><input type="radio" name="location" value="limburg"> Limburg</label>
                        <label><input type="radio" name="location" value="oost-vlaanderen"> Oost-Vlaanderen</label>
                        <label><input type="radio" name="location" value="west-vlaanderen"> West-Vlaanderen</label>
                        <label><input type="radio" name="location" value="henegouwen"> Henegouwen</label>
                        <label><input type="radio" name="location" value="luik"> Luik</label>
                        <label><input type="radio" name="location" value="luxenburg"> Luxenburg</label>
                        <label><input type="radio" name="location" value="namen"> Namen</label>
                        <label><input type="radio" name="location" value="waals-brabant"> Waals-Brabant</label>
                    </div>

                    <div class="input">
                        <h3>Informatie</h3>
                        <div class="form-group">
                            <label for="size">Grootte</label>
                            <input type="text" id="size" name="size" placeholder="e.g 90m²">
                        </div>
                        <div class="form-group">
                            <label for="bedrooms">Slaapkamers</label>
                            <input type="text" id="bedrooms" name="bedrooms" placeholder="e.g 2">
                        </div>
                        <div class="form-group">
                            <label for="rent">Huurprijs</label>
                            <input type="text" id="rent" name="rent" placeholder="e.g €1000">
                        </div>

                    </div>
                </div>
                <div class="right">
                    <div class="radio radio3">
                        <h3>Voorzieningen</h3>
                        <label><input type="radio" name="facilities" value="balkon"> Balkon</label>
                        <label><input type="radio" name="facilities" value="tuin"> Tuin</label>
                        <label><input type="radio" name="facilities" value="parking"> Parking</label>
                        <label><input type="radio" name="facilities" value="open-haard"> Open haard</label>
                    </div>
                    <button type="submit" class="button">Opslaan</button>
                </div>
            </form>
           
        </div>
    </div>
</body>
</html>
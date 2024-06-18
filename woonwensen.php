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
            <section class="woon-wensen">
                <h2>Woon wensen</h2>
                <div class="woon-wensen-content">
                    <img src="path_to_image" alt="Woon wensen">
                    <form>
                        <div class="form-group">
                            <label>Type</label>
                            <div class="radio-group">
                                <label><input type="radio" name="type" value="alleenstaand-huis"> Alleenstaand huis</label>
                                <label><input type="radio" name="type" value="appartement"> Appartement</label>
                                <label><input type="radio" name="type" value="rijtjeshuis"> Rijtjeshuis</label>
                                <label><input type="radio" name="type" value="twee-onder-een-kapwoning"> Twee-onder-een-kapwoning</label>
                                <label><input type="radio" name="type" value="woonboot"> Woonboot</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Locatie</label>
                            <div class="radio-group">
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
                        </div>
                        <div class="form-group">
                            <label>Voorzieningen</label>
                            <div class="radio-group">
                                <label><input type="radio" name="facilities" value="balkon"> Balkon</label>
                                <label><input type="radio" name="facilities" value="tuin"> Tuin</label>
                                <label><input type="radio" name="facilities" value="parking"> Parking</label>
                                <label><input type="radio" name="facilities" value="open-haard"> Open haard</label>
                            </div>
                        </div>
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
                        <button type="submit">Opslaan</button>
                    </form>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
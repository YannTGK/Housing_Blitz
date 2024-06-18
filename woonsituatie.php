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
    <link rel="stylesheet" href="styles/woonsituatie.css">
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
            <section class="update-living-situation">
                <h2>Huidige woonsituatie aanpassen</h2>
                <form>
                    <div class="form-group">
                        <label for="street">Adres</label>
                        <input type="text" id="street" name="street" placeholder="Straat">
                        <input type="text" id="number" name="number" placeholder="Nummer">
                        <input type="text" id="postcode" name="postcode" placeholder="Postcode">
                        <input type="text" id="city" name="city" placeholder="Stad">
                        <input type="text" id="country" name="country" placeholder="Land">
                    </div>
                    <div class="form-group">
                        <label for="size">Grootte</label>
                        <input type="text" id="size" name="size" placeholder="Nummer">
                    </div>
                    <div class="form-group">
                        <label for="bedrooms">Slaapkamers</label>
                        <input type="text" id="bedrooms" name="bedrooms" placeholder="Nummer">
                    </div>
                    <div class="form-group">
                        <label for="end-contract">Eind contract</label>
                        <input type="date" id="end-contract" name="end-contract">
                    </div>
                    <div class="form-group">
                        <label for="rent">Huurprijs</label>
                        <input type="text" id="rent" name="rent" placeholder="e.g €1000">
                    </div>
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
                    <button type="submit">Opslaan</button>
                </form>
            </section>
        </main>
    </div>
</body>
</html>
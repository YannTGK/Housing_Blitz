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
    <title>Housing Blitz - Upload Documents</title>
    <link rel="stylesheet" href="styles/normalize.css">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/upload.css">
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

    <section class="upload-documents">
                <h2>Documenten uploaden</h2>
                <div class="progress-bar">
                    <div class="progress" style="width: 15%;"></div>
                    <span>70%</span>
                </div>
                <p>Met deze documenten kunnen wij bijna automatische aanvragen voor jouw invullen. Je gegevens zijn veilig met ons.</p>
                <p>Alle nodige documenten uploaden doe je hier.</p>
                <div class="upload-form">
                    
                    <label for="document-upload" class="upload-label">Bijlage toevoegen</label>
                </div>
                <div class="document-list">
                    <p><i class="icon">📎</i> Identificatiebewijs <span class="status success">toegevoegd</span></p>
                    <p><i class="icon">📎</i> Bewijs van inkomen <span class="status success">toegevoegd</span></p>
                    <p><i class="icon">📎</i> Bewijs van vermogen <span class="status success">toegevoegd</span></p>
                    <p><i class="icon">📎</i> Bewijs van burgerlijke staat <span class="status success">toegevoegd</span></p>
                    <p><i class="icon">📎</i> Bewijs van huishoudsamenstelling <span class="status success">toegevoegd</span></p>
                    <p><i class="icon">📎</i> Bewijs van woonhistorie <span class="status success">toegevoegd</span></p>
                    <p><i class="icon">📎</i> Bewijs van vaste kosten <span class="status success">toegevoegd</span></p>
                    <p><i class="icon">📎</i> Bewijs van handicap <span class="status error">afwezig</span></p>
                    <p><i class="icon">📎</i> Medische verklaring <span class="status error">afwezig</span></p>
                </div>
                <button class="save-button">Opslaan</button>
            </section>
    </div>

    </body>
</html>
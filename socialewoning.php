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

    // Get the social housing positions for the user, including city names, ordered by social housing position
    $sql = "SELECT steden.naam AS stad_naam, user_stad_chance_percentages.sociale_woning_positie 
            FROM user_stad_chance_percentages 
            JOIN steden ON user_stad_chance_percentages.stad_id = steden.id 
            WHERE user_stad_chance_percentages.user_id = $user_id
            ORDER BY user_stad_chance_percentages.sociale_woning_positie ASC";
    $result = $conn->query($sql);

    if ($result === false) {
        // Error executing the query
        echo "Error: " . $conn->error;
    } elseif ($result->num_rows > 0) {
        $sociale_woning_data = [];
        while ($row = $result->fetch_assoc()) {
            $sociale_woning_data[] = $row;
        }
    } else {
        // User not found
        echo "Gebruiker niet gevonden in de database.";
        $sociale_woning_data = [];
    }

    // New query to get the lowest position of the user for social housing
    $sql_lowest_position = "SELECT MIN(sociale_woning_positie) as laagste_positie 
                            FROM user_stad_chance_percentages 
                            WHERE user_id = $user_id";
    $result_lowest_position = $conn->query($sql_lowest_position);

    if ($result_lowest_position === false) {
        echo "Error: " . $conn->error;
        $laagste_positie = "N/A";
    } else {
        $row_lowest_position = $result_lowest_position->fetch_assoc();
        $laagste_positie = $row_lowest_position['laagste_positie'];
    }
} else {
    echo "Gebruiker ID niet gevonden in sessie.";
    $laagste_positie = 0;
}

// Chance calculation
$kans_op_sociale_woning = (1 - ($laagste_positie / 400)) * 100;
$kans_op_sociale_woning = round($kans_op_sociale_woning, 0); // Round to 0 decimals for display

// Function to determine color based on percentage
function getProgressBarColor($percentage) {
    if ($percentage <= 35) {
        return '#f44336'; // Red
    } elseif ($percentage <= 60) {
        return '#ff9800'; // Orange
    } else {
        return '#4caf50'; // Green
    }
}

$progress_color = getProgressBarColor($kans_op_sociale_woning);

?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="styles/normalize.css">
  <link rel="stylesheet" href="styles/style.css">
  <link rel="stylesheet" href="styles/socialewoning.css">
  <title>Housing Blitz</title>
</head>
<body>
    <?php include_once(__DIR__ . "/classes/nav.php") ?>

    <div class="screen">
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

        <div class="content">
            <div class="left">
                <div class="positie">
                    <h3>Je positie op sociale woningen</h3>
                    <p>Je staat in de rij in de volgende steden voor een sociale woning:</p>
                    
                    <div class="positieKader">
                        <?php foreach ($sociale_woning_data as $data): 
                            $city_name = $data['stad_naam'];
                            $positie = $data['sociale_woning_positie'];
                            $kans = (1 - ($positie / 400)) * 100;
                            $kans = round($kans, 0);
                            $progress_color = getProgressBarColor($kans);
                        ?>
                        <div class="positieHolder">
                            <p class="stad"><?php echo $city_name; ?></p>
                            <p><?php echo $positie; ?>ste - <?php echo $kans; ?>% kans</p>
                            <div class="progress-bar">
                                <div class="progress-bar-fill" style="width: <?php echo $kans; ?>%; background-color: <?php echo $progress_color; ?>;"></div>
                            </div>
                            <span>Nog 4 jaar in de wachtrij</span> <!-- Replace X with actual logic -->
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="contact">
                    <h3>Professional Contacteren</h3>
                    <p>Contacteer een professional in je buurt. Deze kan je helpen je slaagkans te vergroten.</p>
                    <a href="#" class="button">Contacteer nu </a>        
                </div>
            </div>
            <div class="right">
                <div class="tips">
                    <h2>Vergroot je kans op een sociale woning</h2>
                    <div class="articles">
                        <article>
                            <p class="header">1. Houd je informatie up-to-date: </p>
                            <p>Zorg ervoor dat je persoonlijke en financiële informatie up-to-date is bij de instanties die verantwoordelijk zijn voor sociale woningen. Veranderingen in je situatie, zoals een verandering in inkomen of gezinssamenstelling, kunnen van invloed zijn op je recht op een sociale woning.</p>
                        </article>
                        <article>
                            <p class="header">2. Raadpleeg een professional: </p>
                            <p>Als je moeite hebt om aan de criteria te voldoen of als je vragen hebt over het aanvraagproces, overweeg dan om contact op te nemen met een maatschappelijk werker, een huuradvocaat of een andere professional die bekend is met huisvestingsproblematiek. Zij kunnen advies geven en je begeleiden bij het aanvraagproces.</p>
                        </article>
                        <article>
                            <p class="header">3. Zoek naar alternatieven: </p>
                            <p>Overweeg ook andere mogelijkheden, zoals particuliere huurwoningen met lagere huurprijzen of programma's voor huisvestingssteun die beschikbaar zijn in jouw regio.</p>
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Add any necessary JavaScript here
    </script>
</body>
</html>

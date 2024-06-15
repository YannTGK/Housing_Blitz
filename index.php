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

// Controleer of user_id is ingesteld in de sessie
if(isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];
    $sql = "SELECT sociale_woning_positie, premies_subsidies, particulieren_huurmarkt, sociaal_verhuurkantoor FROM user_chance_percentages WHERE user_id = $user_id";
    $result = $conn->query($sql);

    if ($result === false) {
        // Fout bij het uitvoeren van de query
        echo "Error: " . $conn->error;
    } elseif ($result->num_rows > 0) {
        // Gebruiker gevonden, haal kanspercentages op
        $row = $result->fetch_assoc();
        $sociale_woning = $row['sociale_woning_positie'];
        $premies_subsidies = $row['premies_subsidies'];
        $particulieren_huurmarkt = $row['particulieren_huurmarkt'];
        $sociaal_verhuurkantoor = $row['sociaal_verhuurkantoor'];
    } else {
        // Gebruiker niet gevonden
        echo "Gebruiker niet gevonden in de database.";
        $sociale_woning = $premies_subsidies = $particulieren_huurmarkt = $sociaal_verhuurkantoor = 0;
    }
} else {
    echo "Gebruiker ID niet gevonden in sessie.";
    $sociale_woning = $premies_subsidies = $particulieren_huurmarkt = $sociaal_verhuurkantoor = 0;
}

// Kansberekening
$kans_op_sociale_woning = (1 - ($sociale_woning / 400))*100 ;
$kans_op_sociale_woning = round($kans_op_sociale_woning, 0); // Afronden tot 2 decimalen voor weergave

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
  <link rel="stylesheet" href="styles/home.css">
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
                } 
            ?>
            <?php if(isset($_SESSION['lastname'])){
                echo $_SESSION['lastname'];
                } else {
                echo "lastname niet gevonden in sessie.";
                } 
            ?>
            - Housing Blitz
        </h3>

        <div class="content">
            <div class="top">
                <div class="kansHolder">
                    <h1>Kans op een woning</h1>
                    <div class="kans">
                        <div class="chart-container">
                            <?php
                            
                            
                                $progressValues = [$kans_op_sociale_woning, $premies_subsidies,$particulieren_huurmarkt,$sociaal_verhuurkantoor  ];
                                $classes = ['circle-xlarge', 'circle-large', 'circle-medium', 'circle-small'];
                                foreach ($progressValues as $index => $progress) {
                                    $class = $classes[$index];
                                    echo "<div class='circle $class' data-progress='$progress'></div>";
                                }
                            ?>
                        </div>
                        <ul class="legend">
                            <li> 
                                <strong>
                                    Sociale Woning
                                </strong>  
                                <span>
                                    <?php echo $kans_op_sociale_woning; ?>%
                                </span>
                            </li>
                            <li> 
                                <strong>
                                    Premies/Subsidies
                                </strong>
                                <span>
                                    <?php echo $premies_subsidies; ?>%
                                </span>
                            </li>
                            <li> 
                                <strong>
                                    Particulieren Huurmarkt
                                </strong>  
                                <span>
                                    <?php echo $particulieren_huurmarkt; ?>%
                                </span>
                            </li>
                            <li> 
                                <strong>
                                    Sociaal Verhuurkantoor
                                </strong>  
                                <span>
                                    <?php echo $sociaal_verhuurkantoor; ?>%
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card">
                    <h3 class="title"><?php echo $sociale_woning; ?> ste</h3>
                    <p class="body-text">
                        Je staat in de rij in 3 steden voor een sociale woning.
                    </p>
                    <div class="progress-bar">
                        <div class="progress-bar-fill" style="width: <?php echo $kans_op_sociale_woning; ?>%; background-color: <?php echo $progress_color; ?>;"></div>
                        <div class="percentage"><?php echo $kans_op_sociale_woning; ?>%</div>
                    </div>
                    <p class="body-text">
                        In Mechelen sta je op de 31ste plaats wat momenteel je grootste kans is. De verwachte wachttijd is nog 2 jaar.
                    </p>
                    <a href="#" class="button">Elke stad zien</a>
                </div> 
                <div class="addInfo">
                    <div class="city">
                        <img src="images/mechelen_logo.svg" alt="logo van je stad">
                        <p>Wonen in Mechelen. ALle communicatie en info vanuit je stad vind je <a href="#">hier</a>.</p>
                    </div>
                    <div class="profielVoltooid">
                        <p>Voltooi je profiel <a href="#">hier</a> om beter geholpen te worden.</p>
                        <div class="progress-bar">
                            <div class="progress-bar-fill" style="width: <?php echo $kans_op_sociale_woning; ?>%; background-color: <?php echo $progress_color; ?>;"></div>
                            <div class="percentage">80%</div>
                        </div>
                    </div>
                </div>                 
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const circles = document.querySelectorAll('.circle');
            const colors = ['#B2FFA8', '#A4AA7D', '#86E7B8', '#93ACA0']; // Define your colors here

            circles.forEach((circle, index) => {
                const progress = circle.getAttribute('data-progress');
                const color = colors[index % colors.length]; // Use a color from the array
                circle.style.background = `conic-gradient(${color} 0% ${progress}%, #d3d3d3 ${progress}% 100%)`;
            });
        });
    </script>
</body>
</html>

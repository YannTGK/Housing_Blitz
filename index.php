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
    $sql = "SELECT sociale_woning_positie, premies_subsidies, particulieren_huurmarkt, sociaal_verhuurkantoor FROM user_stad_chance_percentages WHERE user_id = $user_id";
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

    // Nieuwe query om de laagste positie van de gebruiker voor sociale woningen op te halen
    $sql_lowest_position = "SELECT MIN(sociale_woning_positie) as laagste_positie FROM user_stad_chance_percentages WHERE user_id = $user_id";
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
    $laagste_positie = $premies_subsidies = $particulieren_huurmarkt = $sociaal_verhuurkantoor = $laagste_positie = 0;
}

// Kansberekening
$kans_op_sociale_woning = (1 - ($laagste_positie / 400)) * 100;
$kans_op_sociale_woning = round($kans_op_sociale_woning, 0); // Afronden tot 2 decimalen voor weergave

// Function to determine color based on percentage
function getProgressBarColor($percentage) {
    if ($percentage <= 35) {
        return '#f44336'; // Red
    } elseif ($percentage <= 60) {
        return '#ff9800'; // Orange
    } else {
        return '#64D49C'; // Green
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
                                    <a href="socialewoning.php">Sociale Woning</a>
                                </strong>  
                                <span>
                                    <?php echo $kans_op_sociale_woning; ?>%
                                </span>
                            </li>
                            <li> 
                                <strong>
                                    <a href="https://www.premiezoeker.be/">Premies/Subsidies</a>
                                </strong>
                                <span>
                                    <?php echo $premies_subsidies; ?>%
                                </span>
                            </li>
                            <li> 
                                <strong>
                                    <a href="https://www.vlaanderen.be/een-huis-of-appartement-kopen">Particulieren Huurmarkt</a>
                                </strong>  
                                <span>
                                    <?php echo $particulieren_huurmarkt; ?>%
                                </span>
                            </li>
                            <li> 
                                <strong>
                                    <a href="https://www.vlaanderen.be/een-sociale-woning-huren-bij-een-woonmaatschappij">Sociaal Verhuurkantoor</a>
                                </strong>  
                                <span>
                                    <?php echo $sociaal_verhuurkantoor; ?>%
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card">
                    <h3 class="title"><?php echo $laagste_positie; ?> ste</h3>
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
                    <a href="socialewoning.php" class="button">Elke stad zien</a>
                </div> 
                <div class="addInfo">
                    <div class="city">
                        <img src="images/mechelen_logo.svg" alt="logo van je stad">
                        <p>Wonen in Mechelen. Alle communicatie en info vanuit je stad vind je <a href="#">hier</a>.</p>
                    </div>
                    <div class="profielVoltooid">
                        <p>Voltooi je profiel <a href="#">hier</a> om beter geholpen te worden.</p>
                        <div class="progress-bar">
                            <div class="progress-bar-fill" style="width: <?php echo 40; ?>%; background-color: <?php echo 40; ?>;"></div>
                            <div class="percentage"><?php echo 40; ?>%</div>
                        </div>
                    </div>
                </div>                 
            </div>
            <div class="bottom">
                <div class="faqHolder">
                    <h3>FAQ - vragen</h3>
                    <div class="articles">
                        <article>
                            <p class="header"> 1. Wat is het verschil tussen een huurpremie en een subsidie? </p>
                            <p>Een huurpremie is meestal een financiële tegemoetkoming die wordt toegekend aan huurders met een laag inkomen en een hoge huurlast, terwijl een subsidie een bredere term is die verschillende vormen van financiële steun kan omvatten.</p>        	
                        </article>
                        <article>
                            <p class="header"> 2. Hoe wordt de hoogte van een huurpremie of subsidie bepaald? </p>
                            <p>De hoogte wordt vaak bepaald op basis van verschillende factoren, waaronder het inkomen van de huurder, de huurprijs van de woning en eventuele specifieke behoeften of omstandigheden.</p>        	
                        </article>
                        <article>
                            <p class="header"> 3. Wat moet ik doen als mijn inkomen verandert tijdens de looptijd van de premie of subsidie? </p>
                            <p> Het is belangrijk om eventuele wijzigingen in je inkomen tijdig door te geven aan de relevante instantie om ervoor te zorgen dat je recht blijft hebben op de premie of subsidie.</p>        	
                        </article>

                    </div>
                </div>
                <div class="news">
                    <h3>Woon nieuws</h3>
                    <div class="articlesHolder">
                        <article>
                            <img src="images/news1.svg" alt="holder image for news section 1">
                            <div class="articles2">
                                <p class="header">Inschrijven voor een sociale huurwoning gebeurt voortaan online</p>
                                <p>Inschrijven voor een sociale huurwoning gebeurt vanaf 18 maart 2024 online. Vanaf dan is er in Vlaanderen namelijk één digitaal platform voor alle inschrijvingsdossiers... <a href="#">Lees meer</a></p>
                            </div> 
                        </article>
                        <article>
                            <img src="images/news2.svg" alt="holder image for news section 1">
                            <div class="articles2">
                                <p class="header">Je huursubsidie kan je nu ook digitaal aanvragen</p>
                                <p>Je huurt een woning op de private huurmarkt en hebt een beperkt inkomen. De huursubsidie is een maandelijks bedrag om je te helpen je huurprijs te betalen... <a href="#">Lees meer</a></p>
                            </div>
                        </article>
                        <article>
                            <img src="images/news3.svg" alt="holder image for news section 1">
                            <div class="articles2">
                                <p class="header">Rentevoet Mijn VerbouwLening stijgt naar 2,75%</p>
                                <p>De rentevoet van Mijn VerbouwLening is gekoppeld aan de wettelijke rentevoet. Voorheen bedroeg de rentevoet van Mijn VerbouwLening 2,25%.... <a href="#">Lees meer</a></p>
                            </div>
                        </article>
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

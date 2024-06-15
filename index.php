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
// Haal de gebruiker op basis van de sessiegegevens (gebruikersnaam of ID)
$user_id = $_SESSION['id'];
$sql = "SELECT sociale_woning, premies_subsidies, particulieren_huurmarkt, sociaal_verhuurkantoor FROM user_chance_percentages WHERE user_id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Gebruiker gevonden, haal kanspercentages op
    $row = $result->fetch_assoc();
    $sociale_woning = $row['sociale_woning'];
    $premies_subsidies = $row['premies_subsidies'];
    $particulieren_huurmarkt = $row['particulieren_huurmarkt'];
    $sociaal_verhuurkantoor = $row['sociaal_verhuurkantoor'];
} else {
    // Gebruiker niet gevonden (zou normaal gesproken niet moeten gebeuren als de sessie juist is ingesteld)
    // Je kunt hier een fallback doen of een foutmelding geven
    echo "Gebruiker niet gevonden in de database.";
}

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
                $role = $_SESSION['firstname'];
                echo $role;
                } else {
                echo "firstname niet gevonden in sessie.";
                } 
            ?>
            <?php if(isset($_SESSION['lastname'])){
                $role = $_SESSION['lastname'];
                echo $role;
                } else {
                echo "lastname niet gevonden in sessie.";
                } 
            ?>
            - Housing Blitz
        </h3>

        <div class="content">
            <div class="kansHolder">
                <h1>Kans op een woning</h1>
                <div class="kans">
                    <div class="chart-container">
                        <?php
                            $progressValues = [$sociaal_verhuurkantoor, $particulieren_huurmarkt, $premies_subsidies, $sociale_woning];
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
                                <?php echo $sociale_woning; ?>%
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

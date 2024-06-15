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
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="styles/normalize.css">
  <link rel="stylesheet" href="styles/style.css">
  <link rel="stylesheet" href="styles/home.css">
  <title>Littlesun</title>
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
                <h1>Hoeveel kans maak jij</h1>
                <div class="kans">
                    <div class="chart-container">
                        <?php
                            $progressValues = [75, 80, 80, 40];
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
                                40%
                            </span>
                        </li>
                        <li> 
                            <strong>
                                Premies/Subsidies
                            </strong>
                            <span>
                                80%
                            </span>
                        </li>
                        <li> 
                            <strong>
                                Particulieren Huurmarkt
                            </strong>  
                            <span>
                                60%
                            </span>
                        </li>
                        <li> 
                            <strong>
                                Sociaal Verhuurkantoor
                            </strong>  
                            <span>
                                75%
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

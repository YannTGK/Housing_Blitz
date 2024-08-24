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

    // SQL query to calculate the priority score for the user
    $sql = "
        SELECT 
            users.id AS user_id,
            users.firstname,
            users.lastname,
            family_status.marital_status,
            COUNT(children.id) AS num_children,
            financial_info.income_amount,
            (
                CASE 
                    WHEN family_status.marital_status IN ('Ongehuwd/vrijgezel', 'Gescheiden', 'Weduwe/weduwnaar') THEN 50 -- Alleenstaande, gescheiden, weduwe/weduwnaar
                    ELSE 0 
                END 
                + COUNT(children.id) * 10 -- 10 punten per kind
                + CASE 
                    WHEN financial_info.income_amount < 20000 THEN 40
                    WHEN financial_info.income_amount BETWEEN 20000 AND 30000 THEN 20
                    WHEN financial_info.income_amount BETWEEN 30000 AND 40000 THEN 10
                    ELSE 0
                END
            ) AS priority_score
        FROM 
            users
        LEFT JOIN 
            family_status ON users.id = family_status.user_id
        LEFT JOIN 
            children ON users.id = children.user_id
        LEFT JOIN 
            financial_info ON users.id = financial_info.user_id
        WHERE
            users.id = $user_id
        GROUP BY 
            users.id, users.firstname, users.lastname, family_status.marital_status, financial_info.income_amount
        ORDER BY 
            priority_score DESC;
    ";

    $result = $conn->query($sql);

    if ($result === false) {
        // Error executing the query
        echo "Error: " . $conn->error;
    } else {
        $user_data = $result->fetch_assoc();
        if ($user_data) {
            $priority_score = $user_data['priority_score'];
        } else {
            echo "Gebruiker niet gevonden in de database.";
            $priority_score = 0;
        }
    }

    // Controleer of de posities al zijn opgeslagen in de sessie
    if (!isset($_SESSION['positie_per_stad'])) {
        // Simuleer de positie per stad en sla deze op in de sessie
        $steden = [
            'antwerpen' => ['min' => 600, 'max' => 1000],
            'vlaams-brabant' => ['min' => 400, 'max' => 900],
            'limburg' => ['min' => 300, 'max' => 800],
            'oost-vlaanderen' => ['min' => 500, 'max' => 900],
            'west-vlaanderen' => ['min' => 400, 'max' => 800],
            'henegouwen' => ['min' => 200, 'max' => 700],
            'luik' => ['min' => 300, 'max' => 800],
            'luxemburg' => ['min' => 100, 'max' => 500],
            'namen' => ['min' => 200, 'max' => 700],
            'waals-brabant' => ['min' => 300, 'max' => 800],
        ];

        $positie_per_stad = [];

        foreach ($steden as $stad => $range) {
            // Random positie binnen het gedefinieerde bereik
            $positie = rand($range['min'], $range['max']);
            $positie_per_stad[$stad] = $positie;
        }

        // Sorteer steden op basis van de positie (laagste eerst)
        asort($positie_per_stad);

        // Sla de posities op in de sessie
        $_SESSION['positie_per_stad'] = $positie_per_stad;
    } else {
        // Gebruik de posities die al in de sessie zijn opgeslagen
        $positie_per_stad = $_SESSION['positie_per_stad'];
    }
    
} else {
    echo "Gebruiker ID niet gevonden in sessie.";
    $priority_score = 0;
}

// Function to determine color based on priority score
function getProgressBarColor($score) {
    if ($score <= 35) {
        return '#f44336'; // Red
    } elseif ($score <= 60) {
        return '#ff9800'; // Orange
    } else {
        return '#4caf50'; // Green
    }
}

$progress_color = getProgressBarColor($priority_score);

?>
<!DOCTYPE html>
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

        <div class="content">
    <div class="left">
        <div class="positie">
            <h3>Je prioriteitsscore voor sociale woningen</h3>
            <p>Op basis van je gezinsstatus, aantal kinderen en inkomen, is je huidige prioriteitsscore: <strong><?php echo $priority_score; ?></strong></p>
            
            <h3>Je positie op sociale woningen</h3>
            <p>Je staat in de rij in de volgende steden voor een sociale woning:</p>
            
            <div class="positieKader">
                <?php foreach ($positie_per_stad as $stad => $positie): ?>
                <div class="positieHolder">
                    <p class="stad"><?php echo ucfirst(str_replace('-', ' ', $stad)); ?></p>
                    <p><?php echo $positie; ?>ste positie</p>
                    <div class="progress-bar">
                        <div class="progress-bar-fill" style="width: <?php echo (1000 - $positie) / 10; ?>%; background-color: <?php echo getProgressBarColor((1000 - $positie) / 10); ?>;"></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Flex container voor Tips en Contact -->
        <div class="bottom-section">
            <!-- Tips sectie -->
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
            <!-- Contact sectie -->
            <div class="contact">
                <h3>Professional Contacteren</h3>
                <p>Contacteer een professional in je buurt. Deze kan je helpen je slaagkans te vergroten.</p>
                <a href="#" class="button">Contacteer nu </a>        
            </div>
        </div>
    </div>
</div>

    <script>
        // Add any necessary JavaScript here
    </script>
</body>
</html>
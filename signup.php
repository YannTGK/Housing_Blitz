<?php
include_once(__DIR__."/classes/database.php");

if (!empty($_POST)){
    $conn = Db::getConnection();
    // Get the data from POST
    $Username = $_POST['Username'];
    $Password = $_POST['Password'];
    $FirstName = $_POST['FirstName'];
    $LastName = $_POST['LastName'];
    $Birthday = $_POST['Birthday'];
    $confirmPassword = $_POST['confirm_password'];
    
    // Check if username and password are not empty
    if (empty($Username) || empty($Password)) {
        $error = "Username and password cannot be empty!";
    }
    // Check if passwords match
    elseif ($Password !== $confirmPassword) {
        $error = "Passwords do not match!";
    } else {
        // Check if the username already exists in the database
        $query = "SELECT * FROM users WHERE username = '$Username'";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            $error = "Username already exists!";
        } else {
            // Hash password with bcrypt
            $options = [
                'cost' => 12
            ];

            $Password = password_hash($Password, PASSWORD_DEFAULT, $options);

            // Send the data to the users table
            $query = "INSERT into users (username, password, role, firstname, lastname, birthday) VALUES('$Username','$Password', 'user','$FirstName','$LastName', '$Birthday')";
            if ($conn->query($query) === TRUE) {
                $user_id = $conn->insert_id; // Get the last inserted ID

                // Get the list of city IDs
                $cities_result = $conn->query("SELECT id FROM steden");
                $cities = [];
                while ($city = $cities_result->fetch_assoc()) {
                    $cities[] = $city['id'];
                }

                // Shuffle the city IDs and pick two random ones
                shuffle($cities);
                $selected_cities = array_slice($cities, 0, 2);

                // Add dummy data for user_stad_chance_percentages in two random cities
                foreach ($selected_cities as $city_id) {
                    $dummy_sociale_woning = rand(0, 400);
                    $dummy_premies_subsidies = rand(0, 100);
                    $dummy_particulieren_huurmarkt = rand(0, 100);
                    $dummy_sociaal_verhuurkantoor = rand(0, 100);

                    $query = "INSERT INTO user_stad_chance_percentages (user_id, stad_id, sociale_woning_positie, premies_subsidies, particulieren_huurmarkt, sociaal_verhuurkantoor) VALUES ('$user_id', '$city_id', '$dummy_sociale_woning', '$dummy_premies_subsidies', '$dummy_particulieren_huurmarkt', '$dummy_sociaal_verhuurkantoor')";
                    $conn->query($query);
                }

                session_start(); // Start session
                $_SESSION['id'] = $user_id; // Store user ID in session
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $Username;
                $_SESSION['firstname'] = $FirstName;
                $_SESSION['lastname'] = $LastName;
                $_SESSION['birthday'] = $Birthday;
                $_SESSION['role'] = 'user';
                
                header("Location: index.php"); // Redirect to another page after successful submission
                exit; // Make sure to exit after redirection
            } else {
                $error = "Error: " . $conn->error;
            }
        }
    }
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Housing Blitz</title>
    <link rel="stylesheet" href="styles/normalize.css">
    <link rel="stylesheet" href="styles/login.css">
</head>
<body>
    <div class="display">
        <h1>Welkom op <strong>Housing Blitz</strong></h1>
        <h3>Waar jouw kans op woning gezocht wordt</h3>
    </div>  
    <div class="login2">
        <div class="loginHolder2">
            <div class="loginHeader">
                <h2>Sign up</h2>
                <p>Nog geen account? Dan kan je deze hier aanmaken</p>
            </div>
            <form class="form2holder" action="" method="post">
                <div class="form2items">
                    <div class="form2">
                        <label for="FirstName">Voornaam</label>
                        <input type="text" id="FirstName" name="FirstName" required>
                    </div>
                    <div class="form2">
                        <label for="LastName">Achternaam</label>
                        <input type="text" id="LastName" name="LastName" required>
                    </div>
                    <div class="form2">
                        <label for="Username">Gebruikersnaam</label>
                        <input type="text" id="Username" name="Username" required>
                    </div>
                    <div class="form2">
                        <label for="Birthday">Geboortedatum</label>
                        <input type="date" id="Birthday" name="Birthday" required>
                    </div>
                    <div class="form2">
                        <label for="Password">Wachtwoord</label>
                        <input type="password" id="Password" name="Password" required>
                    </div>
                    <div class="form2">
                        <label for="ConfirmPassword">Herhaal wachtwoord</label>
                        <input type="password" id="ConfirmPassword" name="confirm_password" required>
                    </div>
                </div>

                <div class="buttonHolder">
                    <?php if(isset($error)): ?>
                        <div class="form__field">
                            <p style="color: red;"><?php echo $error; ?></p>
                        </div>
                    <?php endif; ?>
            
                    <div class="btn">
                        <input type="submit" value="Sign Up" class="formButton">
                    </div>
              
                <div class="btnitsme">
                <button class="formButton">Sign-up with itsme</button>
                </div>
         </div>
            </form>

        
        

            <div class="signupinfo">
                <p>Heb je al een account?</p>
                <a href="login.php">login</a>
            </div>

        </div>
        
    </div>
</body>
</html>

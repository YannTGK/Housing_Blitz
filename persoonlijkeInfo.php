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

    // Fetch financial information
    $sql_financial_info = "SELECT income_source, income_amount FROM financial_info WHERE user_id = $user_id";
    $result_financial_info = $conn->query($sql_financial_info);
    $financial_info = $result_financial_info->fetch_assoc();

    // Fetch fixed expenses
    $sql_fixed_expenses = "SELECT expense_title, expense_amount FROM fixed_expenses WHERE user_id = $user_id";
    $result_fixed_expenses = $conn->query($sql_fixed_expenses);
    $fixed_expenses = [];
    while($row = $result_fixed_expenses->fetch_assoc()) {
        $fixed_expenses[] = $row;
    }

    // Fetch children information
    $sql_children = "SELECT first_name, last_name, birth_date, relationship FROM children WHERE user_id = $user_id";
    $result_children = $conn->query($sql_children);
    $children = [];
    while($row = $result_children->fetch_assoc()) {
        $children[] = $row;
    }

    // Fetch family status
    $sql_family_status = "SELECT marital_status, housing_situation FROM family_status WHERE user_id = $user_id";
    $result_family_status = $conn->query($sql_family_status);
    $family_status = $result_family_status->fetch_assoc();

    // Fetch allowed income sources
    $sql_income_sources = "SELECT income_source FROM allowed_income_sources";
    $result_income_sources = $conn->query($sql_income_sources);
    $income_sources = [];
    while($row = $result_income_sources->fetch_assoc()) {
        $income_sources[] = $row['income_source'];
    }
} else {
    echo "Gebruiker ID niet gevonden in sessie.";
    $laagste_positie = 0;
}
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="styles/normalize.css">
  <link rel="stylesheet" href="styles/style.css">
  <link rel="stylesheet" href="styles/persoonlijkeInfo.css">
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
            <h1>Persoonlijke Info</h1>
            <form id="persoonlijkeInfoForm" action="/submit" method="post">
                <div class="sectie1 sectie">
                    <div class="spacing">
                        <p class="header">Financiële Informatie</p>
                        <div class="inline">
                            <label for="number_income_sources">Aantal inkomstbronnen</label>
                            <select id="number_income_sources" name="number_income_sources" onchange="updateIncomeSources()">
                                <?php for ($i = 1; $i <= 8; $i++): ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div id="income_sources_container">
                            <div class="next">
                                <div class="under">
                                    <label for="income_source_0">1e inkomstbron</label>
                                    <select id="income_source_0" name="income_source_0">
                                        <?php foreach ($income_sources as $source): ?>
                                            <option value="<?= htmlspecialchars($source) ?>"><?= htmlspecialchars($source) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="amount under">
                                    <label for="income_amount_0">Bedrag</label>
                                    <input type="text" id="income_amount_0" name="income_amount_0">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="spacing">
                        <p class="header">Vaste uitgaven</p>
                        <div class="inline">
                            <label for="expences_source">Vaste uitgaven</label>
                            <select id="expences_source" name="expences_source">
                                <option value="1">1</option>
                                <option value="2">2</option>
                            </select>
                        </div>
                        <div class="under">
                            <?php foreach ($fixed_expenses as $index => $expense) { ?>
                                <div>
                                    <div class="next">
                                        <div class="under">
                                            <label for="expense_title_<?= $index ?>">Titel</label>
                                            <input type="text" id="expense_title_<?= $index ?>" name="expense_title_<?= $index ?>" value="<?= $expense['expense_title'] ?>">
                                        </div>
                                        <div class="under">
                                            <label for="expense_amount_<?= $index ?>">Bedrag</label>
                                            <input type="text" id="expense_amount_<?= $index ?>" name="expense_amount_<?= $index ?>" value="<?= $expense['expense_amount'] ?>">
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="sectie2 sectie">
                    <div class="spacing">
                        <div class="inline">
                            <label for="child" class="header">Kinderen ten laste</label>
                            <select id="child" name="child">
                                <option value="1">1</option>
                                <option value="2" selected>2</option>
                            </select>
                        </div>
                        <div class="children">
                            <?php foreach ($children as $index => $child) { ?>
                                <div class="form-group">
                                    <div class="next">
                                        <div class="under">
                                            <label for="child_first_name_<?= $index ?>">Kind <?= $index + 1 ?> - Voornaam</label>
                                            <input type="text" id="child_first_name_<?= $index ?>" name="child_first_name_<?= $index ?>" value="<?= $child['first_name'] ?>">
                                        </div>
                                        <div class="under">
                                            <label for="child_last_name_<?= $index ?>">Achternaam</label>
                                            <input type="text" id="child_last_name_<?= $index ?>" name="child_last_name_<?= $index ?>" value="<?= $child['last_name'] ?>">
                                        </div>
                                    </div>
                                    <div class="next">
                                        <div class="under">
                                            <label for="child_birth_date_<?= $index ?>">Geboorte datum</label>
                                            <input type="date" id="child_birth_date_<?= $index ?>" name="child_birth_date_<?= $index ?>" value="<?= $child['birth_date'] ?>">
                                        </div>
                                        <div class="under">
                                            <label for="child_relationship_<?= $index ?>">Familie verband</label>
                                            <select id="child_relationship_<?= $index ?>" name="child_relationship_<?= $index ?>">
                                                <option value="Zoon" <?= $child['relationship'] == 'Zoon' ? 'selected' : '' ?>>Zoon</option>
                                                <option value="Dochter" <?= $child['relationship'] == 'Dochter' ? 'selected' : '' ?>>Dochter</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="sectie3 .sectie">
                    <div class="form-group">
                        <div class="radio-group">
                            <label class="header">Burgerlijke staat</label>
                            <label><input type="radio" name="marital_status" value="Ongehuwd/vrijgezel" <?= $family_status['marital_status'] == 'Ongehuwd/vrijgezel' ? 'checked' : '' ?>> Ongehuwd/vrijgezel</label>
                            <label><input type="radio" name="marital_status" value="Gehuwd" <?= $family_status['marital_status'] == 'Gehuwd' ? 'checked' : '' ?>> Gehuwd</label>
                            <label><input type="radio" name="marital_status" value="Wettelijk samenwonend" <?= $family_status['marital_status'] == 'Wettelijk samenwonend' ? 'checked' : '' ?>> Wettelijk samenwonend</label>
                            <label><input type="radio" name="marital_status" value="Gescheiden" <?= $family_status['marital_status'] == 'Gescheiden' ? 'checked' : '' ?>> Gescheiden</label>
                            <label><input type="radio" name="marital_status" value="Weduwe/weduwenaar" <?= $family_status['marital_status'] == 'Weduwe/weduwenaar' ? 'checked' : '' ?>> Weduwe/weduwenaar</label>
                            <label><input type="radio" name="marital_status" value="Feitelijk samenwonend" <?= $family_status['marital_status'] == 'Feitelijk samenwonend' ? 'checked' : '' ?>> Feitelijk samenwonend</label>
                        </div>
                        <div class="radio-group">
                            <label class="header">Woonsituatie</label>
                            <label><input type="radio" name="housing_situation" value="Huurwoning" <?= $family_status['housing_situation'] == 'Huurwoning' ? 'checked' : '' ?>> Huurwoning</label>
                            <label><input type="radio" name="housing_situation" value="Eigen woning" <?= $family_status['housing_situation'] == 'Eigen woning' ? 'checked' : '' ?>> Eigen woning</label>
                            <label><input type="radio" name="housing_situation" value="Rusthuis/Woonzorgcentrum" <?= $family_status['housing_situation'] == 'Rusthuis/Woonzorgcentrum' ? 'checked' : '' ?>> Rusthuis/Woonzorgcentrum</label>
                            <label><input type="radio" name="housing_situation" value="Tijdelijke huisvesting" <?= $family_status['housing_situation'] == 'Tijdelijke huisvesting' ? 'checked' : '' ?>> Tijdelijke huisvesting</label>
                            <label><input type="radio" name="housing_situation" value="Gemeenschapsleven" <?= $family_status['housing_situation'] == 'Gemeenschapsleven' ? 'checked' : '' ?>> Gemeenschapsleven</label>
                        </div>
                    </div>
                </div>
            </form>
            <div class="voet">
                <div class="form-group">
                    <p class="header">Belastingaangifte</p>
                    <input type="file" id="tax_file" name="tax_file">
                </div>
                <button type="submit" id="buttonForm" class="button">Opslaan</button>
            </div>
        </div>
    </div>

    <script>
        const incomeSourcesContainer = document.getElementById('income_sources_container');
        const numberIncomeSources = document.getElementById('number_income_sources');
        const incomeSources = <?= json_encode($income_sources) ?>;

        function createIncomeSourceDropdown(index) {
            const divNext = document.createElement('div');
            divNext.classList.add('next');

            const divUnderSource = document.createElement('div');
            divUnderSource.classList.add('under');

            const label = document.createElement('label');
            label.htmlFor = `income_source_${index}`;
            label.innerText = `${index + 1}e inkomstbron`;
            divUnderSource.appendChild(label);

            const select = document.createElement('select');
            select.id = `income_source_${index}`;
            select.name = `income_source_${index}`;
            incomeSources.forEach(source => {
                const option = document.createElement('option');
                option.value = source;
                option.innerText = source;
                select.appendChild(option);
            });
            divUnderSource.appendChild(select);

            divNext.appendChild(divUnderSource);

            const divAmount = document.createElement('div');
            divAmount.classList.add('amount', 'under');

            const labelAmount = document.createElement('label');
            labelAmount.htmlFor = `income_amount_${index}`;
            labelAmount.innerText = 'Bedrag';
            divAmount.appendChild(labelAmount);

            const inputAmount = document.createElement('input');
            inputAmount.type = 'text';
            inputAmount.id = `income_amount_${index}`;
            inputAmount.name = `income_amount_${index}`;
            divAmount.appendChild(inputAmount);

            divNext.appendChild(divAmount);

            return divNext;
        }

        function updateIncomeSources() {
            incomeSourcesContainer.innerHTML = '';
            const count = parseInt(numberIncomeSources.value, 10);
            for (let i = 0; i < count; i++) {
                incomeSourcesContainer.appendChild(createIncomeSourceDropdown(i));
            }
        }

        numberIncomeSources.addEventListener('change', updateIncomeSources);
        window.addEventListener('DOMContentLoaded', updateIncomeSources);
    </script>
</body>
</html>

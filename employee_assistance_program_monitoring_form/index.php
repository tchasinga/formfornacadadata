<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$success_message = "";
$error_message = "";

// API credentials
$url = "https://monitoring.jocsoft.net/dhis/api/dataValueSets";
$username = "jack";
$password = "Jocsoft@2027!!";

function getCurrentQuarter() {
    $month = date('n'); // Current month (1-12)
    $year = date('Y'); // Current year

    // Determine quarter based on month (Q1: Jan-Mar, Q2: Apr-Jun, Q3: Jul-Sep, Q4: Oct-Dec)
    if ($month >= 1 && $month <= 3) {
        return $year . "Q1";
    } elseif ($month >= 4 && $month <= 6) {
        return $year . "Q2";
    } elseif ($month >= 7 && $month <= 9) {
        return $year . "Q3";
    } else {
        return $year . "Q4";
    }
}

function getQuarterOptions() {
    $current_year = date('Y');
    $options = [];
    
    // Generate options for current year and previous year
    for ($year = $current_year - 1; $year <= $current_year + 1; $year++) {
        for ($quarter = 1; $quarter <= 4; $quarter++) {
            $options[] = $year . "Q" . $quarter;
        }
    }
    
    return $options;
}

// Get current quarter for default selection
$current_quarter = getCurrentQuarter();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $value = $_POST['value'];
    $reporting_period = $_POST['reporting_period'];
    $health_center = $_POST['health_center'];

    $data = [
        "dataSet" => "hb6Y59T4YEc",
        "completeDate" => date("Y-m-d"),
        "period" => $reporting_period, // Use the selected reporting period
        "orgUnit" => "ORwhnDymBpM",
        "dataValues" => [
            [
                "dataElement" => "CirTnd6QQTO",
                "value" => $value
            ],
            [
                "dataElement" => "N11bNXXYl8E",
                "value" => $reporting_period
            ],
            [
                "dataElement" => "E8FUm5o1CaH",
                "value" => $health_center
            ],
        ]
    ];

    $payload = json_encode($data);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        $error_message = "Curl error: " . curl_error($ch);
    } else {
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($http_code == 200 || $http_code == 201) {
            $success_message = "Data submitted successfully!";
        } else {
            $error_message = "Error: HTTP $http_code - " . $response;
        }
    }

    curl_close($ch);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EMPLOYEE ASSISTANCE PROGRAM MONITORING FORM</title>
    <style>
        form > div{
            display: flex;
            flex-direction: column;
            max-width: 400px;
        }
        label {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <?php if ($success_message): ?>
        <div style="color: green; padding: 10px; margin: 10px 0; border: 1px solid green;">
            <?php echo htmlspecialchars($success_message); ?>
        </div>
    <?php endif; ?>
    
    <?php if ($error_message): ?>
        <div style="color: red; padding: 10px; margin: 10px 0; border: 1px solid red;">
            <?php echo htmlspecialchars($error_message); ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div>
            <label for="value">Name of the Institution:</label>
            <input type="text" name="value" id="value" required />
        </div>

        <div>
            <label for="reporting_period">Reporting quarter:</label>
            <select name="reporting_period" id="reporting_period" required>
                <option value="">Select Quarter</option>
                <?php
                $quarter_options = getQuarterOptions();
                foreach ($quarter_options as $option) {
                    $selected = ($option === $current_quarter) ? 'selected' : '';
                    echo "<option value=\"$option\" $selected>$option</option>";
                }
                ?>
            </select>
        </div>
        <div>
             <h2>EAP services available</h2>
             
             <input type="checkbox" id="health_center" name="health_center" value="health_center">
<label for="health_center">EAPM - In-house clinic/health center/EAP</label><br>
        </div>

        <button type="submit">Submit</button>
    </form>
</body>
</html>
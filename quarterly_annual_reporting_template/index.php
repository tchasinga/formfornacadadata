<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$success_message = "";
$error_message = "";

// API credentials
$url = "https://monitoring.jocsoft.net/dhis/api/dataValueSets";
$username = "jack";
$password = "Jocsoft@2027!!";

// Function to get current quarter (DHIS2 standard quarters)
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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$value = $_POST['value'];
    $prevention_activities = $_POST['prevention_activities'];
    $reporting_period = $_POST['reporting_period'];
    $quarter_achievement = $_POST['quarter_achievement'];
    $quarter_in = $_POST['quarter_in'];
    $for_the_quarter = $_POST['for_the_quarter'];
    $variance_for_the_quarter = $_POST['variance_for_the_quarter'];
    $achievement_to_date = $_POST['achievement_to_date'];

	// Use user-provided period if present, otherwise default to current quarter
	$userPeriod = isset($_POST['period']) ? trim($_POST['period']) : '';
	$currentPeriod = $userPeriod !== '' ? $userPeriod : getCurrentQuarter();

    $data = [
		"dataSet" => "n65Xeqc6HN1",
		"completeDate" => date("Y-m-d"),
		"period" => $currentPeriod,
		"orgUnit" => "ORwhnDymBpM",
		"dataValues" => [
			[
				"dataElement" => "Ar1Rlf7Yfkq",
				"value" => $value
            ],
            [
				"dataElement" => "lmOU0RK4aYg",
				"value" => $prevention_activities
			],
            [
				"dataElement" => "k9JFftbp7x3",
				"value" => $reporting_period
			],
            [
				"dataElement" => "B6Erpz2KXpC",
				"value" => $quarter_achievement
			],
            [
				"dataElement" => "tsD42vC6oDG",
				"value" => $quarter_in
			],
            [
				"dataElement" => "Jl3akdWGvKD",
				"value" => $for_the_quarter
			],
            [
				"dataElement" => "Ck5dK8YBkIW",
				"value" => $variance_for_the_quarter
			],
            [
				"dataElement" => "kID9ezyALKP",
				"value" => $achievement_to_date
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
            $success_message = "Data submitted successfully for period $currentPeriod!";
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
    <title>QUARTERLY/ANNUAL REPORTING TEMPLATE</title>
    <style>
        form{
            display:flex;
            flex-direction:column;
            max-width: 400px;
        }
        .message { padding: 10px; margin: 10px 0; border-radius: 4px; }
        .success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>
    <h1>QUARTERLY/ANNUAL REPORTING TEMPLATE</h1>
    
    <?php if (!empty($success_message)): ?>
        <div class="message success"><?php echo htmlspecialchars($success_message); ?></div>
    <?php endif; ?>
    
    <?php if (!empty($error_message)): ?>
        <div class="message error"><?php echo htmlspecialchars($error_message); ?></div>
    <?php endif; ?>
    
    <form method="POST">
        <label for="period">Reporting Period (e.g., 2025Q2)</label>
        <input type="text" name="period" id="period" value="<?php echo htmlspecialchars(getCurrentQuarter()); ?>" required />
       
        <label for="value">ADA-Name of the Institution</label>
        <input type="text" name="value" id="value" required />

        <label for="prevention_activities">Annual ADA Prevention activities</label>
        <input type="text" name="prevention_activities" id="prevention_activities" required />

        <label for="reporting_period">Progress during the quarter/reporting period</label>
        <input type="text" name="reporting_period" id="reporting_period" required />

        <label for="quarter_achievement">Indicator(s) of quarter achievement</label>
        <input type="text" name="quarter_achievement" id="quarter_achievement" required />

        <label for="quarter_in">Performance for the quarter in (%)</label>
        <input type="text" name="quarter_in" id="quarter_in" required />

        <label for="for_the_quarter">Target for the quarter (%)</label>
        <input type="text" name="for_the_quarter" id="for_the_quarter" required />

        <label for="variance_for_the_quarter">Variance for the quarter (%)</label>
        <input type="text" name="variance_for_the_quarter" id="variance_for_the_quarter" required />

        <button type="submit">Submit</button>
    </form>
    
    <p><strong>Current Reporting Period:</strong> <?php echo getCurrentQuarter(); ?></p>
</body>
</html>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$success_message = "";
$error_message = "";

// API credentials
$url = "https://monitoring.jocsoft.net/dhis/api/dataValueSets";
$username = "jack";
$password = "Jocsoft@2027!!";

// Function to get current quarter
function getCurrentQuarter() {
    $month = date('n'); // Current month (1-12)
    $year = date('Y'); // Current year
    
    // Determine quarter based on month
    if ($month >= 1 && $month <= 4) {
        return $year . "Q1"; // Jan-Apr
    } elseif ($month >= 5 && $month <= 8) {
        return $year . "Q2"; // May-Aug
    } else {
        return $year . "Q3"; // Sep-Dec
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $value = $_POST['value'];
    
    // Get current quarter
    $currentPeriod = getCurrentQuarter();

    $data = [
        "dataSet" => "n65Xeqc6HN1",
        "completeDate" => date("Y-m-d"),
        "period" => $currentPeriod,
        "orgUnit" => "ORwhnDymBpM",
        "dataValues" => [
            [
                "dataElement" => "Ar1Rlf7Yfkq",
                "value" => $value
            ]
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
        <label for="value">ADA-Name of the Institution</label>
        <input type="text" name="value" id="value" required />
        <button type="submit">Submit</button>
    </form>
    
    <p><strong>Current Reporting Period:</strong> <?php echo getCurrentQuarter(); ?></p>
</body>
</html>
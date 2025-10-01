<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$success_message = "";
$error_message = "";

// API credentials
$url = "https://monitoring.jocsoft.net/dhis/api/dataValueSets";
$username = "jack";
$password = "Jocsoft@2027!!";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $value = $_POST['value'];
   

    $data = [
        "dataSet" => "uQFmtDzKIYZ",
        "completeDate" => date("Y-m-d"),
        "period" => "2024",
        "orgUnit" => "ORwhnDymBpM",
        "dataValues" => [
            [
                "dataElement" => "udyCSmJ3aYy",
                "value" => $value
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
    <title>Reporting Format on Prevention, Control and Management of Alcohol and Substance Use at School Level data entry form</title>
</head>
<body>
    <form method="POST">
        <label for="value">Value</label>
        <input type="text" name="value" id="value">
        <button type="submit">Submit...</button>
    </form>
</body>
</html>
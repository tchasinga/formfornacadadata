<?php
// Get form input
$malaria_cases = $_POST['malaria_cases'];

// DHIS2 connection details
$url = "https://monitoring.jocsoft.net/dhis/api/dataValueSets"; // Change to your DHIS2 instance
$username = "jack";     // Replace with your DHIS2 username
$password = "Jocsoft@2027!!";  // Replace with your DHIS2 password

// Build payload
$data = [
    "dataSet" => "SQAjVomXv0s",           // dataset ID (replace with yours)
    "completeDate" => date("Y-m-d"),
    "period" => "202508",               // current year+month e.g. 202509
    "orgUnit" => "FdXc2bAfqzd",           // org unit ID (facility)
    "dataValues" => [
        [
            "dataElement" => "Bky63h2AUxp",   // malaria cases data element ID
            "value" => $malaria_cases
        ]
    ]
];

// Initialize cURL
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

// Execute and get response
$response = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Decode response
$result = json_decode($response, true);

if ($httpcode == 200 || $httpcode == 201) {
    if (isset($result['status']) && $result['status'] == 'SUCCESS') {
        echo "<p style='color:green;'>✅ Data saved successfully!</p>";
    } else {
        echo "<p style='color:orange;'>⚠️ Request sent, but check details below.</p>";
    }
} else {
    echo "<p style='color:red;'>❌ Failed to save data. HTTP Code: $httpcode</p>";
}

// Show raw response for debugging
echo "<pre>" . htmlspecialchars($response) . "</pre>";
?>
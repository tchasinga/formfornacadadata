<?php
// Handle CORS
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// DHIS2 API credentials
$username = "jack";
$password = "Jocsoft@2027!!";
$baseUrl = "https://monitoring.jocsoft.net/dhis/api/tracker";

// Get the posted data
$data = json_decode(file_get_contents("php://input"));

// Prepare the payload for DHIS2
$payload = json_encode($data);

// Initialize cURL session
$ch = curl_init();

// Set cURL options
curl_setopt($ch, CURLOPT_URL, $baseUrl);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($payload)
));

// Execute the request
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// Check for errors
if (curl_errno($ch)) {
    $error_msg = curl_error($ch);
    echo json_encode([
        "status" => "error",
        "message" => "cURL Error: " . $error_msg
    ]);
} else {
    if ($httpCode >= 200 && $httpCode < 300) {
        echo json_encode([
            "status" => "success",
            "message" => "Enrollment created successfully.",
            "response" => json_decode($response)
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "DHIS2 API Error (HTTP $httpCode): " . $response
        ]);
    }
}

// Close cURL session
curl_close($ch);
?>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$success_message = "";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name_of_contact_person = $_POST['name_of_contact_person'];
    $mobile_number = $_POST['mobile_number'];
    $email_address_of_contact_person = $_POST['email_address_of_contact_person'];
    $organization = $_POST['organization'];
    $number_of_participants = $_POST['number_of_participants'];
 
    
   

    
    $url = "https://monitoring.jocsoft.net/dhis/api/tracker";
    $username = "admin";
    $password = "Jocsoft@2025!";

    // Corrected DHIS2 payload structure
    $data = [
        "trackedEntities" => [
            [
                "attributes" => [
                    [
                        "attribute" => "ubboTrUjHgI", // Full Name attribute
                        "value" => $name_of_contact_person
                    ]
                ],
                "enrollments" => [
                    [
                        "enrolledAt" => date("Y-m-d"),
                        "occurredAt" => date("Y-m-d"),
                        "orgUnit" => "ORwhnDymBpM",
                        "program" => "qe6YyhZxdig",
                        "status" => "ACTIVE",
                        "events" => [
                            [
                                "dataValues" => [
                                    [
                                        "dataElement" => "j4HzS4rPYj6",
                                        "value" => $name_of_contact_person
                                    ],
                                    [
                                        "dataElement" => "VdsNUj9NJvL",
                                        "value" => $mobile_number
                                    ],
                                    [
                                        "dataElement" => "SMyZqFsr9rQ",
                                        "value" => $email_address_of_contact_person
                                    ],
                                    [
                                        "dataElement" => "aTgEEzrsXRY",
                                        "value" => $organization
                                    ],
                                    [
                                        "dataElement" => "OD1J33PcpOx",
                                        "value" => $number_of_participants
                                    ],

                                ],
                                "enrollmentStatus" => "ACTIVE",
                                "notes" => [
                                    [
                                        "value" => "Needs review"
                                    ]
                                ],
                                "occurredAt" => date("Y-m-d"),
                                "orgUnit" => "ORwhnDymBpM",
                                "program" => "qe6YyhZxdig",
                                "programStage" => "BK0u9qeQHLZ",
                                "status" => "ACTIVE"
                            ]
                        ]
                    ]
                ],
                "orgUnit" => "ORwhnDymBpM",
                "trackedEntityType" => "h63vN1RMO4P"
            ]
        ]
    ];

    // Encode to JSON
    $jsonData = json_encode($data);
    
    if ($jsonData === false) {
        $error_message = "JSON encoding failed: " . json_last_error_msg();
    } else {
        // Send request
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Accept: application/json",
            "Content-Length: " . strlen($jsonData)
        ]);
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            $error_message = "cURL Error: " . curl_error($ch);
        } else {
            if ($httpcode == 200 || $httpcode == 201) {
                $success_message = "Tracked Entity + Enrollment created successfully!";
                $success_message .= "<br>Response: " . htmlspecialchars($response);
            } else {
                $error_message = "Failed. HTTP Code: $httpcode";
                $error_message .= "<br>Response: " . htmlspecialchars($response);
            }
        }
        curl_close($ch);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>ORGANIZATION/GROUP BOOKING DETAILS...</title>
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            margin: 0; 
            padding: 20px; 
            background-color: #f5f9fc;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #2c3e50;
            margin-top: 0;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
        }
        form { 
            margin-bottom: 25px; 
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #2c3e50;
        }
        input[type="email"], select { 
            padding: 12px; 
            width: 100%; 
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        input[type="email"]:focus, select:focus {
            border-color: #3498db;
            outline: none;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.5);
        }
        button { 
            padding: 12px 24px; 
            background: #3498db; 
            color: white; 
            border: none; 
            border-radius: 4px;
            cursor: pointer; 
            font-size: 16px;
            font-weight: 600;
            transition: background 0.3s;
        }
        button:hover { 
            background: #2980b9; 
        }
        .message {
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .success {
            color: #155724;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
        }
        .error {
            color: #721c24;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
        }
        .response {
            margin-top: 10px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 4px;
            font-family: monospace;
            font-size: 14px;
            overflow-x: auto;
        }
        .info-box {
            background-color: #e8f4fc;
            border-left: 4px solid #3498db;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>ORGANIZATION/GROUP BOOKING DETAILS </h2>
        
        <form method="POST">
            <div class="form-group">
                       <label for="name_of_contact_person">Name of contact person</label>
                <input type="text" id="name_of_contact_person" name="name_of_contact_person" required 
                       value="<?php echo isset($_POST['name_of_contact_person']) ? htmlspecialchars($_POST['name_of_contact_person']) : ''; ?>">
                       
                       <label for="mobile_number">Mobile number </label>
                <input type="tel" id="mobile_number" name="mobile_number" required 
                       value="<?php echo isset($_POST['mobile_number']) ? htmlspecialchars($_POST['mobile_number']) : ''; ?>">

                       <label for="email_address_of_contact_person">Email address of contact person </label>
                <input type="email" id="email_address_of_contact_person" name="email_address_of_contact_person" required 
                       value="<?php echo isset($_POST['email_address_of_contact_person']) ? htmlspecialchars($_POST['email_address_of_contact_person']) : ''; ?>">

                       <label for="organization">Your organization </label>
                <input type="text" id="organization" name="organization" required 
                       value="<?php echo isset($_POST['organization']) ? htmlspecialchars($_POST['organization']) : ''; ?>">
            </div>
            <button type="submit">Submit to DHIS2</button>
        </form>

        <?php if ($success_message): ?>
            <div class="message success">
                <strong>Success!</strong> 
                <?php 
                // Display the success message without the technical details for better UX
                $msg = explode("<br>", $success_message);
                echo $msg[0]; 
                ?>
                <div class="response">
                    <?php 
                    // Show the response details in a formatted way
                    if (isset($msg[1])) echo $msg[1]; 
                    ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($error_message): ?>
            <div class="message error">
                <strong>Error:</strong> 
                <?php 
                $msg = explode("<br>", $error_message);
                echo $msg[0]; 
                ?>
                <div class="response">
                    <?php 
                    if (isset($msg[1])) echo $msg[1]; 
                    ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
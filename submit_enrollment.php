<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$success_message = "";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['email'])) {
        $error_message = "Email is required";
    } else {
        $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
        $result_of =$_POST['result_of'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error_message = "Invalid email format";
        } else {
            $url = "https://monitoring.jocsoft.net/dhis/api/tracker";
            $username = "jack";
            $password = "Jocsoft@2027!!";

            // Corrected DHIS2 payload structure
            $data = [
                "trackedEntities" => [
                    [
                        "attributes" => [
                            [
                                "attribute" => "dWzFql09XrP", // Full Name attribute
                                "value" => $email
                            ]
                        ],
                        "enrollments" => [
                            [
                                "enrolledAt" => date("Y-m-d"),
                                "occurredAt" => date("Y-m-d"),
                                "orgUnit" => "ORwhnDymBpM",
                                "program" => "xgnmW6SqEzS",
                                "status" => "ACTIVE",
                                "events" => [  // Events should be inside enrollment
                                    [
                                        "dataValues" => [
                                            [
                                                "dataElement" => "XSgW3LecsM8",
                                                "value" => $result_of
                                             ]
                                        ],
                                        "enrollmentStatus" => "ACTIVE",
                                        "notes" => [
                                            [
                                                "value" => "Needs review"
                                            ]
                                        ],
                                        "occurredAt" => date("Y-m-d"),
                                        "orgUnit" => "ORwhnDymBpM",
                                        "program" => "xgnmW6SqEzS",
                                        "programStage" => "fYJR2ycBGZY",
                                        "status" => "ACTIVE"
                                    ]
                                ]
                            ]
                        ],
                        "orgUnit" => "ORwhnDymBpM",
                        "trackedEntityType" => "ad6uk49xve7" // trackdatacollector entity
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
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>DHIS2 Enrollment (Tracker API)</title>
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
        <h2>DHIS2 Enrollment Form</h2>
        
        <div class="info-box">
            <strong>Note:</strong> This form will create a Tracked Entity Instance with an enrollment in the DHIS2 system.
            The email address will be stored as an attribute value.
        </div>
        
        <form method="POST">
            <div class="form-group">
                <label for="email">Email Address:</label>
                <input type="email" id="email" name="email" placeholder="Enter valid email address" required 
                       value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
            </div>
            <div class="form-group">
                <label for="qi">Alcohol or drug use is the result of:</label>
                <select name ="result_of" class="form-group">
                <option value="Personality flaws.">Personality flaws.</option>
                <option value="Inheritance">Inheritance</option>
                <option value="Mental problems">Mental problems</option>
                </select>
               
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

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
        
        // Check if other fields are set before accessing them
        $result_of = isset($_POST['result_of']) ? $_POST['result_of'] : '';
        $world_is = isset($_POST['world_is']) ? $_POST['world_is'] : '';
        $prevention_policy = isset($_POST['prevention_policy']) ? $_POST['prevention_policy'] : '';
        $policy_should = isset($_POST['policy_should']) ? $_POST['policy_should'] : '';
        $explain_to_the_workforce = isset($_POST['explain_to_the_workforce']) ? $_POST['explain_to_the_workforce'] : '';
        $important_in = isset($_POST['important_in']) ? $_POST['important_in'] : '';
        $the_kenya_is = isset($_POST['the_kenya_is']) ? $_POST['the_kenya_is'] : '';
        



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
                                "attribute" => "v7FLq8y7EMu", // Full Name attribute
                                "value" => $email
                            ]
                        ],
                        "enrollments" => [
                            [
                                "enrolledAt" => date("Y-m-d"),
                                "occurredAt" => date("Y-m-d"),
                                "orgUnit" => "ORwhnDymBpM",
                                "program" => "PgKF7mXlZe0",
                                "status" => "ACTIVE",
                                "events" => [  // Events inside enrollment
                                    [
                                        "dataValues" => [
                                            [
                                                "dataElement" => "GfkJ46rlDC9",
                                                "value" => $result_of
                                            ],
                                            [
                                                "dataElement" => "nn3RF8kNu9T",
                                                "value" => $world_is
                                            ],
                                            [
                                                "dataElement" => "sXIQhe0qgNo",
                                                "value" => $prevention_policy
                                            ],
                                            [
                                                "dataElement" => "uGteI7r8d5o",
                                                "value" => $policy_should
                                            ],
                                            [
                                                "dataElement" => "ArBvYaC2cGf",
                                                "value" => $explain_to_the_workforce
                                            ],
                                            [
                                                "dataElement" => "xDfUrtO9If6",
                                                "value" => $important_in
                                            ],
                                            [
                                                "dataElement" => "equMnE3bDIK",
                                                "value" => $the_kenya_is
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
                                        "program" => "PgKF7mXlZe0",
                                        "programStage" => "ofNlBAcA1kY",
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
            max-width: 1200px;
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
                <option value="Interaction between personal characteristics and environmental influences.">Interaction between personal characteristics and environmental influences.</option>
				</select>
               
                <!-- second questions -->
                 <label for="q2">The most widely used illicit substance in the world is</label>
                 <select name="world_is" class="form-group" >
                    <option value="Cannabis">Cannabis</option>
                    <option value="Tobacco">Tobacco</option>
                    <option value="Opioids">Opioids</option>
                    <option value="Alcohol">Alcohol</option>
                 </select>

                 <!-- third questions -->
                 <label for="q3">What is a Substance Use Prevention Policy?</label>
                 <select name="prevention_policy" class="form-group" >
                    <option value="A written document which specifies the need for substance prevention at work places">A written document which specifies the need for substance prevention at work places</option>
                    <option value="A written policy on how substance use violations should be dealt with at workplaces.">A written policy on how substance use violations should be dealt with at workplaces.</option>
                    <option value="A written description of the workplace’s position on the use of alcohol, illicit drugs and prescription drugs">A written description of the workplace’s position on the use of alcohol, illicit drugs and prescription drugs</option>
                    <option value="A written guideline for employers to ensure that no substance abuse takes place at the workplaces">A written guideline for employers to ensure that no substance abuse takes place at the workplaces</option>
                 </select>

                 <!-- foutrh questions -->
                 <label for="q4">The strategies for workplace alcohol and drug use prevention and management policy should</label>
                 <select name="policy_should" class="form-group" >
                    <option value="Address employees only in groups of their various degrees of substance use">Address employees only in groups of their various degrees of substance use</option>
                    <option value="Intervention is basically for the users only.">Intervention is basically for the users only.</option>
                    <option value="Be inclusive and address the entire prevention continuum.">Be inclusive and address the entire prevention continuum.</option>
                    <option value="Be interactive.">Be interactive.</option>
                 </select>

                 <!-- fifth questions -->
                 <label for="q5">When disseminating the policy of a workplace, what component of the policy is
                 important to explain to the workforce?</label>
                 <select name="explain_to_the_workforce" class="form-group" >
                    <option value="The general health and safety of all workers as well as the different components of the policy including the consequences for violating the policy.">The general health and safety of all workers as well as the different components of the policy including the consequences for violating the policy.</option>
                    <option value="How the company will benefit from the non-use of drugs and substances">How the company will benefit from the non-use of drugs and substances</option>
                    <option value="The importance of using EAP services">The importance of using EAP services</option>
                    <option value="Disciplinary measures to be taken against those who are intoxicated">Disciplinary measures to be taken against those who are intoxicated</option>
                 </select>

                 <!-- sixth questions -->
                 <label for="q6">The working population spends a significant amount of their time in their workplaces. So the workplace-based prevention interventions is important in</label>
                 <select name="important_in" class="form-group" >
                    <option value="Providing evidence for a positive return-on-investment.">Providing evidence for a positive return-on-investment.</option>
                    <option value="Providing training and education to the workers.">Providing training and education to the workers.</option>
                    <option value="Providing social status, subsistence, and stability to the workers.">Providing social status, subsistence, and stability to the workers.</option>
                    <option value="Providing the workers with new experiences, norms and behaviours">Providing the workers with new experiences, norms and behaviours</option>
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
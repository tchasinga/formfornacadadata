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
        $assistance_program = isset($_POST['assistance_program']) ? $_POST['assistance_program'] : '';
        $underutilized_by_employees = isset($_POST['underutilized_by_employees']) ? $_POST['underutilized_by_employees'] : '';
        $safety_issue_because = isset($_POST['safety_issue_because']) ? $_POST['safety_issue_because'] : '';
        

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error_message = "Invalid email format";
        } else {
            $url = "https://monitoring.jocsoft.net/dhis/api/tracker";
            $username = "jack";
            $password = "Jocsoft@2027!!";

            // Corrected DHIS2 payload structure XNJMXYLHuHS
            $data = [
                "trackedEntities" => [
                    [
                        "attributes" => [
                            [
                                "attribute" => "dWzFql09XrP", // Full Name attribute  dWzFql09XrP
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
                                            ],
                                            [
                                                "dataElement" => "yADpWccrRAU",
                                                "value" => $assistance_program
                                            ],
                                            [
                                                "dataElement" => "MCleXBjIWEM",
                                                "value" => $underutilized_by_employees
                                            ],
                                            [
                                                "dataElement" => "AcYJVH3G2ey",
                                                "value" => $safety_issue_because
                                            ],
                                            [
                                                "dataElement" => "XNJMXYLHuHS",
                                                "value" => $email
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POST TEST: WORKPLACE BASED PREVENTION INTERVENTIONS</title>
    <style>
        :root {
            --primary: #2c3e50;
            --secondary: #3498db;
            --accent: #2980b9;
            --light: #f5f9fc;
            --success: #27ae60;
            --error: #e74c3c;
            --text: #333;
            --text-light: #7f8c8d;
            --border: #ddd;
            --shadow: rgba(0, 0, 0, 0.1);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            background: linear-gradient(135deg, #f5f9fc 0%, #e8f4fc 100%);
            color: var(--text);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 700px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px var(--shadow);
            overflow: hidden;
        }
        
        header {
            background: linear-gradient(to right, var(--primary), var(--accent));
            color: white;
            padding: 25px 30px;
            text-align: center;
        }
        
        header h1 {
            font-size: 28px;
            margin-bottom: 10px;
            font-weight: 600;
        }
        
        header p {
            opacity: 0.9;
            font-size: 16px;
            max-width: 700px;
            margin: 0 auto;
        }
        
        .form-container {
            padding: 30px;
        }
        
        .info-box {
            background-color: #e8f4fc;
            border-left: 4px solid var(--secondary);
            padding: 18px;
            margin-bottom: 25px;
            border-radius: 6px;
            display: flex;
            align-items: flex-start;
        }
        
        .info-icon {
            margin-right: 12px;
            font-size: 20px;
            color: var(--secondary);
        }
        
        .form-section {
            max-width: 100%;
            margin: 0 auto;
            border-bottom: 1px solid #eee;
        }
        
        .form-section:last-of-type {
            border-bottom: none;
        }
        
        .section-title {
            font-size: 18px;
            color: var(--primary);
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid var(--secondary);
            display: inline-block;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--primary);
        }
        
        input[type="email"], select {
            padding: 14px;
            width: 100%;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: 16px;
            transition: all 0.3s;
            background-color: white;
        }
        
        input[type="email"]:focus, select:focus {
            border-color: var(--secondary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
        }
        
        select {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%237f8c8d' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 14px center;
            background-size: 16px;
            padding-right: 40px;
        }
        
        .submit-container {
            text-align: center;
            margin-top: 30px;
        }
        
        button {
            padding: 14px 30px;
            background: linear-gradient(to right, var(--secondary), var(--accent));
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s;
            box-shadow: 0 4px 10px rgba(52, 152, 219, 0.3);
        }
        
        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(52, 152, 219, 0.4);
        }
        
        button:active {
            transform: translateY(0);
        }
        
        .message {
            padding: 18px;
            border-radius: 6px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
        }
        
        .message-icon {
            margin-right: 12px;
            font-size: 20px;
        }
        
        .success {
            color: var(--success);
            background-color: rgba(39, 174, 96, 0.1);
            border-left: 4px solid var(--success);
        }
        
        .error {
            color: var(--error);
            background-color: rgba(231, 76, 60, 0.1);
            border-left: 4px solid var(--error);
        }
        
        .response {
            margin-top: 10px;
            padding: 12px;
            background-color: rgba(0, 0, 0, 0.03);
            border-radius: 4px;
            font-family: monospace;
            font-size: 14px;
            overflow-x: auto;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        footer {
            text-align: center;
            padding: 20px;
            color: var(--text-light);
            font-size: 14px;
            border-top: 1px solid #eee;
        }
        
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }
            
            .form-container {
                padding: 20px;
            }
            
            header {
                padding: 20px;
            }
            
            header h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>POST TEST: WORKPLACE BASED PREVENTION INTERVENTIONS</h1>
            <p>Complete this assessment to evaluate your knowledge on workplace substance use prevention</p>
        </header>
        
        <div class="form-container">
            <div class="info-box">
                <div class="info-icon">ℹ️</div>
                <div>Please provide your email address and answer all questions to complete the assessment.</div>
            </div>
            
            <?php if ($success_message): ?>
                <div class="message success">
                    <div class="message-icon">✅</div>
                    <div>
                        <strong>Success!</strong> 
                        <?php 
                        $msg = explode("<br>", "Data submitted successfully");
                        echo $msg[0]; 
                        ?>
                        <div class="response">
                            <?php if (isset($msg[1])) echo $msg[1]; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($error_message): ?>
                <div class="message error">
                    <div class="message-icon">❌</div>
                    <div>
                        <strong>Error:</strong> 
                        <?php 
                        $msg = explode("<br>", $error_message);
                        echo $msg[0]; 
                        ?>
                        <div class="response">
                            <?php if (isset($msg[1])) echo $msg[1]; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-section">
                    <h3 class="section-title">Personal Information</h3>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email address" required 
                               value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                    </div>
                </div>
                
                <div class="form-section">
                    <h3 class="section-title">Assessment Questions</h3>
                    
                    <div class="form-group">
                        <label for="result_of">Alcohol or drug use is the result of:</label>
                        <select name="result_of" id="result_of">
                            <option value="">Select one</option>
                            <option value="Personality flaws.">Personality flaws.</option>
                            <option value="Inheritance">Inheritance</option>
                            <option value="Mental problems">Mental problems</option>
                            <option value="Interaction between personal characteristics and environmental influences.">Interaction between personal characteristics and environmental influences.</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="world_is">The most widely used illicit substance in the world is:</label>
                        <select name="world_is" id="world_is">
                            <option value="">Select one</option>
                            <option value="Cannabis">Cannabis</option>
                            <option value="Tobacco">Tobacco</option>
                            <option value="Opioids">Opioids</option>
                            <option value="Alcohol">Alcohol</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="prevention_policy">What is a Substance Use Prevention Policy?</label>
                        <select name="prevention_policy" id="prevention_policy">
                        <option value="">Select one</option>
                            <option value="A written document which specifies the need for substance prevention at work places">A written document which specifies the need for substance prevention at work places</option>
                            <option value="A written policy on how substance use violations should be dealt with at workplaces.">A written policy on how substance use violations should be dealt with at workplaces.</option>
                            <option value="A written description of the workplace’s position on the use of alcohol, illicit drugs and prescription drugs">A written description of the workplace’s position on the use of alcohol, illicit drugs and prescription drugs</option>
                            <option value="A written guideline for employers to ensure that no substance abuse takes place at the workplaces">A written guideline for employers to ensure that no substance abuse takes place at the workplaces</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="policy_should">The strategies for workplace alcohol and drug use prevention and management policy should:</label>
                        <select name="policy_should" id="policy_should">
                        <option value="">Select one</option>
                            <option value="Address employees only in groups of their various degrees of substance use">Address employees only in groups of their various degrees of substance use</option>
                            <option value="Intervention is basically for the users only.">Intervention is basically for the users only.</option>
                            <option value="Be inclusive and address the entire prevention continuum.">Be inclusive and address the entire prevention continuum.</option>
                            <option value="Be interactive.">Be interactive.</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="explain_to_the_workforce">When disseminating the policy of a workplace, what component of the policy is important to explain to the workforce?</label>
                        <select name="explain_to_the_workforce" id="explain_to_the_workforce">
                        <option value="">Select one</option>
                            <option value="The general health and safety of all workers as well as the different components of the policy including the consequences for violating the policy.">The general health and safety of all workers as well as the different components of the policy including the consequences for violating the policy.</option>
                            <option value="How the company will benefit from the non-use of drugs and substances">How the company will benefit from the non-use of drugs and substances</option>
                            <option value="The importance of using EAP services">The importance of using EAP services</option>
                            <option value="Disciplinary measures to be taken against those who are intoxicated">Disciplinary measures to be taken against those who are intoxicated</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="important_in">The working population spends a significant amount of their time in their workplaces. So the workplace-based prevention interventions is important in:</label>
                        <select name="important_in" id="important_in">
                        <option value="">Select one</option>
                            <option value="Providing evidence for a positive return-on-investment.">Providing evidence for a positive return-on-investment.</option>
                            <option value="Providing training and education to the workers.">Providing training and education to the workers.</option>
                            <option value="Providing social status, subsistence, and stability to the workers.">Providing social status, subsistence, and stability to the workers.</option>
                            <option value="Providing the workers with new experiences, norms and behaviours">Providing the workers with new experiences, norms and behaviours</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="the_kenya_is">The most commonly used licit substance in Kenya is:</label>
                        <select name="the_kenya_is" id="the_kenya_is">
                        <option value="">Select one</option>
                            <option value="Alcohol">Alcohol</option>
                            <option value="Tobacco">Tobacco</option>
                            <option value="Miraa">Miraa</option>
                            <option value="Cannabis">Cannabis</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="assistance_program">What is Employee Assistance Program?</label>
                        <select name="assistance_program" id="assistance_program">
                        <option value="">Select one</option>
                            <option value="A program for identifying people with substance use problems">A program for identifying people with substance use problems</option>
                            <option value="A workplace program that offers confidential assessments, counseling, referral and follow up services for employees experiencing work related problems">A workplace program that offers confidential assessments, counseling, referral and follow up services for employees experiencing work related problems</option>
                            <option value="A program that demonstrates employer support for employees health and safety especially in addiction related issues">A program that demonstrates employer support for employees health and safety especially in addiction related issues</option>
                            <option value="Program that helps employees cope with workplace stressors such as addiction">Program that helps employees cope with workplace stressors such as addiction</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="underutilized_by_employees">Why is Employee Assistance Program often underutilized by employees?</label>
                        <select name="underutilized_by_employees" id="underutilized_by_employees">
                        <option value="">Select one</option>
                            <option value="The services are not easy to access">The services are not easy to access</option>
                            <option value="It is costly">It is costly</option>
                            <option value="Employees often do not know it exists">Employees often do not know it exists</option>
                            <option value="Disciplinary actions are linked to not using EAP services">Disciplinary actions are linked to not using EAP services</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="safety_issue_because">It is important to address substance use as a health and safety issue because:</label>
                        <select name="safety_issue_because" id="safety_issue_because">
                        <option value="">Select one</option>
                            <option value="Many substances are illegal and there could be legal issues related to use">Many substances are illegal and there could be legal issues related to use</option>
                            <option value="The organizations have social responsibility and duty to care for all its employees/workers">The organizations have social responsibility and duty to care for all its employees/workers</option>
                            <option value="Substance use prevention is for all staff">Substance use prevention is for all staff</option>
                            <option value="To help reduce use and de-stigmatize substance use prevention">To help reduce use and de-stigmatize substance use prevention</option>
                        </select>
                    </div>
                </div>
                
                <div class="submit-container">
                    <button type="submit">Submit</button>
                </div>
            </form>
        </div>
        
        <footer>
            <p>Workplace Prevention Interventions Assessment &copy; <?php echo date('Y'); ?></p>
        </footer>
    </div>
</body>
</html>
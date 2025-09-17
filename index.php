<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Initialize variables
$success_message = "";
$error_message = "";

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    
    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format";
    } else {
        // DHIS2 connection details
        $url = "https://monitoring.jocsoft.net/dhis/api/trackedEntityInstances";
        $username = "admin";
        $password = "Jocsoft@2025!";
        
        // Get current date for enrollment
        $current_date = date("Y-m-d");
        
        // Map answers to DHIS2 data elements (replace with your actual IDs)
        $answer_mapping = [
            'question2' => 'Bky63h2AUxp',
            'question3' => 'Cky73h3BUxp',
            'question4' => 'Dky84h4CUxp',
            'question5' => 'Eky95h5DUxp',
            'question6' => 'Fky06h6EUxp',
            'question7' => 'Gky17h7FUxp',
            'question8' => 'Hky28h8GUxp',
            'question9' => 'Iky39h9HUxp',
            'question10' => 'Jky40i0IXp',
            'question11' => 'Kky51i1JXp'
        ];
        
        // Build attributes array for all questions
        $attributes = [];
        foreach ($_POST as $key => $value) {
            if (strpos($key, 'question') === 0 && isset($answer_mapping[$key])) {
                $attributes[] = [
                    "attribute" => $answer_mapping[$key],
                    "value" => $value
                ];
            }
        }
        
        // Add email as an attribute
        $attributes[] = [
            "attribute" => "Zj8VZzqB3wK", // Example attribute ID for email
            "value" => $email
        ];
        
        // Build payload for Tracked Entity Instance
        $data = [
            "trackedEntityType" => "nEenWmSyUEp", // Replace with your tracked entity type
            "orgUnit" => "FdXc2bAfqzd", // Replace with your org unit
            "attributes" => $attributes,
            "enrollments" => [
                [
                    "orgUnit" => "FdXc2bAfqzd", // Replace with your org unit
                    "program" => "eBAyeGv0exc", // Replace with your program ID
                    "enrollmentDate" => $current_date,
                    "incidentDate" => $current_date
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
        $curl_error = curl_error($ch);
        curl_close($ch);
        
        // Process response
        if ($curl_error) {
            $error_message = "cURL Error: " . $curl_error;
        } elseif ($httpcode == 200 || $httpcode == 201) {
            $result = json_decode($response, true);
            if (isset($result['response']['importSummaries'][0]['status']) && 
                $result['response']['importSummaries'][0]['status'] == 'SUCCESS') {
                $success_message = "✅ Data saved successfully to DHIS2!";
            } else {
                $error_message = "⚠️ Request sent, but there may be an issue. Response: " . htmlspecialchars($response);
            }
        } else {
            $error_message = "❌ Failed to save data. HTTP Code: $httpcode. Response: " . htmlspecialchars($response);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workplace Based Prevention Interventions - Post Test</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.6;
            padding: 20px;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        header {
            background: linear-gradient(135deg, #2c3e50, #4a6491);
            color: white;
            padding: 25px;
            text-align: center;
        }
        
        h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }
        
        .description {
            font-size: 16px;
            margin-bottom: 10px;
            opacity: 0.9;
        }
        
        .required {
            color: #ff6b6b;
        }
        
        .form-container {
            padding: 30px;
        }
        
        .form-group {
            margin-bottom: 30px;
            padding-bottom: 25px;
            border-bottom: 1px solid #eaeaea;
        }
        
        .form-group:last-child {
            border-bottom: none;
        }
        
        label {
            display: block;
            font-weight: 600;
            margin-bottom: 12px;
            font-size: 16px;
            color: #2c3e50;
        }
        
        input[type="email"] {
            width: 100%;
            padding: 14px;
            border: 2px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        input[type="email"]:focus {
            border-color: #4a6491;
            outline: none;
            box-shadow: 0 0 0 3px rgba(74, 100, 145, 0.2);
        }
        
        .options-container {
            display: flex;
            flex-direction: column;
            gap: 14px;
            margin-top: 12px;
        }
        
        .option {
            display: flex;
            align-items: flex-start;
            padding: 12px;
            border-radius: 6px;
            transition: background-color 0.2s;
        }
        
        .option:hover {
            background-color: #f8f9fa;
        }
        
        .option input {
            margin-top: 3px;
            margin-right: 12px;
            accent-color: #4a6491;
        }
        
        .option label {
            font-weight: normal;
            margin-bottom: 0;
            cursor: pointer;
        }
        
        button {
            background: linear-gradient(135deg, #2c3e50, #4a6491);
            color: white;
            border: none;
            padding: 16px 32px;
            font-size: 17px;
            border-radius: 6px;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            display: block;
            margin: 30px auto 10px;
            width: 100%;
            max-width: 300px;
            font-weight: 600;
        }
        
        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        button:active {
            transform: translateY(0);
        }
        
        .message {
            padding: 16px;
            margin: 20px 0;
            border-radius: 6px;
            font-weight: 500;
            text-align: center;
        }
        
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .footer {
            text-align: center;
            padding: 20px;
            color: #6c757d;
            font-size: 14px;
            border-top: 1px solid #eaeaea;
            background-color: #f8f9fa;
        }
        
        @media (max-width: 600px) {
            .container {
                border-radius: 0;
            }
            
            .form-container {
                padding: 20px;
            }
            
            header {
                padding: 20px 15px;
            }
            
            h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>POST TEST: WORKPLACE BASED PREVENTION INTERVENTIONS</h1>
            <p class="description">Please complete all questions. <span class="required">*</span> indicates required questions.</p>
        </header>
        
        <div class="form-container">
            <?php if (!empty($success_message)): ?>
                <div class="message success"><?php echo $success_message; ?></div>
            <?php endif; ?>
            
            <?php if (!empty($error_message)): ?>
                <div class="message error"><?php echo $error_message; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="email">1. Email <span class="required">*</span></label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="question2">2. The most widely used illicit substance in the world is <span class="required">*</span></label>
                    <div class="options-container">
                        <div class="option">
                            <input type="radio" id="q2_option1" name="question2" value="Cannabis" required>
                            <label for="q2_option1">Cannabis</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="q2_option2" name="question2" value="Tobacco">
                            <label for="q2_option2">Tobacco</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="q2_option3" name="question2" value="Opioids">
                            <label for="q2_option3">Opioids</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="q2_option4" name="question2" value="Alcohol">
                            <label for="q2_option4">Alcohol</label>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="question3">3. What is a Substance Use Prevention Policy? <span class="required">*</span></label>
                    <div class="options-container">
                        <div class="option">
                            <input type="radio" id="q3_option1" name="question3" value="A written document which specifies the need for substance prevention at work places." required>
                            <label for="q3_option1">A written document which specifies the need for substance prevention at work places.</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="q3_option2" name="question3" value="A written policy on how substance use violations should be dealt with at workplaces.">
                            <label for="q3_option2">A written policy on how substance use violations should be dealt with at workplaces.</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="q3_option3" name="question3" value="A written description of the workplace's position on the use of alcohol, illicit drugs and prescription drugs.">
                            <label for="q3_option3">A written description of the workplace's position on the use of alcohol, illicit drugs and prescription drugs.</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="q3_option4" name="question3" value="A written guideline for employers to ensure that no substance abuse takes place at the workplaces.">
                            <label for="q3_option4">A written guideline for employers to ensure that no substance abuse takes place at the workplaces.</label>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="question4">4. Alcohol or drug use is the result of: <span class="required">*</span></label>
                    <div class="options-container">
                        <div class="option">
                            <input type="radio" id="q4_option1" name="question4" value="Personality flaws." required>
                            <label for="q4_option1">Personality flaws.</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="q4_option2" name="question4" value="Inheritance.">
                            <label for="q4_option2">Inheritance.</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="q4_option3" name="question4" value="Interaction between personal characteristics and environmental influences.">
                            <label for="q4_option3">Interaction between personal characteristics and environmental influences.</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="q4_option4" name="question4" value="Mental problems.">
                            <label for="q4_option4">Mental problems.</label>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="question5">5. The strategies for workplace alcohol and drug use prevention and management policy should <span class="required">*</span></label>
                    <div class="options-container">
                        <div class="option">
                            <input type="radio" id="q5_option1" name="question5" value="Address employees only in groups of their various degrees of substance use." required>
                            <label for="q5_option1">Address employees only in groups of their various degrees of substance use.</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="q5_option2" name="question5" value="Intervention is basically for the users only.">
                            <label for="q5_option2">Intervention is basically for the users only.</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="q5_option3" name="question5" value="Be inclusive and address the entire prevention continuum.">
                            <label for="q5_option3">Be inclusive and address the entire prevention continuum.</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="q5_option4" name="question5" value="Be interactive.">
                            <label for="q5_option4">Be interactive.</label>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="question6">6. When disseminating the policy of a workplace, what component of the policy is important to explain to the workforce? <span class="required">*</span></label>
                    <div class="options-container">
                        <div class="option">
                            <input type="radio" id="q6_option1" name="question6" value="The general health and safety of all workers as well as the different components of the policy including the consequences for violating the policy." required>
                            <label for="q6_option1">The general health and safety of all workers as well as the different components of the policy including the consequences for violating the policy.</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="q6_option2" name="question6" value="How the company will benefit from the non-use of drugs and substances">
                            <label for="q6_option2">How the company will benefit from the non-use of drugs and substances</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="q6_option3" name="question6" value="The importance of using EAP services">
                            <label for="q6_option3">The importance of using EAP services</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="q6_option4" name="question6" value="Disciplinary measures to be taken against those who are intoxicated">
                            <label for="q6_option4">Disciplinary measures to be taken against those who are intoxicated</label>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="question7">7. The working population spends a significant amount of their time in their workplaces. So the workplace-based prevention interventions is important in <span class="required">*</span></label>
                    <div class="options-container">
                        <div class="option">
                            <input type="radio" id="q7_option1" name="question7" value="Providing evidence for a positive return-on-investment." required>
                            <label for="q7_option1">Providing evidence for a positive return-on-investment.</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="q7_option2" name="question7" value="Providing training and education to the workers.">
                            <label for="q7_option2">Providing training and education to the workers.</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="q7_option3" name="question7" value="Providing social status, subsistence, and stability to the workers.">
                            <label for="q7_option3">Providing social status, subsistence, and stability to the workers.</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="q7_option4" name="question7" value="Providing the workers with new experiences, norms and behaviours.">
                            <label for="q7_option4">Providing the workers with new experiences, norms and behaviours.</label>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="question8">8. The most commonly used licit substance in Kenya is <span class="required">*</span></label>
                    <div class="options-container">
                        <div class="option">
                            <input type="radio" id="q8_option1" name="question8" value="Alcohol" required>
                            <label for="q8_option1">Alcohol</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="q8_option2" name="question8" value="Tobacco">
                            <label for="q8_option2">Tobacco</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="q8_option3" name="question8" value="Miraa">
                            <label for="q8_option3">Miraa</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="q8_option4" name="question8" value="Cannabis">
                            <label for="q8_option4">Cannabis</label>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="question9">9. What is Employee Assistance Program? <span class="required">*</span></label>
                    <div class="options-container">
                        <div class="option">
                            <input type="radio" id="q9_option1" name="question9" value="A program for identifying people with substance use problems" required>
                            <label for="q9_option1">A program for identifying people with substance use problems</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="q9_option2" name="question9" value="A workplace program that offers confidential assessments, counseling, referral and follow up services for employees experiencing work related problems">
                            <label for="q9_option2">A workplace program that offers confidential assessments, counseling, referral and follow up services for employees experiencing work related problems</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="q9_option3" name="question9" value="A program that demonstrates employer support for employees health and safety especially in addiction related issues.">
                            <label for="q9_option3">A program that demonstrates employer support for employees health and safety especially in addiction related issues.</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="q9_option4" name="question9" value="Program that helps employees cope with workplace stressors such as addiction">
                            <label for="q9_option4">Program that helps employees cope with workplace stressors such as addiction</label>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="question10">10. Why is Employee Assistance Program often underutilized by employees? <span class="required">*</span></label>
                    <div class="options-container">
                        <div class="option">
                            <input type="radio" id="q10_option1" name="question10" value="The services are not easy to access" required>
                            <label for="q10_option1">The services are not easy to access</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="q10_option2" name="question10" value="It is costly">
                            <label for="q10_option2">It is costly</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="q10_option3" name="question10" value="Employees often do not know it exists">
                            <label for="q10_option3">Employees often do not know it exists</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="q10_option4" name="question10" value="Disciplinary actions are linked to not using EAP services">
                            <label for="q10_option4">Disciplinary actions are linked to not using EAP services</label>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="question11">11. It is important to address substance use as a health and safety issue because <span class="required">*</span></label>
                    <div class="options-container">
                        <div class="option">
                            <input type="radio" id="q11_option1" name="question11" value="Many substances are illegal and there could be legal issues related to use" required>
                            <label for="q11_option1">Many substances are illegal and there could be legal issues related to use</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="q11_option2" name="question11" value="The organizations have social responsibility and duty to care for all its employees/workers">
                            <label for="q11_option2">The organizations have social responsibility and duty to care for all its employees/workers</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="q11_option3" name="question11" value="Substance use prevention is for all staff">
                            <label for="q11_option3">Substance use prevention is for all staff</label>
                        </div>
                        <div class="option">
                            <input type="radio" id="q11_option4" name="question11" value="To help reduce use and de-stigmatize substance use prevention">
                            <label for="q11_option4">To help reduce use and de-stigmatize substance use prevention</label>
                        </div>
                    </div>
                </div>
                
                <button type="submit">Submit Responses</button>
            </form>
        </div>
        
        <div class="footer">
            <p>NACADA KENYA</p>
        </div>
    </div>
</body>
</html>
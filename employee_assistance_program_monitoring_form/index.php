<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$success_message = "";
$error_message = "";

// API credentials
$url = "https://monitoring.jocsoft.net/dhis/api/dataValueSets";
$username = "jack";
$password = "Jocsoft@2027!!";

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

function getQuarterOptions() {
    $current_year = date('Y');
    $options = [];
    
    // Generate options for current year and previous year
    for ($year = $current_year - 1; $year <= $current_year + 1; $year++) {
        for ($quarter = 1; $quarter <= 4; $quarter++) {
            $options[] = $year . "Q" . $quarter;
        }
    }
    
    return $options;
}

// Get current quarter for default selection
$current_quarter = getCurrentQuarter();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $value = $_POST['value'];
    $reporting_period = $_POST['reporting_period'];
    $other_data = $_POST['other_data'];
    $sensitization_on_available = $_POST['sensitization_on_available'];
    $how_many_employees_reached_input = isset($_POST['how_many_employees_reached']) ? trim($_POST['how_many_employees_reached']) : '';
    $other_specify = $_POST['other_specify'];
    $referred_for_counselling = $_POST['referred_for_counselling'];
    $treatment_and_rehabilitation = $_POST['treatment_and_rehabilitation'];
    $counselling_services = $_POST['counselling_services'];
    $went_for_treatmentv = $_POST['went_for_treatmentv'];
    $specify_more = $_POST['specify_more'];
    $after_care_services = $_POST['after_care_services'];
    $dependents = $_POST['dependents'];
    $challenges_one = $_POST['challenges_one'];
    $challenges_two = $_POST['challenges_two'];
    $challenges_three = $_POST['challenges_three'];
    $challenges_four = $_POST['challenges_four'];
    $challenges_five = $_POST['challenges_five'];
    $eapm_remarks = $_POST['eapm_remarks'];

    $health_center = isset($_POST['health_center']) ? "true" : "false";
    $services_providers = isset($_POST['services_providers']) ? "true" : "false";
    $in_house_and_external = isset($_POST['in_house_and_external']) ? "true" : "false";
    $decreasing_work_quality = isset($_POST['decreasing_work_quality']) ? "true" : "false";
    $lack_attention_focus = isset($_POST['lack_attention_focus']) ? "true" : "false";
    $poor_decision_making = isset($_POST['poor_decision_making']) ? "true" : "false";
    $poor_judgement = isset($_POST['poor_judgement']) ? "true" : "false";
    $unusual_carelessness = isset($_POST['unusual_carelessness']) ? "true" : "false";
    $unsteady_gait =  isset($_POST['unsteady_gait']) ? "true" : "false";
    $excessive_mood_swings = isset($_POST['excessive_mood_swings']) ? "true" : "false";
    $energetic_or_sedated = isset($_POST['energetic_or_sedated']) ? "true" : "false";
    $Repeated_lateness = isset($_POST['Repeated_lateness']) ? "true" : "false";
    $including_unexplained_absences = isset($_POST['including_unexplained_absences']) ? "true" : "false";
    $smell_alcohol_tobacco = isset($_POST['smell_alcohol_tobacco']) ? "true" : "false";
    $on_the_job_accident = isset($_POST['on_the_job_accident']) ? "true" : "false";
    $self_referral  = isset($_POST['self_referral']) ? "true" : "false";
    $informal_referral = isset($_POST['informal_referral']) ? "true" : "false"; 
    $formal_referral = isset($_POST['formal_referral']) ? "true" : "false";  
    $alcohol_and_drug = isset($_POST['alcohol_and_drug']) ? "true" : "false";
    $work_related_stress = isset($_POST['work_related_stress']) ? "true" : "false";
    $mental_health_issues = isset($_POST['mental_health_issues']) ? "true" : "false";
    $family_issues = isset($_POST['family_issues']) ? "true" : "false";
    $personal_challenges_difficulties = isset($_POST['personal_challenges_difficulties']) ? "true" : "false";
    $financial_or_legal = isset($_POST['financial_or_legal']) ? "true" : "false";
    $health_problems = isset($_POST['health_problems']) ? "true" : "false";
    $gender_females = isset($_POST['gender_females']) ? "true" : "false";
    $gender_males = isset($_POST['gender_males']) ? "true" : "false";
    $top_management = isset($_POST['top_management']) ? "true" : "false";
    $management_station_head = isset($_POST['management_station_head']) ? "true" : "false";
    $technical_staff = isset($_POST['technical_staff']) ? "true" : "false";
    $support_staff = isset($_POST['support_staff']) ? "true" : "false";
    $ages_from_10_18 = isset($_POST['ages_from_10_18']) ? "true" : "false";
    $ages_from_19_25 = isset($_POST['ages_from_19_25']) ? "true" : "false";
    $ages_from_26_35 = isset($_POST['ages_from_26_35']) ? "true" : "false";
    $ages_from_36_45 = isset($_POST['ages_from_36_45']) ? "true" : "false";

    // Server-side validation/defaulting for employees reached
    // If sensitization is "yes", value must be a non-negative integer; otherwise default to 0
    $shouldSubmit = true;
    if ($sensitization_on_available === 'yes') {
        if ($how_many_employees_reached_input === '' || !ctype_digit($how_many_employees_reached_input)) {
            $error_message = "Please enter a valid non-negative number for 'How many employees reached'.";
            $shouldSubmit = false;
        } else {
            $how_many_employees_reached = (int)$how_many_employees_reached_input;
        }
    } else {
        $how_many_employees_reached = 0;
    }

    $data = [
        "dataSet" => "hb6Y59T4YEc",
        "completeDate" => date("Y-m-d"),
        "period" => $reporting_period, // Use the selected reporting period
        "orgUnit" => "ORwhnDymBpM",
        "dataValues" => [
            [
                "dataElement" => "CirTnd6QQTO",
                "value" => $value
            ],
            [
                "dataElement" => "N11bNXXYl8E",
                "value" => $reporting_period
            ],
            [
                "dataElement" => "q3nIhzLobBY",
                "value" => $health_center
            ],
            [
                "dataElement" => "RuHhXGH0T4E",
                "value" => $services_providers
            ],
            [
                "dataElement" => "QPWXligjV7t",
                "value" => $in_house_and_external
            ],
            [
                "dataElement" => "NYHVR5HsxYS",
                "value" => $other_data
            ],
            [
                "dataElement" => "BUOEjGsMPQQ",
                "value" => $sensitization_on_available
            ],
            [
                "dataElement" => "toCflxtfBvP",
                "value" => $how_many_employees_reached
            ],

            [
                "dataElement" => "QIc1Oph1w9n",
                "value" => $decreasing_work_quality
            ],
            [
                "dataElement" => "S4WRkCE29Ix",
                "value" => $lack_attention_focus
            ],
            [
                "dataElement" => "NZORRYWuaWP",
                "value" => $poor_decision_making
            ],
            [
                "dataElement" => "TlatYboVO7T",
                "value" => $poor_judgement
            ],
            [
                "dataElement" => "KEs7EKi49M7",
                "value" => $unusual_carelessness
            ],
            [
                "dataElement" => "Pu6yfQjPmmq",
                "value" => $unsteady_gait
            ],
            [
                "dataElement" => "RpCwCDUHjQy",
                "value" => $excessive_mood_swings
            ],
            [
                "dataElement" => "wyvbLSxv3ro",
                "value" => $energetic_or_sedated
            ],
            [
                "dataElement" => "P3xNWTMTBJ1",
                "value" => $Repeated_lateness
            ],
            [
                "dataElement" => "UfDEWWGiAg5",
                "value" => $including_unexplained_absences
            ],
            [
                "dataElement" => "BSQr2TUD6bN",
                "value" => $smell_alcohol_tobacco
            ],
            [
                "dataElement" => "VhDte8t3OoQ",
                "value" => $on_the_job_accident
            ],
            [
                "dataElement" => "KEv6aPzdLqP",
                "value" => $other_specify
            ],
            [
                "dataElement" => "Bepzug2sU2R",
                "value" => $self_referral
            ],
            [
                "dataElement" => "W9j5fypHK6s",
                "value" => $informal_referral
            ],
            [
                "dataElement" => "qAXvRt2M4fg",
                "value" => $formal_referral
            ],
            [
                "dataElement" => "m5ToaNAzxoy",
                "value" => $referred_for_counselling
            ],
            [
                "dataElement" => "BU2cdfreNxj",
                "value" => $treatment_and_rehabilitation
            ],
            [
                "dataElement" => "Lbc6tSVjkAx",
                "value" => $counselling_services
            ],
            [
                "dataElement" => "oR2GjFKonjY",
                "value" => $went_for_treatmentv
            ],
            [
                "dataElement" => "rApZ4UUPOG3",
                "value" => $alcohol_and_drug
            ],
            [
                "dataElement" => "TsPdbPKGaJC",
                "value" => $work_related_stress
            ],
            [
                "dataElement" => "qb3HNF9uk5M",
                "value" => $mental_health_issues
            ],
            [
                "dataElement" => "M44nTuWGcts",
                "value" => $family_issues
            ],
            [
                "dataElement" => "MafafyOewXi",
                "value" => $personal_challenges_difficulties
            ],
            [
                "dataElement" => "gpGqWvOrT85",
                "value" => $financial_or_legal
            ],
            [
                "dataElement" => "bvuIsatD2dO",
                "value" => $health_problems
            ],
            [
                "dataElement" => "WJQJDBUb8aU",
                "value" => $specify_more
            ],
            [
                "dataElement" => "PDihlFkzhUY",
                "value" => $gender_females
            ],
            [
                "dataElement" => "AZxOGNS5C0C",
                "value" => $gender_males
            ],
            [
                "dataElement" => "kVNuASljKEc",
                "value" => $top_management
            ],
            [
                "dataElement" => "BHSdYbuTOYt",
                "value" => $management_station_head
            ],
            [
                "dataElement" => "YXXg3t5j2pC",
                "value" => $technical_staff
            ],
            [
                "dataElement" => "ryHsVnZU0iK",
                "value" => $support_staff
            ],
            [
                "dataElement" => "kgNIv5PXD6z",
                "value" => $ages_from_10_18
            ],
            [
                "dataElement" => "xNKVmk1ChPs",
                "value" => $ages_from_19_25
            ],
            [
                "dataElement" => "Sm32O0DJHAa",
                "value" => $ages_from_26_35
            ],
            [
                "dataElement" => "cxm10lpn3Rn",
                "value" => $ages_from_36_45
            ],
            [
                "dataElement" => "Zl0KHkoEiAh",
                "value" => $after_care_services
            ],
            [
                "dataElement" => "npfo3bB4R7x",
                "value" => $dependents
            ],
            [
                "dataElement" => "VA3Vdl97Fjr",
                "value" => $challenges_one
            ],
            [
                "dataElement" => "tKld0kKqU0I",
                "value" => $challenges_two
            ],
            [
                "dataElement" => "SQ0SMN8X01A",
                "value" => $challenges_three
            ],
            [
                "dataElement" => "oklba7MCP9S",
                "value" => $challenges_four
            ],
            [
                "dataElement" => "TEuZ9PaZm8r",
                "value" => $challenges_five
            ],
            [
                "dataElement" => "Lw4smnkXFrq",
                "value" => $eapm_remarks
            ],
        ]
    ];

    if ($shouldSubmit) {
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
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EMPLOYEE ASSISTANCE PROGRAM MONITORING FORM</title>
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #2980b9;
            --success-color: #27ae60;
            --error-color: #e74c3c;
            --light-gray: #f5f7fa;
            --border-color: #ddd;
            --shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f0f2f5;
            color: #333;
            line-height: 1.6;
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: var(--shadow);
            text-align: center;
        }
        
        .header h1 {
            font-size: 2.2rem;
            margin-bottom: 10px;
        }
        
        .header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }
        
        .form-container {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: var(--shadow);
            margin-bottom: 30px;
        }
        
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 25px;
            font-weight: 100;
        }
        
        .alert-success {
            background-color: rgba(39, 174, 96, 0.1);
            color: var(--success-color);
            border: 1px solid var(--success-color);
        }
        
        .alert-error {
            background-color: rgba(231, 76, 60, 0.1);
            color: var(--error-color);
            border: 1px solid var(--error-color);
        }
        
        .form-section {
            margin-bottom: 40px;
            padding-bottom: 30px;
            border-bottom: 1px solid var(--border-color);
        }
        
        .form-section:last-of-type {
            border-bottom: none;
        }
        
        .section-title {
            color: var(--primary-color);
            font-size: 1.4rem;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--secondary-color);
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 100;
            color: var(--primary-color);
        }
        
        input[type="text"],
        input[type="number"],
        select,
        textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--border-color);
            border-radius: 5px;
            font-size: 1rem;
            transition: all 0.3s;
            font-family: inherit;
        }
        
        input[type="text"]:focus,
        input[type="number"]:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
        }
        
        textarea {
            resize: vertical;
            min-height: 120px;
            line-height: 1.5;
        }
        
        .checkbox-group {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            align-items: center;
            gap: 12px;
            margin-top: 10px;
        }
        
        .checkbox-item {
            display: flex;
            align-items: center;
        }
        
        .checkbox-item input {
            margin-right: 10px;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            align-items: center;
            gap: 20px;
        }
        
        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
            
            .checkbox-group {
                grid-template-columns: 1fr;
            }
        }
        
        .required::after {
            content: " *";
            color: var(--error-color);
        }
        
        .btn-submit {
            background: linear-gradient(135deg, var(--secondary-color), var(--accent-color));
            color: white;
            border: none;
            padding: 15px 30px;
            font-size: 1.1rem;
            font-weight: 100;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
            display: block;
            width: 100%;
            margin-top: 20px;
        }
        
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        
        .conditional-field {
            transition: all 0.3s ease;
            overflow: hidden;
        }
        
        .conditional-field.hidden {
            max-height: 0;
            opacity: 0;
            margin: 0;
            padding: 0;
        }
        
        .conditional-field.visible {
            max-height: 100px;
            opacity: 1;
            margin-top: 15px;
        }
        
        .form-note {
            font-size: 0.9rem;
            color: #666;
            margin-top: 5px;
            font-style: italic;
        }
        
        .remarks-section {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border: 2px solid var(--secondary-color);
            border-radius: 10px;
            padding: 25px;
            margin-top: 20px;
            position: relative;
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.1);
        }
        
        .remarks-section::before {
            content: "📝";
            position: absolute;
            top: -15px;
            left: 20px;
            background: white;
            padding: 5px 10px;
            border-radius: 50%;
            font-size: 1.2rem;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .remarks-section label {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 15px;
            display: block;
        }
        
        .remarks-section textarea {
            background: white;
            border: 2px solid var(--border-color);
            border-radius: 8px;
            padding: 15px;
            font-size: 1rem;
            line-height: 1.6;
            min-height: 150px;
            transition: all 0.3s ease;
        }
        
        .remarks-section textarea:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.15);
            background: #fafbff;
        }
        
        .remarks-section textarea::placeholder {
            color: #999;
            font-style: italic;
        }
    </style>
    <script>
        function toggleEmployeesReached() {
            var sensitizationSelect = document.getElementById('sensitization_on_available');
            var employeesReachedContainer = document.getElementById('how_many_employees_reached_container');
            
            if (sensitizationSelect.value === 'yes') {
                employeesReachedContainer.classList.remove('hidden');
                employeesReachedContainer.classList.add('visible');
                document.getElementById('how_many_employees_reached').setAttribute('required', 'required');
            } else {
                employeesReachedContainer.classList.remove('visible');
                employeesReachedContainer.classList.add('hidden');
                document.getElementById('how_many_employees_reached').removeAttribute('required');
                document.getElementById('how_many_employees_reached').value = '';
            }
        }
        
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            toggleEmployeesReached();
        });
    </script>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>EMPLOYEE ASSISTANCE PROGRAM MONITORING FORM</h1>
            <p>Complete all sections below to submit your EAP monitoring data</p>
        </div>
        
        <?php if ($success_message): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($success_message); ?>
            </div>
        <?php endif; ?>
        
        <?php if ($error_message): ?>
            <div class="alert alert-error">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="form-container">
            <div class="form-section">
                <h2 class="section-title">Basic Information</h2>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="value" class="required">Name of the Institution:</label>
                        <input type="text" name="value" id="value" required />
                    </div>

                    <div class="form-group">
                        <label for="reporting_period" class="required">Reporting quarter:</label>
                        <select name="reporting_period" id="reporting_period" required>
                            <option value="">Select Quarter</option>
                            <?php
                            $quarter_options = getQuarterOptions();
                            foreach ($quarter_options as $option) {
                                $selected = ($option === $current_quarter) ? 'selected' : '';
                                echo "<option value=\"$option\" $selected>$option</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="form-section">
                <h2 class="section-title">EAP Services Available</h2>
                
                <div class="checkbox-group">
                    <div class="checkbox-item">
                        <input type="checkbox" id="health_center" name="health_center" value="health_center">
                        <label for="health_center">In-house clinic/health center/EAP</label>
                    </div>
                    
                    <div class="checkbox-item">
                        <input type="checkbox" id="services_providers" name="services_providers" value="services_providers">
                        <label for="services_providers">Schedule of external services/providers</label>
                    </div>
                    
                    <div class="checkbox-item">
                        <input type="checkbox" id="in_house_and_external" name="in_house_and_external" value="in_house_and_external">
                        <label for="in_house_and_external">Hybrid (in-house and external)</label>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="other_data">Other (specify)</label>
                    <input type="text" id="other_data" name="other_data">
                </div>
            </div>
            
            <div class="form-section">
                <h2 class="section-title">Sensitization Information</h2>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="sensitization_on_available" class="required">Sensitization on available:</label>
                        <select name="sensitization_on_available" id="sensitization_on_available" required onchange="toggleEmployeesReached()">
                            <option value="">Select Option</option>
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                        </select>
                    </div>
                    
                    <div id="how_many_employees_reached_container" class="conditional-field">
                        <div class="form-group">
                            <label for="how_many_employees_reached" class="required">How many employees reached:</label>
                            <input type="number" min="0" step="1" name="how_many_employees_reached" id="how_many_employees_reached" />
                            <div class="form-note">Enter a non-negative whole number</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="form-section">
                <h2 class="section-title">Types of Problems Manifested/Identified</h2>
                
                <div class="checkbox-group">
                    <div class="checkbox-item">
                        <input type="checkbox" id="decreasing_work_quality" name="decreasing_work_quality" value="decreasing_work_quality">
                        <label for="decreasing_work_quality">Low productivity/declining performance/decreasing work quality</label>
                    </div>
                    
                    <div class="checkbox-item">
                        <input type="checkbox" id="lack_attention_focus" name="lack_attention_focus" value="lack_attention_focus">
                        <label for="lack_attention_focus">Lack of attention or focus</label>
                    </div>
                    
                    <div class="checkbox-item">
                        <input type="checkbox" id="poor_decision_making" name="poor_decision_making" value="poor_decision_making">
                        <label for="poor_decision_making">Poor decision making</label>
                    </div>
                    
                    <div class="checkbox-item">
                        <input type="checkbox" id="poor_judgement" name="poor_judgement" value="poor_judgement">
                        <label for="poor_judgement">Poor judgement</label>
                    </div>
                    
                    <div class="checkbox-item">
                        <input type="checkbox" id="unusual_carelessness" name="unusual_carelessness" value="unusual_carelessness">
                        <label for="unusual_carelessness">Unusual carelessness</label>
                    </div>
                    
                    <div class="checkbox-item">
                        <input type="checkbox" id="unsteady_gait" name="unsteady_gait" value="unsteady_gait">
                        <label for="unsteady_gait">Unsteady gait</label>
                    </div>
                    
                    <div class="checkbox-item">
                        <input type="checkbox" id="excessive_mood_swings" name="excessive_mood_swings" value="excessive_mood_swings">
                        <label for="excessive_mood_swings">Excessive mood swings</label>
                    </div>
                    
                    <div class="checkbox-item">
                        <input type="checkbox" id="energetic_or_sedated" name="energetic_or_sedated" value="energetic_or_sedated">
                        <label for="energetic_or_sedated">Appearance of being high, unusually energetic or sedated</label>
                    </div>
                    
                    <div class="checkbox-item">
                        <input type="checkbox" id="Repeated_lateness" name="Repeated_lateness" value="Repeated_lateness">
                        <label for="Repeated_lateness">Repeated lateness</label>
                    </div>
                    
                    <div class="checkbox-item">
                        <input type="checkbox" id="including_unexplained_absences" name="including_unexplained_absences" value="including_unexplained_absences">
                        <label for="including_unexplained_absences">Increased absenteeism, including unexplained absences</label>
                    </div>
                    
                    <div class="checkbox-item">
                        <input type="checkbox" id="smell_alcohol_tobacco" name="smell_alcohol_tobacco" value="smell_alcohol_tobacco">
                        <label for="smell_alcohol_tobacco">Smell of alcohol or tobacco</label>
                    </div>
                    
                    <div class="checkbox-item">
                        <input type="checkbox" id="on_the_job_accident" name="on_the_job_accident" value="on_the_job_accident">
                        <label for="on_the_job_accident">On the job accident</label>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="other_specify">Other (specify)</label>
                    <input type="text" id="other_specify" name="other_specify">
                </div>
            </div>
            
            <div class="form-section">
                <h2 class="section-title">Referral Information</h2>
                
                <div class="checkbox-group">
                    <div class="checkbox-item">
                        <input type="checkbox" id="self_referral" name="self_referral" value="self_referral">
                        <label for="self_referral">Self referral</label>
                    </div>
                    
                    <div class="checkbox-item">
                        <input type="checkbox" id="informal_referral" name="informal_referral" value="informal_referral">
                        <label for="informal_referral">Informal referral</label>
                    </div>
                    
                    <div class="checkbox-item">
                        <input type="checkbox" id="formal_referral" name="formal_referral" value="formal_referral">
                        <label for="formal_referral">Formal referral</label>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="referred_for_counselling">Number of staff/students referred for counselling</label>
                        <input type="text" id="referred_for_counselling" name="referred_for_counselling">
                    </div>
                    
                    <div class="form-group">
                        <label for="treatment_and_rehabilitation">Number of staff/students referred for drug treatment and rehabilitation</label>
                        <input type="text" id="treatment_and_rehabilitation" name="treatment_and_rehabilitation">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="counselling_services">Number of staff/students who utilized counselling services</label>
                        <input type="text" id="counselling_services" name="counselling_services">
                    </div>
                    
                    <div class="form-group">
                        <label for="went_for_treatmentv">Number of staff/students who went for treatment and rehabilitation</label>
                        <input type="number" id="went_for_treatmentv" name="went_for_treatmentv">
                    </div>
                </div>
            </div>
            
            <div class="form-section">
                <h2 class="section-title">Job Category of Staff</h2>
                
                <div class="checkbox-group">
                    <div class="checkbox-item">
                        <input type="checkbox" id="top_management" name="top_management" value="top_management">
                        <label for="top_management">Top management</label>
                    </div>
                    
                    <div class="checkbox-item">
                        <input type="checkbox" id="management_station_head" name="management_station_head" value="management_station_head">
                        <label for="management_station_head">Middle Management/Station Head</label>
                    </div>
                    
                    <div class="checkbox-item">
                        <input type="checkbox" id="technical_staff" name="technical_staff" value="technical_staff">
                        <label for="technical_staff">Technical Staff</label>
                    </div>
                    
                    <div class="checkbox-item">
                        <input type="checkbox" id="support_staff" name="support_staff" value="support_staff">
                        <label for="support_staff">Support Staff</label>
                    </div>
                </div>
            </div>
            
            <div class="form-section">
                <h2 class="section-title">Issues Addressed in EAP</h2>
                
                <div class="checkbox-group">
                    <div class="checkbox-item">
                        <input type="checkbox" id="alcohol_and_drug" name="alcohol_and_drug" value="alcohol_and_drug">
                        <label for="alcohol_and_drug">Alcohol and drug use</label>
                    </div>
                    
                    <div class="checkbox-item">
                        <input type="checkbox" id="work_related_stress" name="work_related_stress" value="work_related_stress">
                        <label for="work_related_stress">Work related stress</label>
                    </div>
                    
                    <div class="checkbox-item">
                        <input type="checkbox" id="mental_health_issues" name="mental_health_issues" value="mental_health_issues">
                        <label for="mental_health_issues">Depression or other mental health issues</label>
                    </div>
                    
                    <div class="checkbox-item">
                        <input type="checkbox" id="family_issues" name="family_issues" value="family_issues">
                        <label for="family_issues">Family issues</label>
                    </div>
                    
                    <div class="checkbox-item">
                        <input type="checkbox" id="personal_challenges_difficulties" name="personal_challenges_difficulties" value="personal_challenges_difficulties">
                        <label for="personal_challenges_difficulties">Personal challenges/difficulties</label>
                    </div>
                    
                    <div class="checkbox-item">
                        <input type="checkbox" id="financial_or_legal" name="financial_or_legal" value="financial_or_legal">
                        <label for="financial_or_legal">Financial or legal</label>
                    </div>
                    
                    <div class="checkbox-item">
                        <input type="checkbox" id="health_problems" name="health_problems" value="health_problems">
                        <label for="health_problems">Illness/health problems</label>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="specify_more">EAPM - Other (specify more)</label>
                    <input type="text" id="specify_more" name="specify_more">
                </div>
            </div>
            
            <div class="form-section">
                <h2 class="section-title">Gender Distribution</h2>
                
                <div class="checkbox-group">
                    <div class="checkbox-item">
                        <input type="checkbox" id="gender_females" name="gender_females" value="gender_females">
                        <label for="gender_females">Gender females</label>
                    </div>
                    
                    <div class="checkbox-item">
                        <input type="checkbox" id="gender_males" name="gender_males" value="gender_males">
                        <label for="gender_males">Gender males</label>
                    </div>
                </div>
            </div>
            
            <div class="form-section">
                <h2 class="section-title">Age Distribution</h2>
                
                <div class="checkbox-group">
                    <div class="checkbox-item">
                        <input type="checkbox" id="ages_from_10_18" name="ages_from_10_18" value="ages_from_10_18">
                        <label for="ages_from_10_18">Ages from 10 to 18 years</label>
                    </div>
                    
                    <div class="checkbox-item">
                        <input type="checkbox" id="ages_from_19_25" name="ages_from_19_25" value="ages_from_19_25">
                        <label for="ages_from_19_25">Ages from 19 to 25 years</label>
                    </div>
                    
                    <div class="checkbox-item">
                        <input type="checkbox" id="ages_from_26_35" name="ages_from_26_35" value="ages_from_26_35">
                        <label for="ages_from_26_35">Ages from 26 to 35 years</label>
                    </div>
                    
                    <div class="checkbox-item">
                        <input type="checkbox" id="ages_from_36_45" name="ages_from_36_45" value="ages_from_36_45">
                        <label for="ages_from_36_45">Ages from 36 to 45 years</label>
                    </div>
                </div>
            </div>
            
            <div class="form-section">
                <h2 class="section-title">After-Care Services</h2>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="after_care_services">Number of staff vs. dependents receiving after-care services</label>
                        <input type="text" id="after_care_services" name="after_care_services">
                    </div>
                    
                    <div class="form-group">
                        <label for="dependents">Staff vs. dependents</label>
                        <input type="text" id="dependents" name="dependents">
                    </div>
                </div>
            </div>
            
            <div class="form-section">
                <h2 class="section-title">Challenges</h2>
                
                <div class="form-group">
                    <label for="challenges_one">EAPM - Challenges one</label>
                    <input type="text" id="challenges_one" name="challenges_one">
                </div>
                
                <div class="form-group">
                    <label for="challenges_two">EAPM - Challenges two</label>
                    <input type="text" id="challenges_two" name="challenges_two">
                </div>
                
                <div class="form-group">
                    <label for="challenges_three">EAPM - Challenges three</label>
                    <input type="text" id="challenges_three" name="challenges_three">
                </div>
                
                <div class="form-group">
                    <label for="challenges_four">EAPM - Challenges four</label>
                    <input type="text" id="challenges_four" name="challenges_four">
                </div>
                
                <div class="form-group">
                    <label for="challenges_five">EAPM - Challenges five</label>
                    <input type="text" id="challenges_five" name="challenges_five">
                </div>

                <div class="remarks-section">
                    <label for="eapm_remarks">EMPLOYEE ASSISTANCE PROGRAM MONITORING FORM REMARKs</label>
                    <textarea rows="10" name="eapm_remarks" id="eapm_remarks" placeholder="Please provide any additional remarks, observations, or comments about the Employee Assistance Program monitoring activities..."></textarea>
                </div>
            </div>
            
            <button type="submit" class="btn-submit">Submit</button>
        </form>
    </div>
</body>
</html>
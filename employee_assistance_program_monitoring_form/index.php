
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
    $went_for_treatmentv = $_POST['went_for_treatmentv']



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
        form > div{
            display: flex;
            flex-direction: column;
            max-width: 400px;
        }
        label {
            margin-bottom: 5px;
        }
        #how_many_employees_reached_container {
            display: none;
            margin-top: 10px;
        }
    </style>
    <script>
        function toggleEmployeesReached() {
            var sensitizationSelect = document.getElementById('sensitization_on_available');
            var employeesReachedContainer = document.getElementById('how_many_employees_reached_container');
            var employeesReachedInput = document.getElementById('how_many_employees_reached');

            if (sensitizationSelect.value === 'yes') {
                employeesReachedContainer.style.display = 'block';
                employeesReachedInput.setAttribute('required', 'required');
            } else {
                employeesReachedContainer.style.display = 'none';
                employeesReachedInput.removeAttribute('required');
                employeesReachedInput.value = '';
            }
        }
    </script>
</head>
<body>
    <?php if ($success_message): ?>
        <div style="color: green; padding: 10px; margin: 10px 0; border: 1px solid green;">
            <?php echo htmlspecialchars($success_message); ?>
        </div>
    <?php endif; ?>
    
    <?php if ($error_message): ?>
        <div style="color: red; padding: 10px; margin: 10px 0; border: 1px solid red;">
            <?php echo htmlspecialchars($error_message); ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div>
            <label for="value">Name of the Institution:</label>
            <input type="text" name="value" id="value" required />
        </div>

        <div>
            <label for="reporting_period">Reporting quarter:</label>
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
        
        <div>
            <h2>EAP services available</h2>

            <input type="checkbox" id="health_center" name="health_center" value="health_center">
            <label for="health_center">In-house clinic/health center/EAP</label><br>

            <input type="checkbox" id="services_providers" name="services_providers" value="services_providers">
            <label for="services_providers">Schedule of external services/providers</label><br>

            <input type="checkbox" id="in_house_and_external" name="in_house_and_external" value="in_house_and_external">
            <label for="in_house_and_external">Hybrid (in-house and external)</label><br>

            <label for="other_data">Other (specify)</label><br>
            <input type="text" id="other_data" name="other_data">
        </div>

        <div>
            <label for="sensitization_on_available">Sensitization on available:</label>
            <select name="sensitization_on_available" id="sensitization_on_available" required onchange="toggleEmployeesReached()">
                <option value="">Select Option</option>
                <option value="yes">Yes</option>
                <option value="no">No</option>
            </select>
        </div>

        <div id="how_many_employees_reached_container">
            <label for="how_many_employees_reached">How many employees reached:</label>
            <input type="number" min="0" step="1" name="how_many_employees_reached" id="how_many_employees_reached" />
        </div>

        <div>
            <h4>Types of problems manifested/identified (Tick all that apply)</h4>
        <input type="checkbox" id="decreasing_work_quality" name="decreasing_work_quality" value="decreasing_work_quality">
        <label for="decreasing_work_quality">Low productivity/declining performance/decreasing work quality</label><br>

        <input type="checkbox" id="lack_attention_focus" name="lack_attention_focus" value="lack_attention_focus">
        <label for="lack_attention_focus">Lack of attention or focus</label><br>

        <input type="checkbox" id="poor_decision_making" name="poor_decision_making" value="poor_decision_making">
        <label for="poor_decision_making">Poor decision making</label><br>

        <input type="checkbox" id="poor_judgement" name="poor_judgement" value="poor_judgement">
        <label for="poor_judgement">Poor judgement</label><br>

        <input type="checkbox" id="unusual_carelessness" name="unusual_carelessness" value="unusual_carelessness">
        <label for="unusual_carelessness">Unusual carelessness</label><br>

        <input type="checkbox" id="unsteady_gait" name="unsteady_gait" value="unsteady_gait">
        <label for="unsteady_gait">Unsteady gait</label><br>

        <input type="checkbox" id="excessive_mood_swings" name="excessive_mood_swings" value="excessive_mood_swings">
        <label for="excessive_mood_swings">Excessive mood swings</label><br>

        <input type="checkbox" id="energetic_or_sedated" name="energetic_or_sedated" value="energetic_or_sedated">
        <label for="energetic_or_sedated">Appearance of being high, unusually energetic or sedated</label><br>

        <input type="checkbox" id="Repeated_lateness" name="Repeated_lateness" value="Repeated_lateness">
        <label for="Repeated_lateness">Repeated lateness</label><br>

        <input type="checkbox" id="including_unexplained_absences" name="including_unexplained_absences" value="including_unexplained_absences">
        <label for="including_unexplained_absences">Increased absenteeism, including unexplained absences</label><br>

        <input type="checkbox" id="smell_alcohol_tobacco" name="smell_alcohol_tobacco" value="smell_alcohol_tobacco">
        <label for="smell_alcohol_tobacco">Smell of alcohol or tobacco</label><br>
        
        <input type="checkbox" id="on_the_job_accident" name="on_the_job_accident" value="on_the_job_accident">
        <label for="on_the_job_accident">On the job accident</label><br>

        <input type="text" id="other_specify" name="other_specify">
        <label for="other_specify">Other (specify)</label><br>

        <input type="checkbox" id="self_referral" name="self_referral" value="self_referral">
        <label for="self_referral">Self referral</label><br>

        <input type="checkbox" id="informal_referral" name="informal_referral" value="informal_referral">
        <label for="informal_referral">Informal referral</label><br>

        <input type="checkbox" id="formal_referral" name="formal_referral" value="formal_referral">
        <label for="formal_referral">Formal referral</label><br>

        <input type="text" id="referred_for_counselling" name="referred_for_counselling">
        <label for="referred_for_counselling">Number of staff/students referred for counselling</label><br>
        </div>

        <div>
            <h4>Job category of staff who went for counselling or treatment and rehabilitation (Tick all that apply) </h4>
        <input type="text" id="treatment_and_rehabilitation" name="treatment_and_rehabilitation">
        <label for="treatment_and_rehabilitation">Number of staff/students referred for drug treatment and rehabilitation</label><br>

        <input type="text" id="counselling_services" name="counselling_services">
        <label for="counselling_services">Number of staff/students who utilized counselling services</label><br>

        <input type="text" id="went_for_treatmentv" name="went_for_treatmentv">
        <label for="went_for_treatmentv">Number of staff/students who went for treatment and rehabilitation</label><br>

        </div>

        <div>
            <!-- tchasinga.... -->
             <h4>Issues addressed in EAP (Tick all that apply)</h4>

             <input type="checkbox" id="alcohol_and_drug" name="alcohol_and_drug" value="alcohol_and_drug">
        <label for="alcohol_and_drug">Alcohol and drug use</label><br>

        <input type="checkbox" id="work_related_stress" name="work_related_stress" value="work_related_stress">
        <label for="work_related_stress">Work related stress</label><br>

        <input type="checkbox" id="mental_health_issues" name="mental_health_issues" value="mental_health_issues">
        <label for="mental_health_issues">Depression or other mental health issues</label><br>

        <input type="checkbox" id="family_issues" name="family_issues" value="family_issues">
        <label for="family_issues">Family issues</label><br>

        <input type="checkbox" id="personal_challenges_difficulties" name="personal_challenges_difficulties" value="personal_challenges_difficulties">
        <label for="personal_challenges_difficulties">Personal challenges/difficulties</label><br>

        <input type="checkbox" id="financial_or_legal" name="financial_or_legal" value="financial_or_legal">
        <label for="financial_or_legal">Financial or legal</label><br>

        <input type="checkbox" id="health_problems" name="health_problems" value="health_problems">
        <label for="health_problems">Illness/health problems</label><br>
        </div>

        <button type="submit">Submit</button>
    </form>
</body>
</html>
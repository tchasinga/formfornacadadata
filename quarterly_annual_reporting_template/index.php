<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$success_message = "";
$error_message = "";

// API credentials
$url = "https://monitoring.jocsoft.net/dhis/api/dataValueSets";
$fileUrl = "https://monitoring.jocsoft.net/dhis/api/fileResources";
$username = "jack";
$password = "Jocsoft@2027!!";

// Function to get current quarter (DHIS2 standard quarters)
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

// Function to generate quarter options for dropdown
function generateQuarterOptions() {
    $currentYear = date('Y');
    $options = [];
    
    // Generate quarters for current year and next 2 years
    for ($year = $currentYear; $year <= $currentYear + 2; $year++) {
        for ($quarter = 1; $quarter <= 4; $quarter++) {
            $quarterValue = $year . "Q" . $quarter;
            $quarterLabel = $year . " Q" . $quarter;
            $options[] = [
                'value' => $quarterValue,
                'label' => $quarterLabel
            ];
        }
    }
    
    return $options;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $activity = isset($_POST['activity']) ? (int) $_POST['activity'] : 1;
    if ($activity < 1 || $activity > 5) { $activity = 1; }

    // Map selected activity to categoryOptionCombo
    $activityToCoc = [
        1 => "oyPYrse9dkR",    // Activity 1 (existing default)
        2 => "tir6ZtWOO74",
        3 => "WN6T534QeaK",
        4 => "HQQdVF5rm97",
        5 => "FdMERsIppbs",
    ];
    $selectedCategoryOptionCombo = $activityToCoc[$activity];
    $value = $_POST['value'];
    $prevention_activities = $_POST['prevention_activities'];
    $reporting_period = $_POST['reporting_period'];
    $quarter_achievement = $_POST['quarter_achievement'];
    $quarter_in = $_POST['quarter_in'];
    $for_the_quarter = $_POST['for_the_quarter'];
    $variance_for_the_quarter = $_POST['variance_for_the_quarter'];
    $achievement_to_date = $_POST['achievement_to_date'];
    $annual_activity_target = $_POST['annual_activity_target'];
    $from_annual_target = $_POST['from_annual_target'];
    $challenges_or_learnings = $_POST['challenges_or_learnings'];
    $quarterly_totals = $_POST['quarterly_totals'];
    $name_of_reporter = $_POST['name_of_reporter'];
    $designation = $_POST['designation'];
    $Tel_No  = $_POST['Tel_No'];
    $prqt_email = $_POST['prqt_email'];
    $prq_date = $_POST['prq_date'];
   
    // Use user-provided period if present, otherwise default to current quarter
    $userPeriod = isset($_POST['period']) ? trim($_POST['period']) : '';
    $currentPeriod = $userPeriod !== '' ? $userPeriod : getCurrentQuarter();

    $data = [
        "dataSet" => "n65Xeqc6HN1",
        "completeDate" => date("Y-m-d"),
        "period" => $currentPeriod,
        "orgUnit" => "ORwhnDymBpM",
        "dataValues" => [
            [
                "dataElement" => "Ar1Rlf7Yfkq",
                "value" => $value
            ],
            [
                "dataElement" => "lmOU0RK4aYg",
                "value" => $prevention_activities
            ],
            [
                "dataElement" => "pmHQN9jfxgx",
                "categoryOptionCombo" => $selectedCategoryOptionCombo,
                "value" => $reporting_period
            ],
            [
                "dataElement" => "TjgG2724voz",
                "categoryOptionCombo" => $selectedCategoryOptionCombo,
                "value" => $quarter_achievement
            ],
            [
                "dataElement" => "yhLaGM4bbOl",
                "categoryOptionCombo" => $selectedCategoryOptionCombo,
                "value" => $quarter_in
            ],
            [
                "dataElement" => "FVzbO1DejMs",
                "categoryOptionCombo" => $selectedCategoryOptionCombo,
                "value" => $for_the_quarter
            ],
            [
                "dataElement" => "kD8FHAdwAVb",
                "categoryOptionCombo" => $selectedCategoryOptionCombo,
                "value" => $variance_for_the_quarter
            ],
            [
                "dataElement" => "WknTsKDlwEr",
                "categoryOptionCombo" => $selectedCategoryOptionCombo,
                "value" => $achievement_to_date
            ],
            [
                "dataElement" => "hKwO0xn5vrK",
                "categoryOptionCombo" => $selectedCategoryOptionCombo,
                "value" => $annual_activity_target
            ],
            [
                "dataElement" => "wgbi2BxEXDH",
                "categoryOptionCombo" => $selectedCategoryOptionCombo,
                "value" => $from_annual_target
            ],
            [
                "dataElement" => "Z4V1wbxk3MF",
                "categoryOptionCombo" => $selectedCategoryOptionCombo,
                "value" => $challenges_or_learnings
            ],
            [
                "dataElement" => "l3GIGnzoA6c",
                "categoryOptionCombo" => $selectedCategoryOptionCombo,
                "value" => $quarterly_totals
            ],
            [
                "dataElement" => "WZNGURW8bVg",
                "value" => $name_of_reporter
            ],
            [
                "dataElement" => "ONIqRkRuK9a",
                "value" => $designation
            ],
            [
                "dataElement" => "tBdllAaimjr",
                "value" => $Tel_No
            ],
            [
                "dataElement" => "dzUAl9ZpDRB",
                "value" => $prqt_email
            ],
            [
                "dataElement" => "wgvylEsNXEl",
                "value" => $prq_date
            ],
        ]
    ];

    // Handle file upload
    $fileResourceId = null;
    if (isset($_FILES['document']) && $_FILES['document']['error'] === UPLOAD_ERR_OK) {
        $fileName = $_FILES['document']['name'];
        $fileTmpPath = $_FILES['document']['tmp_name'];
        $fileSize = $_FILES['document']['size'];
        $fileType = $_FILES['document']['type'];
        
        // Read file content
        $fileContent = file_get_contents($fileTmpPath);
        $base64File = base64_encode($fileContent);
        
        // Prepare file resource data
        $fileData = [
            "name" => $fileName,
            "content" => $base64File,
            "contentLength" => $fileSize,
            "contentType" => $fileType
        ];
        
        $filePayload = json_encode($fileData);
        
        $fileCh = curl_init($fileUrl);
        curl_setopt($fileCh, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($fileCh, CURLOPT_POST, true);
        curl_setopt($fileCh, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($fileCh, CURLOPT_USERPWD, "$username:$password");
        curl_setopt($fileCh, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
        curl_setopt($fileCh, CURLOPT_POSTFIELDS, $filePayload);
        
        $fileResponse = curl_exec($fileCh);
        $fileHttpCode = curl_getinfo($fileCh, CURLINFO_HTTP_CODE);
        
        if ($fileHttpCode == 200 || $fileHttpCode == 201) {
            $fileResponseData = json_decode($fileResponse, true);
            if (isset($fileResponseData['response']['fileResource']['id'])) {
                $fileResourceId = $fileResponseData['response']['fileResource']['id'];
                
                // Add file resource to data values
                $data['dataValues'][] = [
                    "dataElement" => "gE1XvtJR7Rv",
                    "value" => $fileResourceId
                ];
            }
        }
        curl_close($fileCh);
    }

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
            $success_message = "Data submitted successfully for period $currentPeriod!";
            if ($fileResourceId) {
                $success_message .= " Document uploaded successfully!";
            }
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
    <title>QUARTERLY/ANNUAL REPORTING TEMPLATE</title>
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #2980b9;
            --success-color: #27ae60;
            --error-color: #e74c3c;
            --light-gray: #f5f7fa;
            --border-color: #ddd;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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
            padding: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        header {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: var(--shadow);
        }
        
        h1 {
            color: var(--primary-color);
            margin-bottom: 10px;
        }
        
        .subtitle {
            color: #666;
            font-size: 1.1rem;
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }
        
        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
        }
        
        .card {
            background: white;
            border-radius: 8px;
            padding: 25px;
            box-shadow: var(--shadow);
            height: fit-content;
        }
        
        .card-header {
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 15px;
            margin-bottom: 20px;
            color: var(--primary-color);
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 100;
            color: #444;
        }
        
        input[type="text"],
        input[type="email"],
        input[type="date"],
        input[type="file"],
        select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            font-size: 16px;
            transition: border 0.3s;
        }
        
        input:focus,
        select:focus {
            outline: none;
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
        }
        
        .btn-submit {
            background-color: var(--secondary-color);
            color: white;
            border: none;
            padding: 14px 20px;
            font-size: 16px;
            font-weight: 100;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s;
            margin-top: 10px;
        }
        
        .btn-submit:hover {
            background-color: var(--accent-color);
        }
        
        .message {
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
            font-weight: 100;
        }

        .document-info{
            font-size : 10px;
            color : #666;
            padding: 10px;
        }
        
        .success {
            background-color: rgba(39, 174, 96, 0.1);
            color: var(--success-color);
            border: 1px solid rgba(39, 174, 96, 0.3);
        }
        
        .error {
            background-color: rgba(231, 76, 60, 0.1);
            color: var(--error-color);
            border: 1px solid rgba(231, 76, 60, 0.3);
        }
        
        .period-info {
            text-align: center;
            margin-top: 20px;
            padding: 15px;
            background-color: var(--light-gray);
            border-radius: 4px;
            font-weight: 100;
        }
        
        .certification-section {
            background-color: rgba(52, 152, 219, 0.05);
            padding: 20px;
            border-radius: 6px;
            margin: 20px 0;
            border-left: 4px solid var(--secondary-color);
        }
        
        .certification-title {
            color: var(--primary-color);
            margin-bottom: 15px;
            font-weight: 100;
        }

        /* Activity accordion */
        .activity-tabs {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin: 10px 0 15px 0;
        }
        .activity-tab {
            background: var(--light-gray);
            color: var(--primary-color);
            border: 1px solid var(--border-color);
            border-radius: 4px;
            padding: 8px 12px;
            cursor: pointer;
            user-select: none;
        }
        .activity-tab.active {
            background: var(--secondary-color);
            color: #fff;
            border-color: var(--secondary-color);
        }
        .activity-panel { display: none; }
        .activity-panel.active { display: block; }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>QUARTERLY/ANNUAL REPORTING TEMPLATE</h1>
            <p class="subtitle">Complete all sections accurately and submit your report</p>
        </header>
        
        <?php if (!empty($success_message)): ?>
            <div class="message success"><?php echo htmlspecialchars($success_message); ?></div>
        <?php endif; ?>
        
        <?php if (!empty($error_message)): ?>
            <div class="message error"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>
        
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="activity" id="activity" value="1" />
            <div class="form-grid">
                <div class="card">
                    <h2 class="card-header">Activity Details</h2>
                    
                    <div class="form-group">
                        <label for="period">Reporting Period</label>
                        <select name="period" id="period" required>
                            <?php 
                            $quarterOptions = generateQuarterOptions();
                            $currentQuarter = getCurrentQuarter();
                            foreach ($quarterOptions as $option): 
                                $selected = ($option['value'] === $currentQuarter) ? 'selected' : '';
                            ?>
                                <option value="<?php echo htmlspecialchars($option['value']); ?>" <?php echo $selected; ?>>
                                    <?php echo htmlspecialchars($option['label']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="value">ADA-Name of the Institution</label>
                        <input type="text" name="value" id="value" required />
                    </div>
                    
                    <div class="form-group">
                        <label for="prevention_activities">Annual ADA Prevention activities</label>
                        <input type="text" name="prevention_activities" id="prevention_activities" required />
                    </div>

                    <div class="form-group">
                        <label>Choose Activity</label>
                        <div class="activity-tabs" id="activityTabs">
                            <div class="activity-tab active" data-activity="1">Activity 1</div>
                            <div class="activity-tab" data-activity="2">Activity 2</div>
                            <div class="activity-tab" data-activity="3">Activity 3</div>
                            <div class="activity-tab" data-activity="4">Activity 4</div>
                            <div class="activity-tab" data-activity="5">Activity 5</div>
                        </div>
                    </div>

                    <div id="activityPanels">
                        <div class="activity-panel active" data-activity-panel="1">
                            <div class="form-group">
                                <label for="reporting_period_a1">Progress during the quarter/reporting period (provide notes)</label>
                                <input type="text" name="reporting_period" id="reporting_period_a1" required />
                            </div>
                            <div class="form-group">
                                <label for="quarter_achievement_a1">Indicator(s) of the quarter achievement</label>
                                <input type="text" name="quarter_achievement" id="quarter_achievement_a1" required />
                            </div>
                            <div class="form-group">
                                <label for="quarter_in_a1">Performance for the quarter in (%)</label>
                                <input type="text" name="quarter_in" id="quarter_in_a1" required />
                            </div>
                            <div class="form-group">
                                <label for="for_the_quarter_a1">Target for the quarter (%)</label>
                                <input type="text" name="for_the_quarter" id="for_the_quarter_a1" required />
                            </div>
                            <div class="form-group">
                                <label for="variance_for_the_quarter_a1">Variance for the quarter (%)</label>
                                <input type="text" name="variance_for_the_quarter" id="variance_for_the_quarter_a1" required />
                            </div>
                            <div class="form-group">
                                <label for="achievement_to_date_a1">Cumulative achievement to date</label>
                                <input type="text" name="achievement_to_date" id="achievement_to_date_a1" required />
                            </div>
                            <div class="form-group">
                                <label for="annual_activity_target_a1">Annual activity target in (%)</label>
                                <input type="text" name="annual_activity_target" id="annual_activity_target_a1" required />
                            </div>
                            <div class="form-group">
                                <label for="from_annual_target_a1">Variance from annual target (%)</label>
                                <input type="text" name="from_annual_target" id="from_annual_target_a1" required />
                            </div>
                            <div class="form-group">
                                <label for="challenges_or_learnings_a1">Comments on any variance, challenges or learnings</label>
                                <input type="text" name="challenges_or_learnings" id="challenges_or_learnings_a1" required />
                            </div>
                        </div>
                        <div class="activity-panel" data-activity-panel="2">
                            <div class="form-group">
                                <label for="reporting_period_a2">Progress during the quarter/reporting period (provide notes)</label>
                                <input type="text" name="reporting_period" id="reporting_period_a2" />
                            </div>
                            <div class="form-group">
                                <label for="quarter_achievement_a2">Indicator(s) of the quarter achievement</label>
                                <input type="text" name="quarter_achievement" id="quarter_achievement_a2" />
                            </div>
                            <div class="form-group">
                                <label for="quarter_in_a2">Performance for the quarter in (%)</label>
                                <input type="text" name="quarter_in" id="quarter_in_a2" />
                            </div>
                            <div class="form-group">
                                <label for="for_the_quarter_a2">Target for the quarter (%)</label>
                                <input type="text" name="for_the_quarter" id="for_the_quarter_a2" />
                            </div>
                            <div class="form-group">
                                <label for="variance_for_the_quarter_a2">Variance for the quarter (%)</label>
                                <input type="text" name="variance_for_the_quarter" id="variance_for_the_quarter_a2" />
                            </div>
                            <div class="form-group">
                                <label for="achievement_to_date_a2">Cumulative achievement to date</label>
                                <input type="text" name="achievement_to_date" id="achievement_to_date_a2" />
                            </div>
                            <div class="form-group">
                                <label for="annual_activity_target_a2">Annual activity target in (%)</label>
                                <input type="text" name="annual_activity_target" id="annual_activity_target_a2" />
                            </div>
                            <div class="form-group">
                                <label for="from_annual_target_a2">Variance from annual target (%)</label>
                                <input type="text" name="from_annual_target" id="from_annual_target_a2" />
                            </div>
                            <div class="form-group">
                                <label for="challenges_or_learnings_a2">Comments on any variance, challenges or learnings</label>
                                <input type="text" name="challenges_or_learnings" id="challenges_or_learnings_a2" />
                            </div>
                        </div>
                        <div class="activity-panel" data-activity-panel="3">
                            <div class="form-group">
                                <label for="reporting_period_a3">Progress during the quarter/reporting period (provide notes)</label>
                                <input type="text" name="reporting_period" id="reporting_period_a3" />
                            </div>
                            <div class="form-group">
                                <label for="quarter_achievement_a3">Indicator(s) of the quarter achievement</label>
                                <input type="text" name="quarter_achievement" id="quarter_achievement_a3" />
                            </div>
                            <div class="form-group">
                                <label for="quarter_in_a3">Performance for the quarter in (%)</label>
                                <input type="text" name="quarter_in" id="quarter_in_a3" />
                            </div>
                            <div class="form-group">
                                <label for="for_the_quarter_a3">Target for the quarter (%)</label>
                                <input type="text" name="for_the_quarter" id="for_the_quarter_a3" />
                            </div>
                            <div class="form-group">
                                <label for="variance_for_the_quarter_a3">Variance for the quarter (%)</label>
                                <input type="text" name="variance_for_the_quarter" id="variance_for_the_quarter_a3" />
                            </div>
                            <div class="form-group">
                                <label for="achievement_to_date_a3">Cumulative achievement to date</label>
                                <input type="text" name="achievement_to_date" id="achievement_to_date_a3" />
                            </div>
                            <div class="form-group">
                                <label for="annual_activity_target_a3">Annual activity target in (%)</label>
                                <input type="text" name="annual_activity_target" id="annual_activity_target_a3" />
                            </div>
                            <div class="form-group">
                                <label for="from_annual_target_a3">Variance from annual target (%)</label>
                                <input type="text" name="from_annual_target" id="from_annual_target_a3" />
                            </div>
                            <div class="form-group">
                                <label for="challenges_or_learnings_a3">Comments on any variance, challenges or learnings</label>
                                <input type="text" name="challenges_or_learnings" id="challenges_or_learnings_a3" />
                            </div>
                        </div>
                        <div class="activity-panel" data-activity-panel="4">
                            <div class="form-group">
                                <label for="reporting_period_a4">Progress during the quarter/reporting period (provide notes)</label>
                                <input type="text" name="reporting_period" id="reporting_period_a4" />
                            </div>
                            <div class="form-group">
                                <label for="quarter_achievement_a4">Indicator(s) of the quarter achievement</label>
                                <input type="text" name="quarter_achievement" id="quarter_achievement_a4" />
                            </div>
                            <div class="form-group">
                                <label for="quarter_in_a4">Performance for the quarter in (%)</label>
                                <input type="text" name="quarter_in" id="quarter_in_a4" />
                            </div>
                            <div class="form-group">
                                <label for="for_the_quarter_a4">Target for the quarter (%)</label>
                                <input type="text" name="for_the_quarter" id="for_the_quarter_a4" />
                            </div>
                            <div class="form-group">
                                <label for="variance_for_the_quarter_a4">Variance for the quarter (%)</label>
                                <input type="text" name="variance_for_the_quarter" id="variance_for_the_quarter_a4" />
                            </div>
                            <div class="form-group">
                                <label for="achievement_to_date_a4">Cumulative achievement to date</label>
                                <input type="text" name="achievement_to_date" id="achievement_to_date_a4" />
                            </div>
                            <div class="form-group">
                                <label for="annual_activity_target_a4">Annual activity target in (%)</label>
                                <input type="text" name="annual_activity_target" id="annual_activity_target_a4" />
                            </div>
                            <div class="form-group">
                                <label for="from_annual_target_a4">Variance from annual target (%)</label>
                                <input type="text" name="from_annual_target" id="from_annual_target_a4" />
                            </div>
                            <div class="form-group">
                                <label for="challenges_or_learnings_a4">Comments on any variance, challenges or learnings</label>
                                <input type="text" name="challenges_or_learnings" id="challenges_or_learnings_a4" />
                            </div>
                        </div>
                        <div class="activity-panel" data-activity-panel="5">
                            <div class="form-group">
                                <label for="reporting_period_a5">Progress during the quarter/reporting period (provide notes)</label>
                                <input type="text" name="reporting_period" id="reporting_period_a5" />
                            </div>
                            <div class="form-group">
                                <label for="quarter_achievement_a5">Indicator(s) of the quarter achievement</label>
                                <input type="text" name="quarter_achievement" id="quarter_achievement_a5" />
                            </div>
                            <div class="form-group">
                                <label for="quarter_in_a5">Performance for the quarter in (%)</label>
                                <input type="text" name="quarter_in" id="quarter_in_a5" />
                            </div>
                            <div class="form-group">
                                <label for="for_the_quarter_a5">Target for the quarter (%)</label>
                                <input type="text" name="for_the_quarter" id="for_the_quarter_a5" />
                            </div>
                            <div class="form-group">
                                <label for="variance_for_the_quarter_a5">Variance for the quarter (%)</label>
                                <input type="text" name="variance_for_the_quarter" id="variance_for_the_quarter_a5" />
                            </div>
                            <div class="form-group">
                                <label for="achievement_to_date_a5">Cumulative achievement to date</label>
                                <input type="text" name="achievement_to_date" id="achievement_to_date_a5" />
                            </div>
                            <div class="form-group">
                                <label for="annual_activity_target_a5">Annual activity target in (%)</label>
                                <input type="text" name="annual_activity_target" id="annual_activity_target_a5" />
                            </div>
                            <div class="form-group">
                                <label for="from_annual_target_a5">Variance from annual target (%)</label>
                                <input type="text" name="from_annual_target" id="from_annual_target_a5" />
                            </div>
                            <div class="form-group">
                                <label for="challenges_or_learnings_a5">Comments on any variance, challenges or learnings</label>
                                <input type="text" name="challenges_or_learnings" id="challenges_or_learnings_a5" />
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card">
                    <h2 class="card-header">Additional Information</h2>
                    
                    <div class="form-group">
                        <label for="quarterly_totals">Quarterly totals</label>
                        <input type="text" name="quarterly_totals" id="quarterly_totals" required />
                    </div>
                    
                    <div class="form-group">
                        <label for="document">Upload a document</label>
                        <p class="document-info">this should contain the exact same data element which is collected inside QUARTERLY/ANNUAL REPORTING TEMPLATE</p>
                        <input type="file" name="document" id="document" accept="*/*" />
                    </div>
                    
                    <div class="certification-section">
                        <h3 class="certification-title">I certify that this report submitted to NACADA is accurate</h3>
                        
                        <div class="form-group">
                            <label for="name_of_reporter">Name of reporter</label>
                            <input type="text" name="name_of_reporter" id="name_of_reporter" required />
                        </div>
                        
                        <div class="form-group">
                            <label for="designation">Designation</label>
                            <input type="text" name="designation" id="designation" required />
                        </div>
                        
                        <div class="form-group">
                            <label for="Tel_No">Tel No.</label>
                            <input type="text" name="Tel_No" id="Tel_No" required />
                        </div>
                        
                        <div class="form-group">
                            <label for="prqt_email">Email address</label>
                            <input type="email" name="prqt_email" id="prqt_email" required />
                        </div>
                        
                        <div class="form-group">
                            <label for="prq_date">Date</label>
                            <input type="date" name="prq_date" id="prq_date" required />
                        </div>
                    </div>
                    
                    <button type="submit" class="btn-submit">Submit</button>
                </div>
            </div>
        </form>
    </div>
    <script>
    (function() {
        var tabs = document.querySelectorAll('.activity-tab');
        var panels = document.querySelectorAll('.activity-panel');
        var hiddenActivity = document.getElementById('activity');

        function setActive(activity) {
            tabs.forEach(function(tab) {
                tab.classList.toggle('active', tab.getAttribute('data-activity') === String(activity));
            });
            panels.forEach(function(panel) {
                var isActive = panel.getAttribute('data-activity-panel') === String(activity);
                panel.classList.toggle('active', isActive);
                // Enable inputs in active panel, disable others to avoid duplicate names posting
                var inputs = panel.querySelectorAll('input, select, textarea');
                inputs.forEach(function(inp) {
                    if (isActive) {
                        inp.removeAttribute('disabled');
                        inp.required = inp.getAttribute('id') && inp.getAttribute('id').endsWith('_a' + activity) ? true : inp.required;
                    } else {
                        inp.setAttribute('disabled', 'disabled');
                        // Do not require fields in inactive panels
                        inp.required = false;
                    }
                });
            });
            hiddenActivity.value = String(activity);
        }

        tabs.forEach(function(tab) {
            tab.addEventListener('click', function() {
                var activity = this.getAttribute('data-activity');
                setActive(activity);
            });
        });

        // Initialize: disable all inactive panel inputs
        setActive(hiddenActivity.value || '1');
    })();
    </script>
</body>
</html>
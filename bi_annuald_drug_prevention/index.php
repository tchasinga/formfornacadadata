<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$success_message = "";
$error_message = "";


$startYear = 2022;          // first year to show (change if needed)
$currentYear = date('Y');
$currentMonth = date('n');  // 1-12

$periods = [];

// Determine current semester
$currentSemester = ($currentMonth <= 6) ? 'S1' : 'S2';

// Loop through years
for ($year = $startYear; $year <= $currentYear; $year++) {
    // S1 always exists
    $periods[] = [
        'value' => $year . 'S1',
        'label' => $year . ' Jan – Jun (S1)'
    ];

    // S2 only if we are past June of this year
    if ($year < $currentYear || $currentSemester === 'S2') {
        $periods[] = [
            'value' => $year . 'S2',
            'label' => $year . ' Jul – Dec (S2)'
        ];
    }
}

// auto-select current period
$currentPeriod = $currentYear . $currentSemester;


// API credentials
$url = "https://monitoring.nacada.go.ke/api/dataValueSets";
$username = "jack";
$password = "Jocsoft@2027!!";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $value = $_POST['value'];
	$period = $_POST['period'] ?? $currentPeriod;
    $full_nameoforganization = $_POST['full_nameoforganization'];
    $telephone_number = $_POST['telephone_number'];
    $contact_person = $_POST['contact_person'];
    $physical_location = $_POST['physical_location'];
    $email_address = $_POST['email_address'];
    $type_of_registration = $_POST['type_of_registration'];
    $source_of_funding = $_POST['source_of_funding'];
    $badp_government = $_POST['badp_government'];
    $donor_funding = $_POST['donor_funding'];
    $networks = $_POST['networks'];
    $counties_of_operation = $_POST['counties_of_operation'];
    $drug_abuse = $_POST['drug_abuse'];
    $intervention_activity_01 = $_POST['intervention_activity_01'];
    $intervention_activity_02 = $_POST['intervention_activity_02'];
    $setting_01 = $_POST['setting_01'];
    $setting_02 = $_POST['setting_02'];
    $target_group_01 = $_POST['target_group_01'];
    $target_group_02 = $_POST['target_group_02'];
    $no_of_people_reached_01 = $_POST['no_of_people_reached_01'];
    $no_of_people_reached_02 = $_POST['no_of_people_reached_02'];
    $other_csos = $_POST['other_csos'];
    $badpgovernment = $_POST['badpgovernment'];
    $badp_learninginstitution = $_POST['badp_learninginstitution'];
    $badp_other_specify = $_POST['badp_other_specify'];
    $badp_international_NGO = $_POST['badp_international_NGO'];
    $your_work = $_POST['your_work'];
    $other_commentsbadp = $_POST['other_commentsbadp'];

    $data = [
        "dataSet" => "SQAjVomXv0s",
        "completeDate" => date("Y-m-d"),
        "period" => $period,
        "orgUnit" => "ORwhnDymBpM",
        "dataValues" => [
            [
                "dataElement" => "ZRudxIpxI2L",
                "value" => $value
            ],
            [
                "dataElement" => "qtTkjSmNQUe",
                "value" => $full_nameoforganization
            ],
            [
                "dataElement" => "D1gI0jdsdp2",
                "value" => $telephone_number
            ],
            [
                "dataElement" => "tsNt5k1bBFf",
                "value" => $contact_person
            ],
            [
                "dataElement" => "TIQX6S5YIis",
                "value" => $physical_location
            ],
            [
                "dataElement" => "RvHKcggWKCj",
                "value" => $email_address
            ],
            [
                "dataElement" => "RXedT8xP8dW",
                "value" => $type_of_registration
            ],
            [
                "dataElement" => "VJISUqCq7ee",
                "value" => $source_of_funding
            ],
            [
                "dataElement" => "LodLeVlIigm",
                "value" => $badp_government
            ],
            [
                "dataElement" => "wuzKPV7v6ei",
                "value" => $donor_funding
            ],
            [
                "dataElement" => "kupSRX7jDvD",
                "value" => $networks
            ],
            [
                "dataElement" => "A5noZTfQUCK",
                "value" => $counties_of_operation
            ],
            [
                "dataElement" => "cDdD8DMQ3sC",
                "value" => $drug_abuse
            ],
            [
                "dataElement" => "aoDLyMgu5qk",
                "categoryOptionCombo" => "h61nf5pMlL2",
                "value" => $intervention_activity_01
            ],
            [
                "dataElement" => "aoDLyMgu5qk",
                "categoryOptionCombo" => "jdbdfXwgbQ5",
                "value" => $intervention_activity_02
            ],

            [
                "dataElement" => "UC83uH0BzlF",
                "categoryOptionCombo" => "h61nf5pMlL2",
                "value" => $setting_01
            ],
            [
                "dataElement" => "UC83uH0BzlF",
                "categoryOptionCombo" => "jdbdfXwgbQ5",
                "value" => $setting_02
            ],

            [
                "dataElement" => "bneey8XnDZN",
                "categoryOptionCombo" => "h61nf5pMlL2",
                "value" => $target_group_01
            ],
            [
                "dataElement" => "bneey8XnDZN",
                "categoryOptionCombo" => "jdbdfXwgbQ5",
                "value" => $target_group_02
            ],

            [
                "dataElement" => "qnwKlYFwO2b",
                "categoryOptionCombo" => "h61nf5pMlL2",
                "value" => $no_of_people_reached_01
            ],
            [
                "dataElement" => "qnwKlYFwO2b",
                "categoryOptionCombo" => "jdbdfXwgbQ5",
                "value" => $no_of_people_reached_02
            ],

            [
                "dataElement" => "TYZpDx8uaQV",
                "value" => $other_csos
            ],

            [
                "dataElement" => "k4OaK5mkRoU",
                "value" => $badpgovernment
            ],

            [
                "dataElement" => "XuVoRN9if8o",
                "value" => $badp_learninginstitution
            ],

            [
                "dataElement" => "JptsZIwUQDA",
                "value" => $badp_other_specify
            ],

            [
                "dataElement" => "Fln8WDtWJDK",
                "value" => $badp_international_NGO
            ],

            [
                "dataElement" => "lHDdoBjlhpL",
                "value" => $your_work
            ],
            [
                "dataElement" => "NsMnddzr3qN",
                "value" => $other_commentsbadp
            ]
        ]
    ];

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PREVENTION BI ANNUAL REPORTING TO NACADA HQ</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #e9ecef 0%, #f8fafc 100%);
            
            font-family: 'Roboto', Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            background: #ffffff;
            max-width: 1000px;
            margin: 50px auto;
            border-radius: 15px;
            box-shadow: 0 6px 32px 0 rgba(53,96,146,0.13), 0 1.5px 5px 0 rgba(0,0,0,0.04);
            padding: 40px;
        }
        h2 {
            text-align: center;
            color: #394867;
            font-size: 2.2rem;
            margin-bottom: 30px;
            font-weight: 700;
            letter-spacing: 1px;
        }
        .form-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 10px;
        }
        .form-group {
            display: flex;
            flex-direction: column;
            margin-bottom: 18px;
        }
        label {
            font-size: 1.03rem;
            color: #394867;
            font-weight: 500;
            margin-bottom: 6px;
        }
        input[type="text"],
        input[type="tel"],
        input[type="email"],
        input[type="number"],
        textarea,
        select {
            font-size: 1rem;
            padding: 11px 13px;
            border: 1px solid #bfc7d1;
            border-radius: 7px;
            background: #f4f6fa;
            transition: border-color 0.2s;
            margin-bottom: 2px;
            outline: none;
        }
        input[type="text"]:focus,
        input[type="tel"]:focus,
        input[type="email"]:focus,
        input[type="number"]:focus,
        textarea:focus,
        select:focus {
            border-color: #4f8cff;
            background: #f0f7ff;
        }
        textarea {
            resize: vertical;
            min-height: 50px;
            max-height: 150px;
        }
        button[type="submit"] {
            margin-top: 16px;
            padding: 13px 0;
            font-size: 1.12rem;
            color: #fff;
            background: linear-gradient(90deg, #4f8cff 0%, #394867 100%);
            border: none;
            border-radius: 7px;
            font-weight: 600;
            letter-spacing: 1.1px;
            box-shadow: 0 2px 8px rgba(79,140,255,0.09);
            cursor: pointer;
            transition: background 0.2s, box-shadow 0.15s;
            grid-column: 1 / -1;
        }
        button[type="submit"]:hover {
            background: linear-gradient(90deg, #394867 0%, #4f8cff 100%);
            box-shadow: 0 4px 16px rgba(79,140,255,0.15);
        }
        .status-message {
            text-align: center;
            margin: 0 0 18px 0;
            padding: 13px 17px;
            border-radius: 7px;
            font-size: 1.08rem;
            font-weight: 500;
            grid-column: 1 / -1;
        }
        .status-message.success {
            background: #e6fff2;
            color: #227a4d;
            border: 1px solid #81e6b6;
        }
        .status-message.error {
            background: #fff3f2;
            color: #c62828;
            border: 1px solid #f5bcbc;
        }
        @media (max-width: 700px) {
            .container {
                max-width: 97vw;
                padding: 22px 7vw;
            }
            h2 {
                font-size: 1.4rem;
            }
            .form-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h3 style="text-align:center">PREVENTION BI ANNUAL REPORTING TO NACADA HQ</h3>
        
        <form method="POST" autocomplete="off">
            <div class="form-container">
                <?php if ($success_message): ?>
                    <div class="status-message success"><?php echo $success_message; ?></div>
                <?php endif; ?>
                <?php if ($error_message): ?>
                    <div class="status-message error"><?php echo $error_message; ?></div>
                <?php endif; ?>
                 <div class="form-group">
					<label for="period">Bi Annual Reporting Period</label>
					<select name="period" id="period" required>
						<option value="">Select reporting period</option>
						<?php foreach ($periods as $p): ?>
							<option value="<?= $p['value']; ?>"
								<?= ($p['value'] === ($period ?? $currentPeriod)) ? 'selected' : ''; ?>>
								<?= $p['label']; ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
                <div class="form-group">
                    <label for="value">Designation</label>
                    <input type="text" name="value" id="value" required>
                </div>
				

                <div class="form-group">
                    <label for="full_nameoforganization">Full name of organization/WorkGroup</label>
                    <input type="text" name="full_nameoforganization" id="full_nameoforganization" required>
                </div>

                <div class="form-group">
                    <label for="telephone_number">Telephone number(s)</label>
                    <input type="tel" name="telephone_number" id="telephone_number" required>
                </div>

                <div class="form-group">
                    <label for="contact_person">Contact person</label>
                    <input type="tel" name="contact_person" id="contact_person" placeholder="Enter Phone Number "required>
                </div>

                <div class="form-group">
                    <label for="physical_location">Physical location</label>
                    <input type="text" name="physical_location" id="physical_location" required>
                </div>

                <div class="form-group">
                    <label for="email_address">Email address</label>
                    <input type="email" name="email_address" id="email_address" required>
                </div>

                <div class="form-group">
                    <label for="type_of_registration">Type of registration</label>
                    <select name="type_of_registration" id="type_of_registration">
                        <option value="">Select one</option>
                        <option value="Government Ministry or Agency">Government Ministry or Agency</option>
                        <option value="International Non-Governmental Organizations (iNGOs)">International Non-Governmental Organizations (iNGOs)</option>
                        <option value="Local Non-Governmental Organization">Local Non-Governmental Organization</option>
                        <option value="Faith Based Organization">Faith Based Organization</option>
                        <option value="Community Based Organisations">Community Based Organisations</option>
                        <option value="County Community Workgroup">County Community Workgroup</option>
                        <option value="Women's Organizations">Women's Organizations</option>
                        <option value="Youth Organizations">Youth Organizations</option>
                        <option value="Children's Organizations">Children's Organizations</option>
                        <option value="Charitable Trust">Charitable Trust</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="source_of_funding">Source of funding</label>
                    <select name="source_of_funding" id="source_of_funding">
                        <option value="">Select one</option>
                        <option value="Income generating activities">Income generating activities</option>
                        <option value="Private">Private</option>
                        <option value="Donations and contributions">Donations and contributions</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="badp_government">Government (specify)</label>
                    <input type="text" name="badp_government" id="badp_government" required>
                </div>

                <div class="form-group">
                    <label for="donor_funding">Donor funding (specify)</label>
                    <input type="text" name="donor_funding" id="donor_funding" required>
                </div>

                <div class="form-group" style="grid-column: 1 / -1;">
                    <label for="networks">Networks, coalitions & alliances: (Please mention networks that you are a member of.)</label>
                    <textarea rows="4" name="networks" id="networks"></textarea>
                </div>

                <div class="form-group" style="grid-column: 1 / -1;">
                    <label for="counties_of_operation">County/counties of operation</label>
                    <textarea rows="4" name="counties_of_operation" id="counties_of_operation"></textarea>
                </div>

                <div class="form-group" style="grid-column: 1 / -1;">
                    <label for="drug_abuse">Organizational goals related to alcohol and drug abuse</label>
                    <textarea rows="4" name="drug_abuse" id="drug_abuse"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="intervention_activity_01">Specify Intervention Activity | 01</label>
                    <input type="text" name="intervention_activity_01" id="intervention_activity_01" required>
                </div>

                <div class="form-group">
                    <label for="intervention_activity_02">Specify Intervention Activity | 02</label>
                    <input type="text" name="intervention_activity_02" id="intervention_activity_02" required>
                </div>

                <div class="form-group">
                    <label for="setting_01">Setting (School, Community, Family, Workplace, etc.) | 01</label>
                    <input type="text" name="setting_01" id="setting_01" required>
                </div>

                <div class="form-group">
                    <label for="setting_02">Setting (School, Community, Family, Workplace, etc.) | 02</label>
                    <input type="text" name="setting_02" id="setting_02" required>
                </div>

                <div class="form-group">
                    <label for="target_group_01">Target group | 01</label>
                    <input type="text" name="target_group_01" id="target_group_01" required>
                </div>

                <div class="form-group">
                    <label for="target_group_02">Target group | 02</label>
                    <input type="text" name="target_group_02" id="target_group_02" required>
                </div>

                <div class="form-group">
                    <label for="no_of_people_reached_01">No. of people reached | 01</label>
                    <input type="number" name="no_of_people_reached_01" id="no_of_people_reached_01" required>
                </div>

                <div class="form-group">
                    <label for="no_of_people_reached_02">No. of people reached | 02</label>
                    <input type="number" name="no_of_people_reached_02" id="no_of_people_reached_02" required>
                </div>

                <div class="form-group">
                    <label for="other_csos">Other CSOs (specify)</label>
                    <input type="text" name="other_csos" id="other_csos" required>
                </div>

                <div class="form-group">
                    <label for="badpgovernment">Government</label>
                    <input type="text" name="badpgovernment" id="badpgovernment" required>
                </div>

                <div class="form-group">
                    <label for="badp_learninginstitution">Learning institution</label>
                    <input type="text" name="badp_learninginstitution" id="badp_learninginstitution" required>
                </div>

                <div class="form-group">
                    <label for="badp_other_specify">Other (Specify)</label>
                    <input type="text" name="badp_other_specify" id="badp_other_specify" required>
                </div>

                <div class="form-group">
                    <label for="badp_international_NGO">International NGO</label>
                    <input type="text" name="badp_international_NGO" id="badp_international_NGO" required>
                </div>

                <div class="form-group" style="grid-column: 1 / -1;">
                    <label for="your_work">Challenges faced in your work</label>
                    <textarea rows="4" name="your_work" id="your_work"></textarea>
                </div>

                <div class="form-group" style="grid-column: 1 / -1;">
                    <label for="other_commentsbadp">Other comments</label>
                    <textarea rows="4" name="other_commentsbadp" id="other_commentsbadp"></textarea>
                </div>

                <button type="submit">Submit</button>
            </div>
        </form>
    </div>
</body>
</html>
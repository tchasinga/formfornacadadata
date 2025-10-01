<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$success_message = "";
$error_message = "";

// API credentials
$url = "https://monitoring.jocsoft.net/dhis/api/dataValueSets";
$username = "jack";
$password = "Jocsoft@2027!!";

// Kenya counties array
$kenya_counties = [
    "Mombasa", "Kwale", "Kilifi", "Tana River", "Lamu", "Taita-Taveta", "Garissa", "Wajir", "Mandera", 
    "Marsabit", "Isiolo", "Meru", "Tharaka-Nithi", "Embu", "Kitui", "Machakos", "Makueni", "Nyandarua", 
    "Nyeri", "Kirinyaga", "Murang'a", "Kiambu", "Turkana", "West Pokot", "Samburu", "Trans Nzoia", 
    "Uasin Gishu", "Elgeyo-Marakwet", "Nandi", "Baringo", "Laikipia", "Nakuru", "Narok", "Kajiado", 
    "Kericho", "Bomet", "Kakamega", "Vihiga", "Bungoma", "Busia", "Siaya", "Kisumu", "Homa Bay", 
    "Migori", "Kisii", "Nyamira", "Nairobi"
];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $value = $_POST['value'];
    $county = $_POST['county'];
    $sub_county = $_POST['sub_county'];
    $termyear = $_POST['termyear'];
    $student_population = $_POST['student_population'];
    $rfp_carry_out_inspections_and_impromptu_searches = $_POST['rfp_carry_out_inspections_and_impromptu_searches'];
    $rfp_no_of_inspections_and_impromptu_searches = $_POST['rfp_no_of_inspections_and_impromptu_searches'];
    $rfp_report_suspicion_or_sale_of_alcohol_tobacco_and_other_drugs_in_or_near_the_school = $_POST['rfp_report_suspicion_or_sale_of_alcohol_tobacco_and_other_drugs_in_or_near_the_school'];
    $rfp_no_of_cases_reported_kiosks_shops_alcohol_selling_outlets_peddlers = $_POST['rfp_no_of_cases_reported_kiosks_shops_alcohol_selling_outlets_peddlers'];
    $rfp_ban_vending_of_food_and_other_items_during_school_events = $_POST['rfp_ban_vending_of_food_and_other_items_during_school_events'];
    $rfp_no_of_events_held_with_no_outside_vendors = $_POST['rfp_no_of_events_held_with_no_outside_vendors'];
    $rfp_regulate_storage_of_prescription_drugs = $_POST['rfp_regulate_storage_of_prescription_drugs'];
    $rfp_provision_of_storage_for_prescription_medicines = $_POST['rfp_provision_of_storage_for_prescription_medicines'];
    $rfp_ensure_no_alcohol_and_substance_use_within_school_premises_and_during_school_events = $_POST['rfp_ensure_no_alcohol_and_substance_use_within_school_premises_and_during_school_events'];
    $rfp_no_of_persons_identified_using_within_or_reporting_to_school_under_the_influence = $_POST['rfp_no_of_persons_identified_using_within_or_reporting_to_school_under_the_influence'];
    $rfp_no_of_sensitizations_and_no_of_teachers_and_staff_sensitized = $_POST['rfp_no_of_sensitizations_and_no_of_teachers_and_staff_sensitized'];
    $rfp_facilitate_sensitization_of_parents = $_POST['rfp_facilitate_sensitization_of_parents'];
    $rfp_no_of_sensitizations_and_no_of_parents_sensitized = $_POST['rfp_no_of_sensitizations_and_no_of_parents_sensitized'];
    $rfp_conduct_sensitization_for_learners = $_POST['rfp_conduct_sensitization_for_learners'];
    $rfp_no_of_sensitizations_and_no_of_learners_sensitized = $_POST['rfp_no_of_sensitizations_and_no_of_learners_sensitized'];
    $rfp_manage_incidents_as_per_guidelines = $_POST['rfp_manage_incidents_as_per_guidelines'];
    $rfp_no_of_incidents_related_to_alcohol_and_substance_use = $_POST['rfp_no_of_incidents_related_to_alcohol_and_substance_use'];
    $substances_confiscated = $_POST['substances_confiscated'];

   

    $data = [
        "dataSet" => "uQFmtDzKIYZ",
        "completeDate" => date("Y-m-d"),
        "period" => "2024",
        "orgUnit" => "ORwhnDymBpM",
        "dataValues" => [
            [
                "dataElement" => "udyCSmJ3aYy",
                "value" => $value
            ],
            [
                "dataElement" => "j20aB9Z7oAo",
                "value" => $county
            ],
            [
                "dataElement" => "bvBzFODs2Ya",
                "value" => $sub_county
            ],
            [
                "dataElement" => "wDCFEMUS5ix",
                "value" => $termyear
            ],
            [
                "dataElement" => "lJJiz8nMdvI",
                "value" => $student_population
            ],
            [
                "dataElement" => "aI77SZSnA3X",
                "value" => $rfp_carry_out_inspections_and_impromptu_searches
            ],
            [
                "dataElement" => "HRlnYNjEWMe",
                "value" => $rfp_no_of_inspections_and_impromptu_searches
            ],
            [
                "dataElement" => "Tb6K8z8yJL6",
                "value" => $rfp_report_suspicion_or_sale_of_alcohol_tobacco_and_other_drugs_in_or_near_the_school
            ],
            [
                "dataElement" => "fnSxJYhGvtM",
                "value" => $rfp_no_of_cases_reported_kiosks_shops_alcohol_selling_outlets_peddlers
            ],
            [
                "dataElement" => "emeLAYVevFv",
                "value" => $rfp_ban_vending_of_food_and_other_items_during_school_events
            ],
            [
                "dataElement" => "ZhvNwXvpsBL",
                "value" => $rfp_no_of_events_held_with_no_outside_vendors
            ],
            [
                "dataElement" => "tiG1ZL0WRex",
                "value" => $rfp_regulate_storage_of_prescription_drugs
            ],
            [
                "dataElement" => "qDaCBq6HHCJ",
                "value" => $rfp_provision_of_storage_for_prescription_medicines
            ],
            [
                "dataElement" => "bNSrLNxA1rA",
                "value" => $rfp_ensure_no_alcohol_and_substance_use_within_school_premises_and_during_school_events
            ],
            [
                "dataElement" => "ickQjHDF2WB",
                "value" => $rfp_no_of_persons_identified_using_within_or_reporting_to_school_under_the_influence
            ],
            [
                "dataElement" => "wGOdYLiT3YL",
                "value" => $rfp_no_of_sensitizations_and_no_of_teachers_and_staff_sensitized
            ],
            [
                "dataElement" => "BnBTLDouHLV",
                "value" => $rfp_facilitate_sensitization_of_parents
            ],
            [
                "dataElement" => "fd5PuY1ad59",
                "value" => $rfp_no_of_sensitizations_and_no_of_parents_sensitized
            ],
            [
                "dataElement" => "nA2LrUy58Za",
                "value" => $rfp_conduct_sensitization_for_learners
            ],
            [
                "dataElement" => "HwxRSaphMEW",
                "value" => $rfp_no_of_sensitizations_and_no_of_learners_sensitized
            ],
            [
                "dataElement" => "dOar6OS2WbG",
                "value" => $rfp_manage_incidents_as_per_guidelines
            ],
            [
                "dataElement" => "ezYC9rr0Re0",
                "value" => $rfp_no_of_incidents_related_to_alcohol_and_substance_use
            ],
            [
                "dataElement" => "S1KkK6plTg9",
                "value" => $substances_confiscated
            ],

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
    <title>Reporting Format on Prevention, Control and Management of Alcohol and Substance Use at School Level data entry form</title>
    <style>
        form{
            display: flex;
            flex-direction: column;
            max-width: 1000px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Reporting Format on Prevention, Control and Management of Alcohol and Substance Use at School Level</h1>
        
        <?php if ($success_message): ?>
            <div class="message success"><?php echo htmlspecialchars($success_message); ?></div>
        <?php endif; ?>
        
        <?php if ($error_message): ?>
            <div class="message error"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>
        
        <form method="POST">
            
                <label for="value">Name of the school <span class="required">*</span></label>
                <input type="text" name="value" id="value" required>
           
            
            
                <label for="county">County <span class="required">*</span></label>
                <select name="county" id="county" required>
                    <option value="">Select a county</option>
                    <?php foreach ($kenya_counties as $county): ?>
                        <option value="<?php echo htmlspecialchars($county); ?>">
                            <?php echo htmlspecialchars($county); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
           
                <label for="sub_county">Sub county <span class="required">*</span></label>
                <input type="text" name="sub_county" id="sub_county" required>

                <label for="termyear">Term/Year</label>
                <input type="date" name="termyear" id="termyear" required>

                <label for="student_population">Student population</label>
                <input type="text" name="student_population" id="student_population" required>

                <h1>Supply reduction</h1>

                <label for="rfp_carry_out_inspections_and_impromptu_searches">RFP-Carry out inspections and impromptu searches</label>
                <textarea name="rfp_carry_out_inspections_and_impromptu_searches" id="rfp_carry_out_inspections_and_impromptu_searches"></textarea>

                <label for="rfp_no_of_inspections_and_impromptu_searches">RFP-No of inspections and impromptu searches</label>
                <textarea name="rfp_no_of_inspections_and_impromptu_searches" id="rfp_no_of_inspections_and_impromptu_searches" required></textarea>

                <label for="rfp_report_suspicion_or_sale_of_alcohol_tobacco_and_other_drugs_in_or_near_the_school">RFP-Report suspicion or sale of alcohol, tobacco and other drugs in or near the school</label>
                <textarea name="rfp_report_suspicion_or_sale_of_alcohol_tobacco_and_other_drugs_in_or_near_the_school" id="rfp_report_suspicion_or_sale_of_alcohol_tobacco_and_other_drugs_in_or_near_the_school" required></textarea>

                <label for="rfp_no_of_cases_reported_kiosks_shops_alcohol_selling_outlets_peddlers">RFP-No. of cases reported (kiosks, shops, alcohol selling outlets, peddlers)</label>
                <textarea name="rfp_no_of_cases_reported_kiosks_shops_alcohol_selling_outlets_peddlers" id="rfp_no_of_cases_reported_kiosks_shops_alcohol_selling_outlets_peddlers" required></textarea>

                <label for="rfp_ban_vending_of_food_and_other_items_during_school_events">RFP-1.3 Ban vending of food and other items during school events</label>
                <textarea name="rfp_ban_vending_of_food_and_other_items_during_school_events" id="rfp_ban_vending_of_food_and_other_items_during_school_events" required></textarea>

                <label for="rfp_no_of_events_held_with_no_outside_vendors">RFP-No. of events held with no outside vendors</label>
                <textarea name="rfp_no_of_events_held_with_no_outside_vendors" id="rfp_no_of_events_held_with_no_outside_vendors" required></textarea>

                <label for="rfp_regulate_storage_of_prescription_drugs">RFP-1.4 Regulate storage of prescription drugs</label>
                <textarea name="rfp_regulate_storage_of_prescription_drugs" id="rfp_regulate_storage_of_prescription_drugs" required></textarea>

                <label for="rfp_provision_of_storage_for_prescription_medicines">RFP-Provision of storage for prescription medicines</label>
                <textarea name="rfp_provision_of_storage_for_prescription_medicines" id="rfp_provision_of_storage_for_prescription_medicines" required></textarea>

                <label for="rfp_ensure_no_alcohol_and_substance_use_within_school_premises_and_during_school_events">RFP-1.5 Ensure no alcohol and substance use within school premises and during school events</label>
                <textarea name="rfp_ensure_no_alcohol_and_substance_use_within_school_premises_and_during_school_events" id="rfp_ensure_no_alcohol_and_substance_use_within_school_premises_and_during_school_events" required></textarea>

                <label for="rfp_no_of_persons_identified_using_within_or_reporting_to_school_under_the_influence">RFP-No. of persons identified using within or reporting to school under the influence</label>
                <textarea name="rfp_no_of_persons_identified_using_within_or_reporting_to_school_under_the_influence" id="rfp_no_of_persons_identified_using_within_or_reporting_to_school_under_the_influence" required></textarea>

                <h1>Preventive education</h1>

                <label for="rfp_conduct_sensitization_of_teachers_and_other_staff">RFP-2.1 Conduct sensitization of teachers and other staff</label>
                <textarea name="rfp_conduct_sensitization_of_teachers_and_other_staff" id="rfp_conduct_sensitization_of_teachers_and_other_staff" required></textarea>

                <label for="rfp_no_of_sensitizations_and_no_of_teachers_and_staff_sensitized">RFP-No. of sensitizations & No. of teachers and staff sensitized</label>
                <textarea name="rfp_no_of_sensitizations_and_no_of_teachers_and_staff_sensitized" id="rfp_no_of_sensitizations_and_no_of_teachers_and_staff_sensitized" required></textarea>

                <label for="rfp_facilitate_sensitization_of_parents">RFP-2.2 Facilitate sensitization of parents</label>
                <textarea name="rfp_facilitate_sensitization_of_parents" id="rfp_facilitate_sensitization_of_parents" required></textarea>

                <label for="rfp_no_of_sensitizations_and_no_of_parents_sensitized">RFP-No. of sensitizations & No. of parents sensitized</label>
                <textarea name="rfp_no_of_sensitizations_and_no_of_parents_sensitized" id="rfp_no_of_sensitizations_and_no_of_parents_sensitized" required></textarea>

                <label for="rfp_conduct_sensitization_for_learners">RFP-2.3 Conduct sensitization for learners</label>
                <textarea name="rfp_conduct_sensitization_for_learners" id="rfp_conduct_sensitization_for_learners" required></textarea>

                <label for="rfp_no_of_sensitizations_and_no_of_learners_sensitized">RFP-No. of sensitizations  & No. of learners sensitized</label>
                <textarea name="rfp_no_of_sensitizations_and_no_of_learners_sensitized" id="rfp_no_of_sensitizations_and_no_of_learners_sensitized" required></textarea>

                <h1>Incident management</h1>

                <label for="rfp_manage_incidents_as_per_guidelines">RFP-Manage incidents as per guidelines</label>
                <textarea name="rfp_manage_incidents_as_per_guidelines" id="rfp_manage_incidents_as_per_guidelines" required></textarea>

                <label for="rfp_no_of_incidents_related_to_alcohol_and_substance_use">RFP-No. of incidents related to alcohol and substance use</label>
                <textarea name="rfp_no_of_incidents_related_to_alcohol_and_substance_use" id="rfp_no_of_incidents_related_to_alcohol_and_substance_use" required></textarea>

                <label for="substances_confiscated">RFP-Types and quantities of substances confiscated</label>
                <textarea name="substances_confiscated" id="substances_confiscated" required></textarea>


            <button type="submit">Submit Data</button>
        </form>
    </div>
</body>
</html>
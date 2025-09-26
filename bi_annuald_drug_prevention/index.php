<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$success_message = "";
$error_message = "";

// API credentials
$url = "https://monitoring.jocsoft.net/dhis/api/dataValueSets";
$username = "jack";
$password = "Jocsoft@2027!!";


// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $value = $_POST['value'];
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


    

    $data = [
        "dataSet" => "SQAjVomXv0s",
        "completeDate" => date("Y-m-d"),
        "period" => "2025S1",
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
    <title>Submit Data to DHIS2</title>
    <style>
        form{
            display:flex;
            flex-direction:column;
            max-width: 400px;
        }
    </style>
</head>
<body>
    <h2>Submit Data Value</h2>
    <?php if ($success_message): ?>
        <p style="color: green;"><?php echo $success_message; ?></p>
    <?php endif; ?>
    <?php if ($error_message): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <form method="POST">
        <br><br>

        <label for="value">Designation</label>
        <input type="text" name="value" id="value" required>

        <label for="full_nameoforganization">Full name of organization/WorkGroup</label>
        <input type="text" name="full_nameoforganization" id="full_nameoforganization" required>

        <label for="telephone_number">Telephone number(s)</label>
        <input type="tel" name="telephone_number" id="telephone_number" required>

        <label for="contact_person">Contact person</label>
        <input type="tel" name="contact_person" id="contact_person" required>

        <label for="physical_location">Physical location</label>
        <input type="text" name="physical_location" id="physical_location" required>

        <label for="email_address">Email address</label>
        <input type="email" name="email_address" id="email_address" required>

        <label for="type_of_registration">Type of registration</label>
        <select name="type_of_registration" id="type_of_registration">
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

        <label for="source_of_funding">Source of funding</label>
        <select name="source_of_funding" id="source_of_funding">
            <option value="Income generating activities">Income generating activities</option>
            <option value="Private">Private</option>
            <option value="Donations and contributions">Donations and contributions</option>
        </select>

        <label for="badp_government"> Government (specify)</label>
        <input type="text" name="badp_government" id="badp_government" required>

        <label for="donor_funding">Donor funding (specify)</label>
        <input type="text" name="donor_funding" id="donor_funding" required>

        <label for="networks">Networks, coalitions & alliances: (Please mention networks that you are a member of.)</label>
        <textarea rows="4" cols="50"type="text" name="networks" id="networks"></textarea>

        <label for="counties_of_operation">County/counties of operation</label>
        <textarea rows="4" cols="50" type="text" name="counties_of_operation" id="counties_of_operation"></textarea>
        
        <button type="submit">Submit</button>
    </form>
</body>
</html>

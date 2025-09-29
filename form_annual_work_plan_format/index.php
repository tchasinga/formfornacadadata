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
    $parent_ministry = $_POST['parent_ministry'];
    $staff_institution = $_POST['staff_institution'];
    $where_applicable = $_POST['where_applicable'];
    $contact_person = $_POST['contact_person'];
    $email_address02 = $_POST['email_address02'];
    $ada_q1 = $_POST['ada_q1'];
    $ada_q2 = $_POST['ada_q2'];
    $ada_q3 = $_POST['ada_q3'];
    $ada_q4 = $_POST['ada_q4'];
    $ADA_Telephone_Number = $_POST['ADA_Telephone_Number'];
    $quarterly_totals = $_POST['quarterly_totals'];
    $activities01 = $_POST['activities01'];


    $data = [
        "dataSet" => "i0kCTg3AIlJ",
        "completeDate" => date("Y-m-d"),
        "period" => "2024",
        "orgUnit" => "ORwhnDymBpM",
        "dataValues" => [
            [
                "dataElement" => "xAsnE4qLcRL",
                "value" => $value
            ],
            [
                "dataElement" => "E26oBDsaqGu",
                "value" => $parent_ministry
            ],
            [
                "dataElement" => "daer2aeCNJt",
                "value" => $staff_institution
            ],
            [
                "dataElement" => "OzOvoTgR08C",
                "value" => $where_applicable
            ],
            [
                "dataElement" => "UjvE7ZBaJFB",
                "value" => $contact_person
            ],
            [
                "dataElement" => "LO7R3brWAxZ",
                "value" => $email_address02
            ],
            [
                "dataElement" => "juoUbClgftu",
                "value" => $ada_q1
            ],
            [
                "dataElement" => "fGLNBIumxLo",
                "value" => $ada_q2
            ],
            [
                "dataElement" => "XWQRHaRQtEP",
                "value" => $ada_q3
            ],
            [
                "dataElement" => "N49R9vcd5WT",
                "value" => $ada_q4
            ],
            [
                "dataElement" => "RW320Z3Au7T",
                "value" => $ADA_Telephone_Number
            ],
            [
                "dataElement" => "zkUrFzbH3Vm",
                "value" => $quarterly_totals
            ],
            [
                "dataElement" => "zkUrFzbH3Vm",
                "value" => $activities01
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
    <title>FORM-ANNUAL WORK PLAN FORMAT</title>

    <style>
        form{
            display:flex;
            flex-direction:column;
            max-width: 400px;
        }
    </style>
</head>
<body>
  <form method="POST">
    <label for="value">ADA-Name of the Institution</label>
    <input type="text" name="value" id="value" />

    <label for="parent_ministry">Parent Ministry</label>
    <input type="text" name="parent_ministry" id="parent_ministry" />

    <label for="staff_institution">Number of staff in the Institution</label>
    <input type="text" name="staff_institution" id="staff_institution" />

    <label for="where_applicable">Number of students in the institution (where applicable)</label>
    <input type="text" name="where_applicable" id="where_applicable" />

    <label for="contact_person">Contact Person</label>
    <input type="tel" name="contact_person" id="contact_person" />

    <label for="email_address02">Email Address</label>
    <input type="email" name="email_address02" id="email_address02" />

    <label for="ada_q1">ADA-Q1</label>
    <input type="number" name="ada_q1" id="ada_q1" />

    <label for="ada_q2">ADA-Q2</label>
    <input type="number" name="ada_q2" id="ada_q2" />

    <label for="ada_q3">ADA-Q3</label>
    <input type="number" name="ada_q3" id="ada_q3" />

    <label for="ada_q4">ADA-Q4</label>
    <input type="number" name="ada_q4" id="ada_q4" />

    <label for="ADA_Telephone_Number">Telephone Number</label>
    <input type="tel" name="ADA_Telephone_Number" id="ADA_Telephone_Number" />

    <label for="quarterly_totals">Quarterly totals</label>
    <input type="number" name="quarterly_totals" id="quarterly_totals" />

    <label for="activities01">Activities</label>
    <input type="text" name="activities01" id="activities01" />


    <button type="submit">Submit</button
  </form>  
</body>
</html>
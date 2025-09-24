<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$success_message = "";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name_of_contact_person = $_POST['name_of_contact_person'];
    $mobile_number = $_POST['mobile_number'];
    $email_address_of_contact_person = $_POST['email_address_of_contact_person'];
    $organization = $_POST['organization'];
    $number_of_participants = $_POST['number_of_participants'];
    $type_of_training = $_POST['type_of_training'];
    $training_dates_booked = $_POST['training_dates_booked'];
    $county = $_POST['county'];
    $payment_status = $_POST['payment_status'];
    $kra_pin_number = $_POST['kra_pin_number'];


    $url = "https://monitoring.jocsoft.net/dhis/api/tracker";
    $fileUrl = "https://monitoring.jocsoft.net/dhis/api/fileResources";
    $username = "admin";
    $password = "Jocsoft@2025!";
    $currentDate = date('Y-m-d');

    $fileResourceId = null;
    $paymentInvoiceFileId = null;

    // ✅ Step 1: Upload participant list file (if provided)
    if (isset($_FILES['participant_details_list']) && $_FILES['participant_details_list']['error'] === UPLOAD_ERR_OK) {
        $tmpFilePath = $_FILES['participant_details_list']['tmp_name'];
        $originalName = $_FILES['participant_details_list']['name'];

        $ch = curl_init($fileUrl);
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, [
            "file" => new CURLFile($tmpFilePath, mime_content_type($tmpFilePath), $originalName)
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $fileResponse = curl_exec($ch);
        curl_close($ch);

        $fileData = json_decode($fileResponse, true);
        if (isset($fileData['response']['fileResource']['id'])) {
            $fileResourceId = $fileData['response']['fileResource']['id'];
        } else {
            $error_message = "Participant list upload failed: " . htmlspecialchars($fileResponse);
        }
    }

    // ✅ Step 2: Upload payment invoice file if Payment status = Yes
    if ($payment_status === "Yes" && isset($_FILES['payment_invoice']) && $_FILES['payment_invoice']['error'] === UPLOAD_ERR_OK) {
        $tmpFilePath = $_FILES['payment_invoice']['tmp_name'];
        $originalName = $_FILES['payment_invoice']['name'];

        $ch = curl_init($fileUrl);
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, [
            "file" => new CURLFile($tmpFilePath, mime_content_type($tmpFilePath), $originalName)
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $fileResponse = curl_exec($ch);
        curl_close($ch);

        $fileData = json_decode($fileResponse, true);
        if (isset($fileData['response']['fileResource']['id'])) {
            $paymentInvoiceFileId = $fileData['response']['fileResource']['id'];
        } else {
            $error_message = "Payment invoice upload failed: " . htmlspecialchars($fileResponse);
        }
    }

    // ✅ Step 3: Build DHIS2 payload
    if (!$error_message) {
        $dataValues = [
            ["dataElement" => "j4HzS4rPYj6", "value" => $name_of_contact_person],
            ["dataElement" => "VdsNUj9NJvL", "value" => $mobile_number],
            ["dataElement" => "SMyZqFsr9rQ", "value" => $email_address_of_contact_person],
            ["dataElement" => "aTgEEzrsXRY", "value" => $organization],
            ["dataElement" => "OD1J33PcpOx", "value" => $number_of_participants],
            ["dataElement" => "hHwkWGfBOQC", "value" => $type_of_training],
            ["dataElement" => "ey7StdOdVCi", "value" => $training_dates_booked],
            ["dataElement" => "T3Ke5Jx4lGp", "value" => $currentDate],
            ["dataElement" => "X5GBez1nxB3", "value" => $county]
            ["dataElement" => "vynbAUseXd2", "value" => $kra_pin_number]
        ];

        if ($fileResourceId) {
            $dataValues[] = [
                "dataElement" => "CQuirKMNHgw",
                "value" => $fileResourceId
            ];
        }

        // ✅ Payment status
        $dataValues[] = [
            "dataElement" => "DVoZ4DKOeBK",
            "value" => ($payment_status === "Yes" ? "Paid" : "Unpaid")
        ];

        // ✅ Payment invoice file if Paid
        if ($paymentInvoiceFileId) {
            $dataValues[] = [
                "dataElement" => "tpBR1T35HvU",
                "value" => $paymentInvoiceFileId
            ];
        }

        $eventData = [
            "events" => [[
                "program" => "urqEiI9nx5C",
                "orgUnit" => "ORwhnDymBpM",
                "occurredAt" => $currentDate,
                "status" => "ACTIVE",
                "dataValues" => $dataValues
            ]]
        ];

        // ✅ Step 4: Send payload to DHIS2
$jsonData = json_encode($eventData);

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
?>

<!DOCTYPE html>
<html>
<head>
    <title>ORGANIZATION/GROUP BOOKING DETAILS...</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f5f9fc; padding: 20px; }
        .container { max-width: 650px; margin: 0 auto; background: white; padding: 25px; border-radius: 10px; box-shadow: 0 0 15px rgba(0,0,0,0.1); }
        h2 { color: #2c3e50; margin-top: 0; border-bottom: 2px solid #3498db; padding-bottom: 10px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: 600; color: #2c3e50; }
        input, select { padding: 12px; width: 100%; border: 1px solid #ddd; border-radius: 4px; font-size: 16px; }
        input:focus, select:focus { border-color: #3498db; outline: none; box-shadow: 0 0 5px rgba(52,152,219,0.5); }
        button { padding: 12px 24px; background: #3498db; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; font-weight: 600; }
        button:hover { background: #2980b9; }
        .message { padding: 15px; border-radius: 4px; margin-bottom: 20px; }
        .success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .response { margin-top: 10px; padding: 10px; background-color: #f8f9fa; border-radius: 4px; font-family: monospace; font-size: 14px; overflow-x: auto; }
    </style>
    <script>
        function toggleInvoiceField() {
            var status = document.getElementById("payment_status").value;
            var invoiceField = document.getElementById("invoice_field");
            invoiceField.style.display = (status === "Yes") ? "block" : "none";
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>ORGANIZATION/GROUP BOOKING DETAILS</h2>
        
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name_of_contact_person">Name of contact person</label>
                <input type="text" id="name_of_contact_person" name="name_of_contact_person" required>

                <label for="mobile_number">Mobile number</label>
                <input type="tel" id="mobile_number" name="mobile_number" required>

                <label for="email_address_of_contact_person">Email address</label>
                <input type="email" id="email_address_of_contact_person" name="email_address_of_contact_person" required>

                <label for="organization">Your organization</label>
                <input type="text" id="organization" name="organization" required>

                <label for="county">County</label>
                <input type="text" id="county" name="county" required>

                <label for="number_of_participants">Number of participants</label>
                <input type="text" id="number_of_participants" name="number_of_participants" required>

                <h3>Upload Participant List (name, telephone, and email)</h3>
                <p>(Excel, PDF, Image)</p>
                <input type="file" name="participant_details_list" accept=".pdf,.jpg,.png,.jpeg,.xlsx,.xls,.xlsm,.xlsb,.xltx" />

                <label for="type_of_training">Type of training</label>
                <input type="text" id="type_of_training" name="type_of_training" required>

                <label for="kra_pin_number">TKRA Pin Number</label>
                <input type="text" id="kra_pin_number" name="kra_pin_number" required>

                <label for="training_dates_booked">Training date booked</label>
                <input type="date" id="training_dates_booked" name="training_dates_booked" required>

                <label for="payment_status">Payment Status</label>
                <select id="payment_status" name="payment_status" onchange="toggleInvoiceField()" required>
                    <option value="">-- Select --</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>

                <div id="invoice_field" style="display:none; margin-top:10px;">
                    <label for="payment_invoice">Upload Payment Invoice</label>
                    <input type="file" id="payment_invoice" name="payment_invoice" accept=".pdf,.jpg,.png,.jpeg" />
                </div>
            </div>
            <button type="submit">Submit to DHIS2</button>
        </form>

        <?php if ($success_message): ?>
            <div class="message success">
                <strong>Success!</strong> <?= $success_message ?>
            </div>
        <?php endif; ?>

        <?php if ($error_message): ?>
            <div class="message error">
                <strong>Error:</strong> <?= $error_message ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>

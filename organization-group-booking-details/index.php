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
            ["dataElement" => "X5GBez1nxB3", "value" => $county],
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organization/Group Booking Details</title>
    <style>
        :root {
            --primary: #3498db;
            --primary-dark: #2980b9;
            --secondary: #2c3e50;
            --success: #27ae60;
            --danger: #e74c3c;
            --light: #f8f9fa;
            --gray: #6c757d;
            --border: #dee2e6;
            --shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f9fc 0%, #e3f2fd 100%);
            color: var(--secondary);
            line-height: 1.6;
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: var(--shadow);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(to right, var(--primary), var(--primary-dark));
            color: white;
            padding: 25px 30px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 28px;
            margin-bottom: 5px;
            font-weight: 100;
        }
        
        .header p {
            opacity: 0.9;
            font-size: 16px;
        }
        
        .form-container {
            padding: 30px;
        }
        
        .form-section {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border);
        }
        
        .form-section:last-of-type {
            border-bottom: none;
        }
        
        .section-title {
            font-size: 20px;
            color: var(--primary);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--primary);
            display: flex;
            align-items: center;
            font-weight: 100;
        }
        
        .section-title i {
            margin-right: 10px;
            font-size: 24px;
            
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group.full-width {
            grid-column: 1 / -1;
        }
         
        .required{
            display: block;
            margin-bottom: 8px;
            font-weight: 100;
            color: var(--secondary);
        }
        
        .required::after {
            content: " *";
            color: var(--danger);
        }
        
        input, select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: 16px;
            transition: all 0.3s;
        }
        
        input:focus, select:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
        }
        
        .file-upload {
            border: 2px dashed var(--border);
            padding: 20px;
            text-align: center;
            border-radius: 6px;
            transition: all 0.3s;
            cursor: pointer;
        }
        
        .file-upload:hover {
            border-color: var(--primary);
            background-color: rgba(52, 152, 219, 0.05);
        }
        
        .file-upload input {
            display: none;
        }
        
        .file-info {
            margin-top: 10px;
            font-size: 14px;
            color: var(--gray);
        }
        
        .payment-section {
            background-color: rgba(52, 152, 219, 0.05);
            padding: 20px;
            border-radius: 8px;
            margin-top: 10px;
        }
        
        .submit-btn {
            background: linear-gradient(to right, var(--primary), var(--primary-dark));
            color: white;
            border: none;
            padding: 15px 30px;
            font-size: 18px;
            font-weight: 100;
            border-radius: 6px;
            cursor: pointer;
            width: 100%;
            transition: all 0.3s;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        }
        
        .submit-btn:active {
            transform: translateY(0);
        }
        
        .message {
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }
        
        .success {
            background-color: rgba(39, 174, 96, 0.1);
            color: var(--success);
            border-left: 4px solid var(--success);
        }
        
        .error {
            background-color: rgba(231, 76, 60, 0.1);
            color: var(--danger);
            border-left: 4px solid var(--danger);
        }
        
        .message-icon {
            margin-right: 10px;
            font-size: 20px;
        }
        
        .response {
            margin-top: 10px;
            padding: 10px;
            background-color: var(--light);
            border-radius: 4px;
            font-family: monospace;
            font-size: 14px;
            overflow-x: auto;
            border-left: 3px solid var(--primary);
        }
        
        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            .form-container {
                padding: 20px;
            }
            
            .header {
                padding: 20px;
            }
            
            .header h1 {
                font-size: 24px;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>ORGANIZATION/GROUP BOOKING DETAILS</h1>
            <p>Please fill in all the required information to book your training session</p>
        </div>
        
        <div class="form-container">
            <?php if ($success_message): ?>
                <div class="message success">
                    <i class="message-icon fas fa-check-circle"></i>
                    <div>
                        <strong>Success!</strong> <?= $success_message ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($error_message): ?>
                <div class="message error">
                    <i class="message-icon fas fa-exclamation-circle"></i>
                    <div>
                        <strong>Error:</strong> <?= $error_message ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <form method="POST" enctype="multipart/form-data">
                <div class="form-section">
                    <h2 class="section-title">
                        <i class="fas fa-user-circle"></i> Contact Information
                    </h2>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="name_of_contact_person" class="required">Name of Contact Person</label>
                            <input type="text" id="name_of_contact_person" name="name_of_contact_person" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="mobile_number" class="required">Mobile Number</label>
                            <input type="tel" id="mobile_number" name="mobile_number" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email_address_of_contact_person" class="required">Email Address</label>
                            <input type="email" id="email_address_of_contact_person" name="email_address_of_contact_person" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="organization" class="required">Organization Name</label>
                            <input type="text" id="organization" name="organization" required>
                        </div>
                    </div>
                </div>
                
                <div class="form-section">
                    <h2 class="section-title">
                        <i class="fas fa-map-marker-alt"></i> Location Details
                    </h2>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="county" class="required">County</label>
                            <input type="text" id="county" name="county" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="kra_pin_number" class="required">KRA Pin Number</label>
                            <input type="text" id="kra_pin_number" name="kra_pin_number" required>
                        </div>
                    </div>
                </div>
                
                <div class="form-section">
                    <h2 class="section-title">
                        <i class="fas fa-users"></i> Training Details
                    </h2>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="number_of_participants" class="required">Number of Participants</label>
                            <input type="number" id="number_of_participants" name="number_of_participants" min="1" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="type_of_training" class="required">Type of Training</label>
                            <input type="text" id="type_of_training" name="type_of_training" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="training_dates_booked" class="required">Training Date</label>
                            <input type="date" id="training_dates_booked" name="training_dates_booked" required>
                        </div>
                    </div>
                    
                    <div class="form-group full-width">
                        <label for="participant_details_list" class="required">Upload Participant List</label>
                        <div class="file-upload" onclick="document.getElementById('participant_details_list').click()">
                            <i class="fas fa-cloud-upload-alt" style="font-size: 40px; color: var(--primary); margin-bottom: 10px;"></i>
                            <p>Click to upload participant list (Excel, PDF, or Image)</p>
                            <p class="file-info">Accepted formats: .pdf, .jpg, .png, .jpeg, .xlsx, .xls, .xlsm, .xlsb, .xltx</p>
                            <input type="file" id="participant_details_list" name="participant_details_list" accept=".pdf,.jpg,.png,.jpeg,.xlsx,.xls,.xlsm,.xlsb,.xltx" required>
                        </div>
                    </div>
                </div>
                
                <div class="form-section">
                    <h2 class="section-title">
                        <i class="fas fa-money-check-alt"></i> Payment Information
                    </h2>
                    
                    <div class="form-group">
                        <label for="payment_status" class="required">Payment Status</label>
                        <select id="payment_status" name="payment_status" onchange="toggleInvoiceField()" required>
                            <option value="">-- Select Payment Status --</option>
                            <option value="Yes">Paid</option>
                            <option value="No">Not Paid Yet</option>
                        </select>
                    </div>
                    
                    <div id="invoice_field" class="payment-section" style="display:none;">
                        <div class="form-group">
                            <label for="payment_invoice">Upload Payment Invoice</label>
                            <div class="file-upload" onclick="document.getElementById('payment_invoice').click()">
                                <i class="fas fa-file-invoice-dollar" style="font-size: 40px; color: var(--primary); margin-bottom: 10px;"></i>
                                <p>Click to upload payment invoice (PDF or Image)</p>
                                <p class="file-info">Accepted formats: .pdf, .jpg, .png, .jpeg</p>
                                <input type="file" id="payment_invoice" name="payment_invoice" accept=".pdf,.jpg,.png,.jpeg">
                            </div>
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="submit-btn">
                    <i class="fas fa-paper-plane" style="margin-right: 10px;"></i> Submit Application
                </button>
            </form>
        </div>
    </div>

    <script>
        function toggleInvoiceField() {
            var status = document.getElementById("payment_status").value;
            var invoiceField = document.getElementById("invoice_field");
            invoiceField.style.display = (status === "Yes") ? "block" : "none";
            
            // Update file input requirement based on payment status
            var invoiceFile = document.getElementById("payment_invoice");
            if (status === "Yes") {
                invoiceFile.setAttribute("required", "required");
            } else {
                invoiceFile.removeAttribute("required");
            }
        }
        
        // Add file name display for better UX
        document.getElementById('participant_details_list').addEventListener('change', function(e) {
            if (this.files.length > 0) {
                const fileName = this.files[0].name;
                this.parentNode.querySelector('p').textContent = `Selected: ${fileName}`;
            }
        });
        
        document.getElementById('payment_invoice').addEventListener('change', function(e) {
            if (this.files.length > 0) {
                const fileName = this.files[0].name;
                this.parentNode.querySelector('p').textContent = `Selected: ${fileName}`;
            }
        });
    </script>
</body>
</html>
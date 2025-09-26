<?php
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['participant_name'])) {
    $participantName = trim($_POST['participant_name']);
    $tbf_employee = $_POST['tbf_employee'];
    $tbf_mobile_number = $_POST['tbf_mobile_number'];
    $tbf_adress_email = $_POST['tbf_adress_email'];
    $tbf_county = $_POST['tbf_county'];
    $tbf_type_of_training = $_POST['tbf_type_of_training'];
    $tbf_booked_date = $_POST['tbf_booked_date'];
    $tbf_pin_number_institution = $_POST['tbf_pin_number_institution'];
    $payment_status = $_POST['tbf_payment_status'];

    $payment_invoice_uid = "";

    // API credentials
    $trackerUrl = "https://monitoring.jocsoft.net/dhis/api/tracker";
    $fileUrl = "https://monitoring.jocsoft.net/dhis/api/fileResources";
    $username = "jack";
    $password = "Jocsoft@2027!!";
    $currentDate = date('Y-m-d');

    // ✅ Step 1: If payment_status is Yes, upload invoice file
    if ($payment_status === "Yes" && isset($_FILES['tbf_payment_invoice']) && $_FILES['tbf_payment_invoice']['error'] === 0) {
        $file_path = $_FILES['tbf_payment_invoice']['tmp_name'];
        $ch = curl_init($fileUrl);
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, [
            'file' => new CURLFile(
                $file_path,
                $_FILES['tbf_payment_invoice']['type'],
                $_FILES['tbf_payment_invoice']['name']
            )
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $uploadResponse = curl_exec($ch);
        curl_close($ch);

        $uploadData = json_decode($uploadResponse, true);
        if (isset($uploadData['response']['fileResource']['id'])) {
            $payment_invoice_uid = $uploadData['response']['fileResource']['id'];
        }
    }

    // ✅ Step 2: Prepare dataValues
    $dataValues = [
        ["dataElement" => "O6e6CSRnway", "value" => $participantName],
        ["dataElement" => "uTcz7QJy7wB", "value" => $tbf_employee],
        ["dataElement" => "YD26UNpEEMh", "value" => $tbf_mobile_number],
        ["dataElement" => "RcWSVrWNLBK", "value" => $tbf_adress_email],
        ["dataElement" => "uURf5eX2VP5", "value" => $tbf_county],
        ["dataElement" => "TKocHRJWffP", "value" => $tbf_type_of_training],
        ["dataElement" => "gSXehXEuk5P", "value" => $tbf_booked_date],
        ["dataElement" => "J9YDz13EBFz", "value" => $currentDate],
        ["dataElement" => "cr1sc6CYNaq", "value" => $tbf_pin_number_institution],
        [
            "dataElement" => "pJxxjthNFNX", // Payment status
            "value" => $payment_status === "Yes" ? "Paid" : "Unpaid"
        ]
    ];

    if ($payment_invoice_uid !== "") {
        $dataValues[] = [
            "dataElement" => "vPSf29ehYN3", // Payment invoice
            "value" => $payment_invoice_uid
        ];
    }

    $eventData = [
        "events" => [[
            "program" => "pxfOMnBkko3",
            "orgUnit" => "ORwhnDymBpM",
            "occurredAt" => $currentDate,
            "status" => "ACTIVE",
            "dataValues" => $dataValues
        ]]
    ];

    // ✅ Step 3: Send to DHIS2
    $jsonData = json_encode($eventData);
    $ch = curl_init($trackerUrl);
    curl_setopt_array($ch, [
        CURLOPT_USERPWD => "$username:$password",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $jsonData,
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        CURLOPT_SSL_VERIFYPEER => false
    ]);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    if ($httpCode === 200 || $httpCode === 201) {
        $message = "✅ Success! Participant '$participantName' was added successfully.";
        $messageType = "success";
        
        // ✅ Clear the form by setting a flag
        $clearForm = true;
    } else {
        $message = "❌ Error: HTTP $httpCode. Response: $response";
        if ($error) $message .= " | cURL Error: $error";
        $messageType = "error";
        $clearForm = false;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  <title>INDIVIDUAL BOOKING DETAILS</title>
  <style>
    :root {
      --primary: #2c3e50;
      --secondary: #3498db;
      --accent: #2980b9;
      --success: #27ae60;
      --danger: #e74c3c;
      --text: #333;
      --border: #ddd;
    }
    body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 20px; background: linear-gradient(135deg, #f5f9fc 0%, #e8f4fc 100%); color: var(--text); }
    .container { max-width: 960px; margin: 0 auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
    h1 { color: var(--primary); text-align: center; margin-bottom: 24px; font-weight: 600; }
    .form-group { margin-bottom: 20px; display:flex; flex-direction: column; gap: 10px; width: 100%; }
    label { font-weight: 500; color: var(--primary); }
    input, select { padding: 12px; border: 1px solid var(--border); border-radius: 6px; font-size: 16px; background: #fff; transition: border-color .2s, box-shadow .2s; }
    input:focus, select:focus { outline: none; border-color: var(--secondary); box-shadow: 0 0 0 3px rgba(52,152,219,.2); }
    button { background: linear-gradient(90deg, var(--secondary), var(--accent)); color: white; padding: 14px 30px; border: none; border-radius: 6px; cursor: pointer; font-size: 16px; width: 100%; transition: transform .1s, box-shadow .2s; box-shadow: 0 4px 10px rgba(52,152,219,.25); }
    button:hover { transform: translateY(-1px); box-shadow: 0 6px 14px rgba(52,152,219,.35); }
    .message { padding: 12px; margin: 20px 0; border-radius: 6px; text-align: center; }
    .success { background-color: rgba(39,174,96,.1); color: var(--success); border-left: 4px solid var(--success); }
    .error { background-color: rgba(231,76,60,.1); color: var(--danger); border-left: 4px solid var(--danger); }
    @media (max-width: 768px) { body { padding: 12px; } .container { padding: 20px; } }
  </style>
  
</head>
<body>
  <div class="container">
    <h1>INDIVIDUAL BOOKING DETAILS</h1>

    <?php if (isset($message)): ?>
      <div class="message <?php echo $messageType; ?>">
        <?php echo htmlspecialchars($message); ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="" enctype="multipart/form-data" id="bookingForm">
      <div class="form-group">
        <label>Participant Name</label>
        <input type="text" name="participant_name" required value="<?php echo (isset($clearForm) && $clearForm) ? '' : ($_POST['participant_name'] ?? ''); ?>">

        <label>Employee Name</label>
        <input type="text" name="tbf_employee" required value="<?php echo (isset($clearForm) && $clearForm) ? '' : ($_POST['tbf_employee'] ?? ''); ?>">

        <label>Mobile number</label>
        <input type="tel" name="tbf_mobile_number" required value="<?php echo (isset($clearForm) && $clearForm) ? '' : ($_POST['tbf_mobile_number'] ?? ''); ?>">

        <label>Email address</label>
        <input type="email" name="tbf_adress_email" required value="<?php echo (isset($clearForm) && $clearForm) ? '' : ($_POST['tbf_adress_email'] ?? ''); ?>">

        <label>County</label>
        <input type="text" name="tbf_county" value="<?php echo (isset($clearForm) && $clearForm) ? '' : ($_POST['tbf_county'] ?? ''); ?>">

        <label>Type of training</label>
        <input type="text" name="tbf_type_of_training" required value="<?php echo (isset($clearForm) && $clearForm) ? '' : ($_POST['tbf_type_of_training'] ?? ''); ?>">

        <label>Training date booked</label>
        <input type="date" name="tbf_booked_date" required value="<?php echo (isset($clearForm) && $clearForm) ? '' : ($_POST['tbf_booked_date'] ?? ''); ?>">

        <label>KRA Pin Number</label>
        <input type="text" name="tbf_pin_number_institution" required value="<?php echo (isset($clearForm) && $clearForm) ? '' : ($_POST['tbf_pin_number_institution'] ?? ''); ?>">

        <label>Payment Status</label>
        <select name="tbf_payment_status" id="tbf_payment_status" onchange="toggleInvoiceInput()">
          <option value="No" <?php if(((isset($clearForm) && $clearForm) ? '' : ($_POST['tbf_payment_status'] ?? ''))==='No') echo 'selected'; ?>>No</option>
          <option value="Yes" <?php if(((isset($clearForm) && $clearForm) ? '' : ($_POST['tbf_payment_status'] ?? ''))==='Yes') echo 'selected'; ?>>Yes</option>
        </select>

        <div id="invoiceField" style="display:none;">
          <label>Upload Participant details list (Name, telephone, and email)</label>
          <input type="file" name="tbf_payment_invoice" accept=".pdf,.jpg,.png,.jpeg,.xlsx,.xls,.xlsm,.xlsb,.xltx /*" />
        </div>
      </div>

      <button type="submit">Add Participant</button>
    </form>
  </div>

  <script>
    function toggleInvoiceInput() {
      const status = document.getElementById('tbf_payment_status').value;
      document.getElementById('invoiceField').style.display = status === "Yes" ? 'block' : 'none';
    }
    // Trigger once on load (to restore selection after error)
    toggleInvoiceInput();
    
    // Clear file input on successful form submission
    <?php if (isset($clearForm) && $clearForm): ?>
      document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('bookingForm');
        form.reset();
      });
    <?php endif; ?>
  </script>
</body>
</html>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$success_message = "";
$error_message = "";

// API credentials
$url = "https://monitoring.nacada.go.ke/api/dataValueSets";
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
    $selected_quarter = $_POST['selected_quarter'];
    $quarter_value = $_POST[$selected_quarter] ?? 0;
    
    // Initialize all quarters to 0
    $ada_q1 = 0;
    $ada_q2 = 0;
    $ada_q3 = 0;
    $ada_q4 = 0;
    
    // Set the selected quarter value
    switch($selected_quarter) {
        case 'ada_q1':
            $ada_q1 = $quarter_value;
            break;
        case 'ada_q2':
            $ada_q2 = $quarter_value;
            break;
        case 'ada_q3':
            $ada_q3 = $quarter_value;
            break;
        case 'ada_q4':
            $ada_q4 = $quarter_value;
            break;
    }
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
                "dataElement" => "lmOU0RK4aYg",
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
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: white;
            min-height: 100vh;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .container {
            max-width: 1200px;
            width: 100%;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            color: white;
        }

        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            color: #000;
        }

        .header p {
            font-size: 1.1rem;
            opacity: 0.9;
            color: #000;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
        }

        .card {
            background: white;
            border-radius: 15px;
            padding: 30px;
        }

        .card-header {
            border-bottom: 2px solid #667eea;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }

        .card-header h2 {
            color: #333;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-header h2 i {
            color: #667eea;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 100;
            color: #444;
            font-size: 0.95rem;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="number"],
        select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e1e5ee;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: #f8f9fa;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="tel"]:focus,
        input[type="number"]:focus,
        select:focus {
            outline: none;
            border-color: #667eea;
            background-color: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        input[readonly] {
            background-color: #e9ecef;
            cursor: not-allowed;
        }

        .submit-btn {
            grid-column: 1 / -1;
            text-align: center;
            margin-top: 20px;
        }

        button {
            background: black;
            color: white;
            border: none;
            padding: 15px 40px;
            font-size: 1.1rem;
            font-weight: 100;
            cursor: pointer;
            width: 100%;
            border-radius: 8px;
            transition: all 0.3s ease
        }

        .message {
            grid-column: 1 / -1;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 100;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .required::after {
            content: " *";
            color: #e74c3c;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h3 style="color:#000">FORM-ANNUAL WORK PLAN FORMAT</h3>
            <p>Please fill out all the required fields below</p>
        </div>

        <?php if ($success_message): ?>
            <div class="message success"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <?php if ($error_message): ?>
            <div class="message error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-grid">
                <!-- Card 1: Institution Details -->
                <div class="card">
                    <div class="card-header">
                        <h2>📊 Institution Information</h2>
                    </div>
                    
                    <div class="form-group">
                        <label for="value" class="required">ADA-Name of the Institution</label>
                        <input type="text" name="value" id="value" required />
                    </div>

                    <div class="form-group">
                        <label for="parent_ministry" class="required">Parent Ministry</label>
                        <input type="text" name="parent_ministry" id="parent_ministry" required />
                    </div>

                    <div class="form-group">
                        <label for="staff_institution" class="required">Number of staff in the Institution</label>
                        <input type="number" name="staff_institution" id="staff_institution" required />
                    </div>

                    <div class="form-group">
                        <label for="where_applicable">Number of students in the institution (where applicable)</label>
                        <input type="number" name="where_applicable" id="where_applicable" />
                    </div>

                    <div class="form-group">
                        <label for="activities01" class="required">Activities</label>
                        <input type="text" name="activities01" id="activities01" required />
                    </div>
                </div>

                <!-- Card 2: Contact & Quarterly Details -->
                <div class="card">
                    <div class="card-header">
                        <h2>👥 Contact & Quarterly Data</h2>
                    </div>

                    <div class="form-group">
                        <label for="contact_person" class="required">Contact Person Phone Number</label>
                        <input type="tel" name="contact_person" id="contact_person" required placeholder="e.g +254700000000" pattern="[+]?[0-9\s\-\(\)]{10,}" title="Please enter a valid phone number" />
                    </div>

                    <div class="form-group">
                        <label for="email_address02" class="required">Email Address</label>
                        <input type="email" name="email_address02" id="email_address02" required />
                    </div>

                    <div class="form-group">
                        <label for="ADA_Telephone_Number" class="required">Telephone Number</label>
                        <input type="tel" name="ADA_Telephone_Number" id="ADA_Telephone_Number" required />
                    </div>

                    <div class="form-group">
                        <label for="selected_quarter" class="required">Select Quarter</label>
                        <select name="selected_quarter" id="selected_quarter" required onchange="toggleQuarterField()">
                            <option value="">Select a quarter...</option>
                            <option value="ada_q1">ADA-Q1</option>
                            <option value="ada_q2">ADA-Q2</option>
                            <option value="ada_q3">ADA-Q3</option>
                            <option value="ada_q4">ADA-Q4</option>
                        </select>
                    </div>

                    <div class="form-group" id="quarter_field_container" style="display: none;">
                        <label id="quarter_label" class="required"></label>
                        <input type="number" id="quarter_value" name="" required oninput="calculateTotal()" />
                    </div>

                    <div class="form-group">
                        <label for="quarterly_totals" class="required">Quarterly totals</label>
                        <input type="number" name="quarterly_totals" id="quarterly_totals" readonly />
                    </div>
                </div>
            </div>

            <div class="submit-btn">
                <button type="submit">Submit</button>
            </div>
        </form>
    </div>

    <script>
        function toggleQuarterField() {
            const selectedQuarter = document.getElementById('selected_quarter').value;
            const container = document.getElementById('quarter_field_container');
            const label = document.getElementById('quarter_label');
            const input = document.getElementById('quarter_value');
            
            if (selectedQuarter) {
                // Show the container
                container.style.display = 'block';
                
                // Set the label text
                const quarterNames = {
                    'ada_q1': 'ADA-Q1',
                    'ada_q2': 'ADA-Q2',
                    'ada_q3': 'ADA-Q3',
                    'ada_q4': 'ADA-Q4'
                };
                label.textContent = quarterNames[selectedQuarter];
                
                // Set the input name attribute
                input.name = selectedQuarter;
                
                // Clear the value and total
                input.value = '';
                document.getElementById('quarterly_totals').value = '';
            } else {
                // Hide the container
                container.style.display = 'none';
                input.name = '';
            }
        }
        
        function calculateTotal() {
            const quarterValue = document.getElementById('quarter_value').value;
            const totalField = document.getElementById('quarterly_totals');
            
            if (quarterValue && !isNaN(quarterValue)) {
                // For now, the quarterly total is just the same as the quarter value
                // You can modify this logic if you need different calculations
                totalField.value = quarterValue;
            } else {
                totalField.value = '';
            }
        }
    </script>
</body>
</html>